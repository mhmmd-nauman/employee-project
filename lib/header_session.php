<?php	
ob_start();
session_start();
if((!isset($_SESSION['session_admin_id']))  || (!isset($_SESSION['session_admin_role'])) )
	{
		header("Location: http://www.indubalfriction.com/emp-portal/index.php");
	}
?>	