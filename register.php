<?php
session_start();
if(isset($_SESSION['not_register']))
{
  if($_SESSION['not_register']=='true')
  {
    unset($_SESSION['not_register']);
    echo 'Username already in use';
  }
}
?>

<html>
<head>
<script type="text/javascript">
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
<form action="confirmRegistration.php" method="post">
  Username: <input type="text" name="username" onkeyup="validate(this.value)"/><br />
  Password: <input type="text" name="password" /><br />
  Email Id: <input type="text" name="emailid" /><br />
  <input type="submit" value="Submit" />
  
</form>
<div id="username_status">original</div>
</body>
</html>

