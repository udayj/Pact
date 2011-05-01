<?php 
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'validateSession.php';
$redis = new Predis\Client($single_server);

$status=validateSession();
if($status!=true)
{
  header('refresh:5;url=mainpage.php');
}
else
{
  echo 'You are logged in <br>';
}


$uid=$_SESSION['uid'];
$expenses=$redis->lrange('uid:'.$uid.':expenses',0,-1);
foreach($expenses as $expense)
{
 // echo $expense;
  $date=getExpenseData($uid,$expense,'date');
  $amt=getExpenseData($uid,$expense,'amt');
  $desc=getExpenseData($uid,$expense,'desc');
  $tags=$redis->smembers("uid:".$uid.":eid:".$expense.":tags");
  $tagnames=implode(",",$tags); 
  echo $date.'  '.$amt.'  '.$desc.' '.$tagnames.'<br>';
}
function getExpenseData($uid,$id,$field)
{
  global $redis;
 // echo 'uid:'.$uid.':eid:'.$id.':'.$field.'<br>';
  return $redis->get('uid:'.$uid.':eid:'.$id.':'.$field);
}

?>
