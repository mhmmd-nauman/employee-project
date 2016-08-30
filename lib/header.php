<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Employee Management Portal</title>
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
   
    <link href='<?php echo SITE_ADDRESS; ?>css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo SITE_ADDRESS; ?>css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="<?php echo SITE_ADDRESS; ?>bower_components/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $(".add_employee").colorbox({iframe:true, width:"80%", height:"90%"});
        $(".add_employee_balance").colorbox({iframe:true, width:"90%", height:"95%"});
        
        $(".add_monthly").colorbox({iframe:true, width:"70%", height:"80%"});
        $(".add_leave_multi").colorbox({iframe:true, width:"80%", height:"90%"});
        
        $(".add_employee_notes").colorbox({iframe:true, width:"70%", height:"80%"});
             $(".add_holiday").colorbox({iframe:true, width:"40%", height:"60%"});
        $(".add_leave").colorbox({iframe:true, width:"40%", height:"90%"});
            $(".status_leave").colorbox({iframe:true, width:"40%", height:"50%"});
            
            $('#data_list').dataTable( {
                        "bSort": false,
                        "bStateSave": true,
                        "oLanguage": {
                                "sProcessing":     "Procesando...",
                                "sLengthMenu":     "_MENU_ Registros por hoja",
                                "sZeroRecords":    "No se encontraron resultados",
                                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                                "sInfo":           "_START_-_END_ / _TOTAL_",
                                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                                "sInfoPostFix":    "",
                                "sSearch":         "Buscar:",
                                "sUrl":            "",
                                "sInfoThousands":  ",",
                                "sLoadingRecords": "Cargando...",
                                "oPaginate": {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                },
                                "oAria": {
                                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                }
                        }
                } );
                
                $('#data_list_info')
                    .addClass('col-md-9');
                $('#data_list_paginate')
                    .addClass('col-md-3 ');
                $('#data_list_length')
                    .addClass('col-md-9');
                $('#dataTables_filter')
                    .addClass('col-md-2 ');
                $('#data_list_previous')
                    .addClass('btn btn-default ');
                $('#data_list_next')
                    .addClass('btn btn-default ');
                $('#data_list')
                    .addClass('table table-striped table-bordered');
    
    });
    
