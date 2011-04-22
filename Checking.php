<?php
session_start();
//echo "Checking with github"

if(!isset($_GET['username']) || !isset($_GET['password']))
{
  echo 'Username or password not supplied';
}
else
{
	echo 'Ok username, password given'.'<br>';
	$username=$_GET['username'];
	$password=$_GET['password'];
	if($username=='udayj')
	{
	  if($password=='password')
	  {
	     echo 'Correct username password'.'<br>';
             echo $_COOKIE['PHPSESSID'].'<br>';
	  }
	  else
	  {
	     echo 'Incorrect username or password given'.'<br>';
	  }
	}
	else
	{
	    echo 'Incorrect username or password given'.'<br>';
	}
}
?>
