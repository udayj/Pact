<?php
session_start();
if(isset($_SESSION['logged in']))
{
  if($_SESSION['logged in']=='true')
  {
    echo $_SESSION['counter'].'<br>';
  }
  else
  {
    echo 'You are not logged in';
    header('refresh:5;url=mainpage.php');
  }
}
else
{
  echo 'You are not logged in...logged in var not set';
    header('refresh:5;url=mainpage.php');
}

?>
