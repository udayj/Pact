<?php

function validateSession()
{
  if(!isset($_SESSION['logged in']))
  {
   // echo 'You are not logged in currently....redirecting to login page';
    
    return false;
  }
  else
  {
     if($_SESSION['logged in']!='true')
     {
    //    echo 'You have been logged off....redirecting to login page';
       
        return false;
     }
     else
     {
       return true;
     }
  }
}


?>
