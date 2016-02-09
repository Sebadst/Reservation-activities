<?php 
include('functions.php');

if(isset($_COOKIE['testsds']) && $_COOKIE['testsds']=='1'){ 

	myRedirect();
}
else{           // show the message 
	echo("Cookie disabilitati! Abilitarli per potere utilizzare il sito");
}

include('header.php');

?>


  
  