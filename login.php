<?php
session_start();
//echo "Checking with github"

if(!isset($_POST['username']) || !isset($_POST['password']))
{
  echo 'Username or password not supplied';
}
else
{
	echo 'Ok username, password given'.'<br>';
	$username=$_POST['username'];
	$password=$_POST['password'];
	if($username=='udayj')
	{
	  if($password=='password')
	  {
	     echo 'Correct username password'.'<br>';
             echo 'Logged in';
             echo $_COOKIE['PHPSESSID'].'<br>';
             $_SESSION['logged in']='true';
             $_SESSION['counter']=12345;
             header('refresh:5;url=mainpage.php');
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
