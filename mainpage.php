<?php
require_once 'validateSession.php';
require_once 'logger.php';
session_start();

?>
<html>
<head>
<script type="text/javascript">
function signup()
{
  window.location='register.php';
}
</script>
</head>
<body>


<?php
//logMessage('Accessed mainpage.php');
$status=validateSession();
if(!$status)
{
  echo "New User ?";
  $errormsg="";
  $activate="";
//Check if username/password was wrong
  if(isset($_SESSION['incorrect']) && $_SESSION['incorrect']=='true')
  {
    $errormsg="Incorrect Username or Password";
  }
//Else check if account is deactivated
else if(isset($_SESSION['notactivate']) && $_SESSION['notactivate']=='true')
  {
    
    $activate='Account not yet activated ... pls click on link sent to your email to activate';
  }
//Unset the variables for next submition
  unset($_SESSION['incorrect']);
  unset($_SESSION['notactivate']);
?>
<input type="button" value="SignUp" onClick="signup()">
<div name="error"><?php echo $errormsg.$activate; ?> </div> 
<form action="login.php" method="post">
  Username: <input type="text" name="username" /><br />
  Password: <input type="text" name="password" /><br />
  <input type="submit" value="Submit" />
</form>
</body>
</html>
<?php
}
else
{
    //User is logged in....redirect to summary.php page
    echo "Logged in currently";
    echo "Hi ".$_SESSION['username'];
    header('Location: summary.php');
    
  
}

?>
