<?php 
include ('lib/include.php');
include('lib/header.php');
$obj=new Queries();
if($_SESSION['session_admin_role']='admin')
{        

$profile=$obj->select("alpp_adminlog","adminlog_id=".$_SESSION['session_admin_id'],array("*"));   

?>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a href="">Profile</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Admin Profile</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
        
if(isset($_REQUEST['update_button']))  // update code
{
                $submit=$obj->update("alpp_adminlog","adminlog_id=".$_SESSION['session_admin_id'],array(
                                                                    'adminlog_name'         =>$_REQUEST['admin_name'],
                                                                    'adminlog_email'        =>$_REQUEST['admin_email'],
                                                                    'adminlog_password'      =>$_REQUEST['admin_password']
                                                 ));
        if($submit )
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Admin Profile Updated, Please Login Again.
                        </div>
                    </div>
        <?php   
                SESSION_DESTROY();
                header('REFRESH:2, url=index.php');
    		}
	else    	echo "<script> alert('Admin Profile not Updated'); </script> ";
}
   
 	 
    
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Admin Name</label>
                        <div class="col-sm-4">          
                            <input type="text" name="admin_name" class="form-control" value="<?php echo $profile[0]['adminlog_name']; ?>" placeholder="Admin Name" >
                        </div>
                    
                        
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>                     
                        <div class="col-sm-4">
                            <input type="email" name="admin_email" class="form-control"  value="<?php echo $profile[0]['adminlog_email']; ?>" placeholder="Enter email">
                        </div>
                    </div>
         
                    <div class="form-group">
                        <label class="control-label col-sm-2">Password</label>                     
                        <div class="col-sm-3">
                            <input type="text" name="admin_password" class="form-control" value="<?php echo $profile[0]['adminlog_password']; ?>"  placeholder="Password">
                        </div>
                    
                    </div>
                   
                    
                        
                    
                    </div>

            <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="update_button" class="btn btn-small btn-block btn-error">Update</button>
                         </div>
                    </div>  

            
                    <br>       <br>       <br>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->
<?php } else header('url='.SITE_ADDRESS.'dashboard.php'); ?>
<?php include('lib/footer.php'); ?>

