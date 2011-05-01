<?php

session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'validateSession.php';

$status=validateSession();
if($status!=true)
{
  header("refresh:5;url=mainpage.php");
}
else
{
  echo "You are logged in";
}


echo "Processing .... <br>";
$date=$_POST["date"];
$amt=$_POST["amount"];
$desc=$_POST["desc"];
$tags=$_POST["tags"];
$tagArray=getTags($tags);
print_r ($tagArray);

$uid=$_SESSION["uid"];
$redis = new Predis\Client($single_server);


  $eid=$_POST["eid"];
  //$status=$redis->lpush("uid:".$uid.":expenses",$eid);

$redis->set("uid:".$uid.":eid:".$eid.":amt",$amt);
$redis->set("uid:".$uid.":eid:".$eid.":date",$date);
$redis->set("uid:".$uid.":eid:".$eid.":desc",$desc);
$tags=$redis->smembers("uid:".$uid.":eid:".$eid.":tags");
$redis->del("uid:".$uid.":eid:".$eid.":tags");

foreach($tags as $tag)
{
  $redis->srem("uid:".$uid.":tagname:".$tag,$eid);
}
foreach($tagArray as $tag)
{
  $redis->sadd("uid:".$uid.":eid:".$eid.":tags",$tag);
  $redis->sadd("uid:".$uid.":tagname:".$tag,$eid);
}
echo "Expense processed ...redirecting to summary page";
header("refresh:5;url=summary.php");

function getTags($tags)
{
  $tagArray=explode(',',$tags);
  return $tagArray;
}
?>
