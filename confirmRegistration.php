<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

//Shared Configuration changed to use db 0
$redis = new Predis\Client($single_server);

if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['emailid']))
{
   $_SESSION['not_register']='true';
   echo "prob 1";
  //header('Location: register.php');
}
$username=$_POST['username'];
$password=$_POST['password'];
$emailid=$_POST['emailid'];
echo $username.'-'.$password.'-'.$emailid.'-';
if($username=='' || $password=='' || $emailid=='')
{
    $_SESSION['not_register']='true';
   //echo "prob 2";
   header('Location: register.php');
} 
else if($redis->sismember('usernames',$username))
{
  $_SESSION['not_register']='true';
  //echo "prob 3";
  header('Location: register.php');
}
else{
$status=$redis->sadd('usernames',$username);
if($status)
{
  $userid=$redis->incr('global:nextUserId');
  $redis->set('uid:'.$userid.':username',$username);
  $redis->set('username:'.$username.':uid',$userid);
  $redis->set('uid:'.$userid.':password',md5($password));
  $redis->set('uid:'.$userid.':emailid',$emailid);
  $activationid=md5($emailid);
  $redis->set('uid:'.$userid.':activationid',$activationid);
  $redis->set('activationid:'.$activationid,'false');
  session_regenerate_id();
  $_SESSION['registered']='true';
  $to=$emailid;
  $from='jhunjhunwala.uday@gmail.com';
  $subject='Welcome to PACT';
  $message='http://localhost/Pact/activate.php?act='.$activationid;
  $headers='From:'.$from;
  mail($to,$subject,$message,$headers);
  header('Location: welcome.php');
}
}
?>
