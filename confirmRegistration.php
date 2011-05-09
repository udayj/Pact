<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'logger.php';

//Shared Configuration changed to use db 0
$redis = new Predis\Client($single_server);

if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['emailid']))
{
   error('some of the fields were empty');
    
}
$username=$_POST['username'];
$password=$_POST['password'];
$emailid=$_POST['emailid'];

if($username=='' || $password=='' || $emailid=='')
{
    error('some of the fields were empty');
} 
else if($redis->sismember('usernames',$username))
{
  error('username unavailable');
}
else if($redis->sismember('email',$emailid))
{
  error('email id already linked to an account');
}
else{
$redis->sadd('email',$emailid);
logMessage('Emailid added to email set for user:'.$emailid);
$status=$redis->sadd('usernames',$username);
logMessage('Username added to usernames set for user:'.$emailid);
if($status==1)
{
  $userid=$redis->incr('global:nextUserId');
  logMessage('uid:'.$userid.' generated for user:'.$emailid);
  $redis->set('uid:'.$userid.':username',$username);
  $redis->set('username:'.$username.':uid',$userid);
  $redis->set('uid:'.$userid.':password',md5($password));
  $redis->set('uid:'.$userid.':emailid',$emailid);
  $activationid=md5($emailid);
  $redis->set('uid:'.$userid.':activationid',$activationid);
  $redis->set('activationid:'.$activationid,'false');
  logMessage('User registered user:'.$emailid);
  session_regenerate_id();
  $_SESSION['registered']='true';
  $to=$emailid;
  $from='jhunjhunwala.uday@gmail.com';
  $subject='Welcome to PACT';
  $message='http://localhost/Pact/activate.php?act='.$activationid;
  $headers='From:'.$from;
  $mailStatus=mail($to,$subject,$message,$headers);
  
  if($mailStatus==false)
  {
    logMessage('Mail sending(1) failed for user:'.$emailid);
    $mailStatus=mail($to,$subject,$message,$headers);
    
    if($mailStatus==false)
    {
      logMessage('Mail sending failed(2) for user:'.$emailid);
      undoActions($username,$emailid,$password,$userid,$activationid);
      error('Technical problems...please try again later');
    }
  }
  logMessage('Regiatration complete .... redirecting to mainpage');
  header('Location: welcome.php');
}
else
{
  error('username unavailable');
}
}
function error($message)
{
  $_SESSION['not_register']='true';
  $_SESSION['reason']=$message;
  header('Location: register.php');
}
function undoActions($username,$emailid,$password,$userid,$activationid)
{
  logMessage('Undo action called for user:'.$emailid);
  global $redis;
  $redis->srem('email',$emailid);
  $redis->srem('usernames',$username);
  $redis->decr('global:nextUserId');
 $redis->del('uid:'.$userid.':username');
  $redis->del('username:'.$username.':uid');
  $redis->del('uid:'.$userid.':password');
  $redis->del('uid:'.$userid.':emailid');
    $redis->del('uid:'.$userid.':activationid');
  $redis->del('activationid:'.$activationid);
}
?>
