<?php
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

//Shared Configuration changed to use db 0
$redis = new Predis\Client($single_server);
$activationid=$_GET['act'];
$status=$redis->get('activationid:'.$activationid);
if($status)
{
  if($status=='false')
  {
    $redis->set('activationid:'.$activationid,'true');
    echo 'Account activated !!!!';
    echo 'Redirecting to login page';
    header('refresh:5;url=mainpage.php');
  }
  else
  {
    echo 'incorrect activation link';
  }
}
else
{
  echo 'incorrect activation link';
}
?>
