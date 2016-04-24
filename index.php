<?php	
ob_start();
session_start();

$no_visible_elements = true;
require_once "lib/connect.php";
include('lib/header.php'); 
require_once "lib/classes/util_objects/util.php";
require_once "lib/classes/business_objects/Queries.php";
$obj=new Queries();
 ?>

<script>
    $(document).ready(function(){
            $(".change_pass").colorbox({iframe:true, width:"30%", height:"60%"});
    });
</script>    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Bienvenido al Sistema de Gestión de Empleados</h2>
        </div>
        <div class="col-md-12 center login-header">
            <?php if(isset($_REQUEST['employee']) && $_REQUEST['employee'] =='ok'){ ?>
                <h4>Entrar como Empleado</h4>
            <?php } else{    ?>
                 <h4>Registrado como administradores</h4>
            <?php } ?>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
 <?php
 if(isset($_REQUEST['submit']))
 {
    if(!isset($_REQUEST['employee']))               
    {
        $get_user=   $obj->select("alpp_adminlog","adminlog_email='".$_REQUEST['email']."' and adminlog_password='".$_REQUEST['password']."'",  array("*"));
        if($get_user){
            // its a supper admin
            $_SESSION['session_admin_role']		=	'admin';	
            $_SESSION['session_admin_id']		=	$get_user[0]['adminlog_id'];	
            $_SESSION['session_admin_email']            =	$get_user[0]['adminlog_email'];	
            $_SESSION['session_admin_name']		=	$get_user[0]['adminlog_name'];
            $_SESSION['session_admin_is_super']         = "Y" ;
            
            header("Location: dashboard.php");	
        } else {
            $get_user=   $obj->select("alpp_emp"," ( emp_cellnum='".$_REQUEST['email']."' or emp_email='".$_REQUEST['email']."') and emp_password='".$_REQUEST['password']."' and emp_type = 1",  array("*"));
            if($get_user)
            {
                $_SESSION['session_admin_role']		=	'admin';	
                $_SESSION['session_admin_id']		=	$get_user[0]['emp_id'];	
                $_SESSION['session_admin_email']	=	$get_user[0]['emp_email'];	
                $_SESSION['session_admin_name']		=	$get_user[0]['emp_name'];
                $_SESSION['session_admin_is_super']     = "N" ;
                header("Location: dashboard.php");	
            }
            else $error='Wrong Login Credentials for Admin';				
        }
    }
     else
     {
         if($_REQUEST['email']) 
         {   
            $user=$_REQUEST['email'];
          }
                $get_user=   $obj->select("alpp_emp"," ( emp_cellnum='".$user."' or emp_email='".$user."') and emp_password='".$_REQUEST['password']."'",  array("*"));
      
                    if($get_user)
                                {
		 			$_SESSION['session_admin_role']		=	'employee';	
					$_SESSION['session_admin_id']		=	$get_user[0]['emp_id'];	
					$_SESSION['session_admin_email']	=	$get_user[0]['emp_email'];	
					$_SESSION['session_admin_name']		=	$get_user[0]['emp_name'];	
				
					  header("Location: dashboard.php");	
                                }
    					else $error='Wrong Login Credentials for Employee';	 
     }
 } 
 
  if(isset($error)) {  ?>
                            <div class="alert alert-warning">
                                <?php echo $error; ?>, Please try again
                            </div>
  <?php  } else { ?>
                            <div class="alert alert-info">
                                Inicia sesión con tu nombre de usuario y contraseña.
                            </div>
  <?php   }  ?>
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Email"  name="email">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password" >
                    </div>
                    <div class="clearfix pull-right">
                <?php if(isset($_REQUEST['employee']) && $_REQUEST['employee'] =='ok'){ ?>
                        <h7><a class="change_pass" href="<?php echo SITE_ADDRESS; ?>forget_password.php">Forget Password ?</a></h7>
                <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" name="submit" class="btn btn-primary">Iniciar sesión</button>
                    </p>
                </fieldset>
              
            </form>
        </div>
        
    <?php if(!isset($_REQUEST['employee'])) { ?>   
        <div class=" col-md-5 center login-box"> <a href="?employee=ok" class="btn btn-primary">Acceso empleado</a></div>
    <?php } else {  ?>   
        <div class=" col-md-5 center login-box"> <a href="?" class="btn btn-primary">el acceso al administrador</a></div>
    <?php }  ?> 
    </div><!--/row-->
<?php require('lib/footer.php'); ?>