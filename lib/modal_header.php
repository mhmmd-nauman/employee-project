<?php
//define("SSL_INSTALLED",1);
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME'].":/emp2/");
}else{
//	if(SSL_INSTALLED == 1 && $_SERVER['SERVER_NAME'] != 'employee_project.com'){
//		$http = "https";
//	}else{
//		$http = "http";
//	}
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME']."/emp/");     
}
?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Employee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The styles -->
    <link href="<?php echo SITE_ADDRESS; ?>css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?php echo SITE_ADDRESS; ?>css/charisma-app.css" rel="stylesheet">
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/colorbox/example5/colorbox.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="<?php echo SITE_ADDRESS; ?>bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	

</head>

<body>
    