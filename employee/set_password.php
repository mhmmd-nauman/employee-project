<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/modal_header.php'); 
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","emp_id=".$_REQUEST['id'],array("*")); 
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
                    $submit=$obj->update("alpp_emp","emp_id='".$_REQUEST['id']."'" ,array('emp_email'=>$_REQUEST['emp_email'],'emp_password'=>$_REQUEST['emp_password'] ));
                    if($submit )
                        {  ?>
                            <div class="widget-body">
                                <div class="alert alert-success">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Success!</strong> Email and Password Updated.
                                </div>
                            </div>
                            <script> window.parent.location.reload();</script>
                        <?php   
                        }
                        else echo "<script> alert('Profile not Updated'); </script> ";
                }
                ?>
            <form class="form-horizontal" role="form"  method="post" >
               <div class="form-group">
                   <label class="control-label col-sm-2">Employee</label>                     
                   <div class="col-sm-4">
                       <?php echo $employee_list[0]['emp_name']; ?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-2">Email</label>                     
                   <div class="col-sm-4">
                   <input type="email" name="emp_email" class="form-control"  value="<?php echo $employee_list[0]['emp_email']; ?>" placeholder="Enter email">
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-sm-2">Password</label>                     
                   <div class="col-sm-3">
                   <input type="text" name="emp_password" class="form-control" value="<?php echo $employee_list[0]['emp_password']; ?>"  placeholder="Password">
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