</script>     <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
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
            <a class="navbar-brand" href="#" onclick="javascript::return false;"> 
                <span><img alt="Employee Logo" src="<?php echo SITE_ADDRESS; ?>img/logo20.png" class="hidden-xs"/></span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"><?php echo $_SESSION['session_admin_name']; ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    
                <?php if($_SESSION['session_admin_role']=='employee')   { ?> 
                    <li><a class="add_employee">Conectado como Empleado</a></li>
                    <li class="divider"></li>
                    <li><a class="add_employee" href="<?php echo SITE_ADDRESS; ?>employee/update_employee_profile.php?update=<?php echo $_SESSION['session_admin_id']; ?>">Mi perfil</a></li>
                <?php } else { ?>
                    <li><a class="add_employee">Conectado como administrador</a></li>
                    <li class="divider"></li>
                    <li><a class="add_employee" href="<?php echo SITE_ADDRESS; ?>employee/update_employee_profile.php?update=<?php echo $_SESSION['session_admin_id']; ?>">Mi perfil</a></li>
                <?php 
                    }  ?>

                    <li class="divider"></li>
                    <li><a href="<?php echo SITE_ADDRESS; ?>logout.php">Cerrar sesión</a></li>
                </ul>
            </div>

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
                        <li class="nav-header">Main&nbsp;
                         <?php switch($_SESSION['session_admin_role']){
                                case 'supervisor':
                                    ?>
                                    <span style=" font-size: 8px;"><b>(Supervisor)</b></span>
                                <?php
                                    break;
                                case 'admin':
                                    ?>
                                    <span style=" font-size: 8px;"><b>(administrador)</b></span>
                                    <?php
                                    
                                    break;
                                default :
                                    ?>
                                    <span style=" font-size: 8px;"><b>(Empleado)</b></span>
                                    <?php
                                    
                            } 
                            ?>  
                        
                        </li>
                        
                        <li><a class="ajax-link" href="<?php echo SITE_ADDRESS; ?>dashboard.php"><i class="glyphicon glyphicon-home"></i><span> Inicio</span></a></li>
                        <?php
                        switch($_SESSION['session_admin_role']){
                                case 'supervisor':
                                    ?>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Empleados</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php"><i class="glyphicon glyphicon-icon-user"></i><span> Ver empleados </span></a></li>
                                        
                                    </ul>
                                </li>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Ingresar Solicitud</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="ajax-link"><a  class="add_leave_multi" href="<?php echo SITE_ADDRESS; ?>leave/add_multiple_leave.php"><i class="glyphicon glyphicon-list"></i><span> Ingresar Solicitud</span></a></li>
                                        <!--<li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>manage_requests.php"><i class="glyphicon glyphicon-file"></i><span> Manage Requests</span></a></li>-->
                                        <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php"><i class="glyphicon glyphicon-eye-open"></i><span> Historial</span></a></li>
                                    </ul>
                                </li>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Listado de Feriados</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>employee/holidays_list.php"><i class="glyphicon glyphicon-random"></i><span> Feriados</span></a></li>
                                        
                                    </ul>
                                </li>
                                <li class="accordion">
                                    <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Informes</span></a>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Informe del empleado </span></a></li>
                                        <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_monthly_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Saldo mensual</span></a></li>
                                        

                                    </ul>
                                </li>
                                <?php
                                    break;
                                case 'admin': 
                        
                        ?>   
                            <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Empleados</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php"><i class="glyphicon glyphicon-icon-user"></i><span> Ver empleados </span></a></li>
                                <li><a class="add_employee" href="<?php echo SITE_ADDRESS; ?>employee/add_employee.php"><i class="glyphicon glyphicon-list-alt"></i><span> Ingresar</span></a></li>
                                <li><a class="add_employee_balance" href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_single.php"><i class="glyphicon glyphicon-list-alt"></i><span> Modificar saldos</span></a></li>
                            </ul>
                        </li>
                                            
                            
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Ingresar Solicitud</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="ajax-link"><a  class="add_leave_multi" href="<?php echo SITE_ADDRESS; ?>leave/add_multiple_leave.php"><i class="glyphicon glyphicon-list"></i><span> Ingresar Solicitud</span></a></li>
                                <!--<li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>manage_requests.php"><i class="glyphicon glyphicon-file"></i><span> Manage Requests</span></a></li>-->
                                <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php"><i class="glyphicon glyphicon-eye-open"></i><span> Historial</span></a></li>
                            </ul>
                        </li>
                        
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Ajuste de Saldos</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a class="add_monthly" href="<?php echo SITE_ADDRESS; ?>employee/add_monthly.php"><i class="glyphicon glyphicon-icon-user"></i><span> Add Manual Balance </span></a></li>
                                <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_feriado_legal_cron.php"><i class="glyphicon glyphicon-random"></i><span> Feriado Legal</span></a></li>
                                <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_dias_progresivos_cron.php"><i class="glyphicon glyphicon-random"></i><span> Dias Progresivos</span></a></li>
                             <!--   
                                <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_entry_alerts.php"><i class="glyphicon glyphicon-random"></i><span> Balance Alerts</span></a></li>
                             -->
                            </ul>
                        </li>
                        
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Listado de Feriados</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="ajax-link"><a href="<?php echo SITE_ADDRESS; ?>employee/holidays_list.php"><i class="glyphicon glyphicon-random"></i><span> Feriados</span></a></li>
                                <li class="ajax-link"><a class="add_holiday cboxElement" href="<?php echo SITE_ADDRESS; ?>employee/add_holiday_type.php"><i class="glyphicon glyphicon-random"></i><span> Feriados Type</span></a></li>
                                <li class="ajax-link"><a class="add_holiday cboxElement" href="<?php echo SITE_ADDRESS; ?>employee/add_holiday.php"><i class="glyphicon glyphicon-random"></i><span> Ingresar Feriados</span></a></li>
                            </ul>
                        </li>
                        
                        
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span>Informes</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Informe del empleado </span></a></li>
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_monthly_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Saldo mensual</span></a></li>
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/active_emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Empleados activos</span></a></li>
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/inactive_emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> En Empleados Activos</span></a></li>
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/admin_emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span>Supervisors/Managers</span></a></li>
                                <li><a href="<?php echo SITE_ADDRESS; ?>employee/retired_emp_reports.php"><i class="glyphicon glyphicon-list-alt"></i><span> Retired Empleados</span></a></li>
                                
                            </ul>
                        </li>
                        <!--
                        <li><a href="<?php echo SITE_ADDRESS; ?>settings/permissions.php"><i class="glyphicon glyphicon-globe"></i><span> PREMISOLOGÍA</span></a></li>
                        -->
                        <li><a href="<?php echo SITE_ADDRESS; ?>settings/alerts.php"><i class="glyphicon glyphicon-globe"></i><span> System Alerts</span></a></li>

           <?php 
           break;
           
           default :   ?>                        
                <li class="ajax-link"><a class="add_leave" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php"><i class="glyphicon glyphicon-list"></i><span> Presentar una solicitud de licencia</span></a></li>
                <li><a href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php"><i class="glyphicon glyphicon-list"></i> Historial </a></li>
                <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php?emp_id=<?php echo $_SESSION['session_admin_id']; ?>"><i class="glyphicon glyphicon-list"></i> Ajuste de Saldos</a></li>
            <?php }   ?>                       
                        <li><a href="<?php echo SITE_ADDRESS; ?>logout.php"><i class="glyphicon glyphicon-lock"></i><span> Cerrar sesión</span></a></li>
                    </ul>
                 </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>