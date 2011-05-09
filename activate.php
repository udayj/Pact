<?php
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'logger.php';

//Shared Configuration changed to use db 0
$redis = new Predis\Client($single_server);
if(!isset($_GET['act']))
{
  logMessage('Activation id not set');
  echo 'Incorrect Activation link';
}
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
    logMessage('Incorrect activation link accessed activationid:'.$activationid);
    echo 'Incorrect activation link';
  }
}
else
{
  logMessage('Incorrect activation link accessed activationid:'.$activationid);
  echo 'Incorrect activation link';
}
?>
