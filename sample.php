<?php
session_start();
if(!isset($_SESSION['logged in']))
{
  echo "Not logged in";
  header('Location: mainpage.php');
  
}
else
{
  if($_SESSION['logged in']=='true')
  {
    echo "Logged in currently  ";
    echo "Hi ".$_SESSION['username'];
    
  }
  else
  {
    echo "Not logged in";
    unset($_SESSION['logged in']);
    header('Location: mainpage.php');
  }
}
?>
