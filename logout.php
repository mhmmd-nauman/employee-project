<?php
require_once dirname(__FILE__)."/lib/header_session.php";
SESSION_DESTROY();
if( $_SESSION['session_admin_role'] == 'admin'){
    header("Location: admin_login.php");
}else{
    header("Location: index.php");
}
?>