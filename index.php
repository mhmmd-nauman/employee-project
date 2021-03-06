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
</script>
<div class="row">
    &nbsp;
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <h2>Bienvenido al Sistema de Gestión de Empleados</h2>
    </div>
    
</div>
<div class="row">
    <div class="col-md-12 center login-header">
        <h4>Entrar como Empleado/Supervisor/Admins</h4>
    </div>
    <!--/span-->
</div><!--/row-->

<div class="row">
    <div class="well col-md-5 center login-box">
 <?php
 if(isset($_REQUEST['submit']))
 {
    if($_REQUEST['email']) 
    {   
       $user=$_REQUEST['email'];
    }
    $get_user =   $obj->select("alpp_emp"," ( emp_cellnum='".$user."' or emp_email='".$user."') and emp_password='".$_REQUEST['password']."' and emp_status = 0",  array("*"));

    if($get_user)
    {
            switch($get_user[0]['emp_type']){
                case 2:
                    $_SESSION['session_admin_role'] =	'supervisor';
                    break;
                case 3:
                    $_SESSION['session_admin_role'] =	'admin';
                    break;
                case 4:
                    $_SESSION['session_admin_role'] =	'admin';
                    $_SESSION['session_admin_is_super'] = "Y" ;
                    break;
                default :
                    $_SESSION['session_admin_role'] =	'employee';
            }
            	
            $_SESSION['session_admin_id'] =	$get_user[0]['emp_id'];	
            $_SESSION['session_admin_email']=	$get_user[0]['emp_email'];	
            $_SESSION['session_admin_name'] =	$get_user[0]['emp_name'];	

              header("Location: dashboard.php");	
    }
     else $error='Wrong Login Credentials';	 
    
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
        
                <h7><a class="change_pass" href="<?php echo SITE_ADDRESS; ?>forget_password.php">Forget Password ?</a></h7>
       
            </div>
            <div class="clearfix"></div>

            <p class="center col-md-5">
                <button type="submit" name="submit" class="btn btn-primary">Iniciar sesión</button>
            </p>
        </fieldset>

    </form>
  </div>
    
</div><!--/row-->
<?php require('lib/footer.php'); ?>
