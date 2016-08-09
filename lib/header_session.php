<?php	
ob_start();
session_start();
if((!isset($_SESSION['session_admin_id']))  || (!isset($_SESSION['session_admin_role'])) )
{
    if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
         header("Location: http://".$_SERVER['SERVER_NAME']."/emp5/index.php");
    }else{
        header("Location: http://".$_SERVER['SERVER_NAME']."/emp-portal/index.php");
    }
        
}
?>	