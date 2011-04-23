<?php


 $to='jhunjhunwala.uday@gmail.com';
  $from='jhunjhunwala.uday@gmail.com';
  $subject='Welcome to PACT';
  $message='This is a check http://localhost/Pact/activate.php?act=12345';
  $headers='From:'.$from;
  $status=mail($to,$subject,$message,$headers);
  echo $status;
 //echo phpinfo();
?>
