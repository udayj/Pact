<?php
require_once 'validateSession.php';
session_start();
$status=validateSession();
if($status)
{
  header('Location: summary.php');
}
if(isset($_SESSION['not_register']))
{
  if($_SESSION['not_register']=='true')
  {
    unset($_SESSION['not_register']);
    echo $_SESSION['reason'];
  }
}
?>

<html>
<head>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function submitForm()
{
  var status=validateFields();
  if(status==1)
  {
    document.register.submit();
  }
}
function validateFields()
{
  var username=document.getElementById("username").value;
  var password=document.getElementById("password").value;
  var emailid=document.getElementById("emailid").value;
  
  if(jQuery.trim(username)=="")
  {
    document.getElementById("status").innerHTML="username cannot be empty";
    return 0;
  }
  else if(jQuery.trim(password)=="")
  {
    document.getElementById("status").innerHTML="password cannot be empty";
    return 0;
  }
  else if(jQuery.trim(emailid)=="")
  {
    document.getElementById("status").innerHTML="emailid cannot be empty";
    return 0;
  }
  return 1;
// username/password should not have spaces
// email id should be well formed

}
function validate(text)
{
  var xmlHttp=new XMLHttpRequest();
  xmlHttp.open("POST","checkAvailability.php",true);
  xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlHttp.send("username="+text);
  //alert("working?");
  xmlHttp.onreadystatechange=function()
  {
    if(xmlHttp.readyState==4 && xmlHttp.status==200)
    {
       document.getElementById("username_status").innerHTML=xmlHttp.responseText;
    }
  }
}
</script>
<body>
<form action="confirmRegistration.php" method="post" name="register" >
  Username: <input id="username" type="text" name="username" onkeyup="validate(this.value)"/><br />
  Password: <input id="password" type="text" name="password" /><br />
  Email Id: <input id="emailid" type="text" name="emailid" /><br />
  <input type="button" value="Submit" onClick="submitForm()"/>
  
</form>
<div id="username_status"></div>
<div id="status"></div>
</body>
</html>

