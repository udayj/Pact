<?php

session_start();
require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';
require_once 'validateSession.php';
$redis = new Predis\Client($single_server);
$status=validateSession();
if($status!=true)
{
  header('refresh:5;url=mainpage.php');
}
else
{
  echo 'You are logged in <br>';
}

$uid=$_SESSION['uid'];
$eid=$_GET["eid"];
$date=getExpenseData($uid,$eid,'date');
$amt=getExpenseData($uid,$eid,'amt');
$desc=getExpenseData($uid,$eid,'desc');
$tags=$redis->smembers("uid:".$uid.":eid:".$eid.":tags");
$tagnames=implode(",",$tags); 

function getExpenseData($uid,$id,$field)
{
  global $redis;
 // echo 'uid:'.$uid.':eid:'.$id.':'.$field.'<br>';
  return $redis->get('uid:'.$uid.':eid:'.$id.':'.$field);
}


?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
function submitForm()
{
  alert("submitting");
  document.editexpense.submit();
}
</script>
</head>
<body>
<form name="editexpense" action="process_editExpense.php" method="POST">
Date : <input type="date" name="date" value="<?php echo $date; ?>"/>
Amount: <input type="number" min="0" name="amount"  value="<?php echo $amt; ?>"/>
Description <input type="text" name="desc" value="<?php echo $desc; ?>"/>
Tags : <input type="text" name="tags" value="<?php echo $tagnames ?>"/>
<input type="hidden" name="eid" value="<?php echo $eid; ?>" />
<input type="submit" name="submit" value="submit" onClick="submitForm()" />
</form>
</body>
</html>
