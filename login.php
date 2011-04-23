<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
//echo "Checking with github"

$redis = new Predis\Client($single_server);

if(!isset($_POST['username']) || !isset($_POST['password']))
{
  echo 'Username or password not supplied';
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
		     header('refresh:5;url=mainpage.php');
	     }
             else
             {
                echo 'Account not yet activated	';
                header('refresh:5;url=mainpage.php');
             }
	  }
	  else
	  {
	     echo 'Incorrect username or password given'.'<br>';
             header('refresh:5;url=mainpage.php');
	  }
	}
	else
	{
	    echo 'Incorrect username or password given'.'<br>';
	}
}
?>
