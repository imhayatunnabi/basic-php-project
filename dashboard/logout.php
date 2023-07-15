<?php  
	ob_start();
	session_start();
	session_destroy();
	session_unset();
	
	header('location: ../admin_login.php');
		
?>