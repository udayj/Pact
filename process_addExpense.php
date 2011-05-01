<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
$status=validateSession();
if($status!=true)
{
  header("refresh:5;url=mainpage.php");
}
else
{
  echo "You are logged in";
}

function validateSession()
{
  if(!isset($_SESSION["logged in"]))
  {
    echo "You are not logged in currently....redirecting to login page";
    
    return false;
  }
  else
  {
     if($_SESSION["logged in"]!="true")
     {
        echo "You have been logged off....redirecting to login page";
       
        return false;
     }
     else
     {
       return true;
     }
  }
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


  $eid=$redis->incr("uid:".$uid.":nextExpenseId");
  $status=$redis->lpush("uid:".$uid.":expenses",$eid);

$redis->set("uid:".$uid.":eid:".$eid.":amt",$amt);
$redis->set("uid:".$uid.":eid:".$eid.":date",$date);
$redis->set("uid:".$uid.":eid:".$eid.":desc",$desc);
$redis->del("uid:".$uid.":eid:".$eid.":tags");

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
