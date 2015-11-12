<?php	
ob_start();
session_start();
if((!isset($_SESSION['session_admin_id']))  || (!isset($_SESSION['session_admin_role'])) )
	{
		header("Location: index.php");
	}
?>
<?php
//define("SSL_INSTALLED",1);
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME'].":/an_employee/");
}else{
//	if(SSL_INSTALLED == 1 && $_SERVER['SERVER_NAME'] != 'employee_project.com'){
//		$http = "https";
//	}else{
//		$http = "http";
//	}
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME']."/emp/");     
}
?>	