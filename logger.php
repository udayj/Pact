<?php
function logMessage($message)
{
  $file=fopen("message.log","a");
  $str='['.date('Y/m/d h:i:s',mktime()).'] '.$message;
  fwrite($file,$str."\n");
  fclose($file);
}
?>
