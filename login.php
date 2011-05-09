<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'logger.php';
//echo "Checking with github"

$redis = new Predis\Client($single_server);

if(!isset($_POST['username']) || !isset($_POST['password']))
{
  errormsg();
}
else
{
	echo 'Ok username, password given'.'<br>';
	$username=$_POST['username'];
	$password=$_POST['password'];
        
        $uid=$redis->get('username:'.$username.':uid');
        if($uid)
        {
	  if(md5($password)==$redis->get('uid:'.$uid.':password'))
	  {
             $activationid=$redis->get('uid:'.$uid.':activationid');
             if($redis->get('activationid:'.$activationid)=='true')
             {
		     echo 'Correct username password'.'<br>';
		     echo 'Logged in';
		     echo $_COOKIE['PHPSESSID'].'<br>';
		     session_regenerate_id();
		     $_SESSION['logged in']='true';
		     $_SESSION['username']=$username;
		     $_SESSION['uid']=$uid;
		     header('Location: mainpage.php');
	     }
             else
             {
                logMessage('Accessed account without activation');
                $_SESSION['notactivate']='true';
                //echo 'Account not yet activated	';
                header('Location: mainpage.php');
             }
	  }
	  else
	  {
	   //  echo 'Incorrect username or password given'.'<br>';
             logMessage('Incorrect password used');
             errormsg();
           //  header('refresh:5;url=mainpage.php');
	  }
	}
	else
	{
           logMessage('Incorrect username used');
           errormsg();
	   // echo 'Incorrect username or password given'.'<br>';
	}
}
function errormsg()
{
  $_SESSION['incorrect']='true';
  header('Location: mainpage.php');
}
?>
