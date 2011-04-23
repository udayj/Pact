<?php
 require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

//Shared Configuration changed to use db 0
$redis = new Predis\Client($single_server);


if(!isset($_POST['username']) || $_POST['username']=='')
{
  echo "username unavailable";
}
else
{
  $username=$_POST['username'];
  $status =$redis->sismember('usernames',$username);
  if($status)
  {
    if($status==1)
    {
       echo "username unavailable";
    }
    else
    {
      echo "username available";
    }
  }
  else
    {
      echo "username available";
    }
}

?>
