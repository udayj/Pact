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
$eid=$_GET['eid'];
$redis->lrem("uid:".$uid.":expenses",1,$eid);
$redis->del("uid:".$uid.":eid:".$eid.":date");
$redis->del("uid:".$uid.":eid:".$eid.":amt");
$redis->del("uid:".$uid.":eid:".$eid.":desc");
$tags=$redis->smembers("uid:".$uid.":eid:".$eid.":tags");
$redis->del("uid:".$uid.":eid:".$eid.":tags");
foreach($tags as $tag)
{
  $redis->srem("uid:".$uid.":tagname:".$tag,$eid);
}

echo "done";

header("refresh:5;url=summary.php");

?>
