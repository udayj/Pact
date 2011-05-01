<?php
session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

$status=validateSession();
if($status!=true)
{
  header("refresh:5;url=mainpage.php");
}
else
{
  echo "You are logged in";
}

function validateSession()
{
  if(!isset($_SESSION["logged in"]))
  {
    echo "You are not logged in currently....redirecting to login page";
    
    return false;
  }
  else
  {
     if($_SESSION["logged in"]!="true")
     {
        echo "You have been logged off....redirecting to login page";
       
        return false;
     }
     else
     {
       return true;
     }
  }
}
?>

<!DOCTYPE html>
<html
<head>
<script type="text/javascript">
function submitForm()
{
  alert("submitting");
  document.addexpense.submit();
}
</script>
</head>
<body>
<form name="addexpense" action="process_addExpense.php" method="POST">
Date : <input type="date" name="date" />
Amount: <input type="number" min="0" name="amount" placeholder="Enter the amount" />
Description <input type="text" name="desc" autofocus/>
Tags : <input type="text" name="tags" />
<input type="submit" name="submit" value="submit" onClick="submitForm()" />
</form>
</body>
</html>
