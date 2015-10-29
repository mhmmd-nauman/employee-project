<?php
//define("SSL_INSTALLED",1);
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
	define("SITE_ADDRESS","http://".$_SERVER['SERVER_NAME']."/employee_project/");
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
    <link id="bs-css" href="<?php echo SITE_ADDRESS; ?>css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?php echo SITE_ADDRESS; ?>css/charisma-app.css" rel="stylesheet">
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
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

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"> <img alt="Charisma Logo" src="<?php echo SITE_ADDRESS; ?>img/logo20.png" class="hidden-xs"/>
                <span>Employee</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"><?php echo $_SESSION['session_admin_name']; ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo SITE_ADDRESS; ?>logout.php">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <!-- theme selector starts -->
<!--            <div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                    <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                    <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                    <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                    <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                    <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                    <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                </ul>
            </div>-->
            <!-- theme selector ends -->

        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="<?php echo SITE_ADDRESS; ?>dashboard.php"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a></li>
                        <li><a class="ajax-link" href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php"><i class="glyphicon glyphicon-eye-open"></i><span> Employee</span></a></li>
                        <li><a class="ajax-link" href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php"><i class="glyphicon glyphicon-star"></i><span> Leave</span></a></li>
                        <li><a href="<?php echo SITE_ADDRESS; ?>logout.php"><i class="glyphicon glyphicon-lock"></i><span> Logout</span></a></li>
                    </ul>
                 
                 </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>
