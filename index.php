<?php	
ob_start();
session_start();
?>
<?php
$no_visible_elements = true;
include('lib/header.php'); 

require_once "lib/connect.php";
require_once "lib/classes/util_objects/util.php";
require_once "lib/classes/business_objects/Queries.php";


?>

    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to Employee Management System</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
 <?php
 if(isset($_REQUEST['submit']))
 {
     $obj=new Queries();
      if(isset($_REQUEST['admin']))               
      {
          $get_user=   $obj->select("alpp_adminlog","adminlog_email='".$_REQUEST['email']."' and adminlog_password='".md5($_REQUEST['password'])."'",  array("*"));
      
                    if($get_user)
                                {
		 			$_SESSION['session_admin_role']		=	'admin';	
					$_SESSION['session_admin_id']		=	$get_user[0]['adminlog_id'];	
					$_SESSION['session_admin_email']	=	$get_user[0]['adminlog_email'];	
					$_SESSION['session_admin_name']		=	$get_user[0]['adminlog_name'];	
				
					  header("Location: dashboard.php");	
                                }
    					else echo "<script>alert('Username or Password is Incorrect');</script>";				
     }
     else
     {
         $get_user=   $obj->select("alpp_emp","emp_email='".$_REQUEST['email']."' and emp_password='".$_REQUEST['password']."'",  array("*"));
      
                    if($get_user)
                                {
		 			$_SESSION['session_admin_role']		=	'employee';	
					$_SESSION['session_admin_id']		=	$get_user[0]['emp_id'];	
					$_SESSION['session_admin_email']	=	$get_user[0]['emp_email'];	
					$_SESSION['session_admin_name']		=	$get_user[0]['emp_name'];	
				
					  header("Location: dashboard.php");	
                                }
    					else echo "<script>alert('Username or Password is Incorrect');</script>";	 
     }
 } 
     ?><div class="alert alert-info">
                Please login with your Username and Password.
            </div>
            <form class="form-horizontal" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Email" value="m.nauman@gmail.com" name="email">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="1234">
                    </div>
                    <div class="clearfix"></div>

                    
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </p>
                </fieldset>
              
            </form>
        </div>
        
        <div class=" col-md-5 center login-box"> <a href="?admin=ok">Admin</a></div>
        <!--/span-->
    </div><!--/row-->
<?php require('lib/footer.php'); ?>