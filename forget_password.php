<?php 
require_once "lib/connect.php";
include('lib/modal_header.php');
require_once "lib/classes/util_objects/util.php";
require_once "lib/classes/business_objects/Queries.php";

$obj=new Queries();
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Set New Password </h2>
            </div>
                <div class="box-content">
     <br>
<?php         
if(isset($_REQUEST['update_button']))  // update code
{
    $submit=$obj->update("alpp_emp","emp_cellnum='".$_REQUEST['rut']."'",array('emp_password'=>$_REQUEST['password'] ));
    if($submit )
	{  ?>
            <div class="widget-body">
                <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Password Changed, Please Login .
                </div>
            </div>
        <?php   
        }
	else echo "<script> alert('Admin Profile not Updated'); </script> ";
}
?>
     <form class="form-horizontal" role="form"  method="post" >
        <div class="form-group">
            <label class="control-label col-sm-2">RUT</label>                     
            <div class="col-sm-4">
                <input type="text" name="rut" class="form-control" placeholder="RUT">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Password</label>                     
            <div class="col-sm-3">
                <input type="text" name="password" class="form-control" placeholder="Password">
            </div>
        </div>
        <div class="form-group">        
            <div class="col-sm-offset-4 col-sm-4" align="center">
                <button type="submit" name="update_button" class="btn btn-small btn-success">Update</button>
             </div>
        </div>  
     </form>

                </div>
            </div>
        </div>
    </div>
<?php include('lib/modal_footer.php'); ?>

