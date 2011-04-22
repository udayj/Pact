<?php
session_start();
?>
<html>
<body>


<?php
if(!isset($_SESSION['logged in']))
{
  echo "Not logged in";
?>

<form action="login.php" method="post">
  Username: <input type="text" name="username" /><br />
  Password: <input type="text" name="password" /><br />
  <input type="submit" value="Submit" />
</form>
<?php
}
else
{
  if($_SESSION['logged in']=='true')
  {
    echo "Logged in currently";
    
  }
  else
  {
    echo "Not logged in";
    unset($_SESSION['logged in']);
    header('Location: mainpage.php');
  }
}

?>
