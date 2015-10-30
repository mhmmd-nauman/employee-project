<?php 
include ('../lib/include.php');
include('../lib/header.php');
$obj=new Queries();
?>
<script>
function checkPhoto(target) {
 {
var fileName = target.value;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG" )
		{
							if(target.files[0].size > 2097152) 
							{
								alert("Image too big (max 2MB)");
								document.getElementById("img1").value = "";
								return false;
							}
		}
		else
							{
								alert("Extension will be jpeg, gif or png");
								document.getElementById("img1").value = "";
								return false;
							}
}
}
</script>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li> Leave   </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Employee Leave</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
if(isset($_REQUEST['update_button']))  // update code
{
           $submit=$obj->update("alpp_leave","leave_id=".$_REQUEST['leave_id'] ,array(
                                                'leave_emp_id'     =>$_REQUEST['emp_id'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$_REQUEST['duration'],
                                                 'leave_approval'   =>$_REQUEST['approval'],
                                                 'leave_datetime'   =>date('d-m-Y H:i:s a'),
                                                 'leave_user'       =>$_SESSION['session_admin_email']
                                                  
              ));
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Update.
                        </div>
                    </div>
        <?php 
        if(isset($_REQUEST['emp_id']))  { 
                                    header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_leave.php?emp_id='.$_REQUEST['emp_id']);
         }
          else                        header('REFRESH:2, url=leave_list.php');
        }
	else    	echo "<script> alert('RECORD NOT Updated'); </script> ";
}

 if(isset($_REQUEST['submit']))  /// insert code
{

     
                $submit=$obj->insert("alpp_leave",array(
                                                 'leave_emp_id'     =>$_REQUEST['emp_id'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$_REQUEST['duration'],
                                                 'leave_approval'   =>$_REQUEST['approval'],
                                                 'leave_datetime'   =>date('d-m-Y H:i:s a'),
                                                 'leave_user'       =>$_SESSION['session_admin_email']
                                                  
              ));
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Inserted.
                        </div>
                    </div>
        <?php   
         if(isset($_REQUEST['emp_id']))  { 
                                    header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_leave.php?emp_id='.$_REQUEST['emp_id']);
         }
          else                        header('REFRESH:2, url=leave_list.php');
          
                }
	else    	echo "<script> alert('RECORD NOT INSERTED'); </script> ";
}

        

      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) { $id = $_REQUEST['view']; $readonly="readonly"; }
        else  $id = $_REQUEST['update'];
    
        $leave_list=$obj->select("alpp_leave","leave_id=$id ",array("*"));   
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
     <?php         $employee_list=$obj->select("alpp_emp","1 order by emp_name ASC ",array("*"));     ?>
            
         
         <div class="form-group">
                        
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-4">          
                            <input type="hidden" value="<?php echo $leave_list[0]['leave_id']; ?>"  name="leave_id">
                <?php     if(isset($_REQUEST['emp_id'])) 
                    ?>
                            <select name="emp_id" class="form-control" <?php echo $readonly; ?>>
                                <option value="">SELECT</option>
                                <?php 
                                foreach($employee_list as $employee)
                                {    
                                         if(isset($_REQUEST['emp_id']) && $_REQUEST['emp_id']==$employee['emp_id']) 
                                         {
                                             echo "<option value=".$employee['emp_id']." selected>".$employee['emp_name']."</option>";
                                         }   
                                         else{
                                                 $sel=   ($employee['emp_id']==$leave_list[0]['leave_emp_id']) ? 'selected' : '' ;
                                                echo "<option value=".$employee['emp_id']." $sel>".$employee['emp_name']."</option>";
                                            }
                                
                                         }
                                ?>
                            </select>
                        
                        </div>
         </div>
                    
         
                    <div class="form-group">
                    
                        <label class="control-label col-sm-2">Duration</label>                     
                        <div class="col-sm-4">
                            <input type="text" class="form-control" <?php echo $readonly; ?> value="<?php echo $leave_list[0]['leave_duration']; ?>" placeholder="No of Days" name="duration">
                        </div>
                    </div>
                        
         <div class="form-group">
                        <label class="control-label col-sm-2">Approval</label>
                        <div class="col-sm-4">          
                        <select name="approval" class="form-control" <?php echo $readonly; ?>>
                        <?php $leave_array=array("2"=>"Approved","0"=>"Pending","1"=>"Cancelled"); ?>
                            <option value="">SELECT</option>
                           <?php 
                                foreach($leave_array as $status=>$value)
                                {    $sel=   ($status==$leave_list[0]['leave_approval']) ? 'selected' : '' ;
                                      echo "<option value=".$status." $sel>".$value."</option>";
                                }
                                ?>
                        </select>
                        </div>
                    
                    </div>
                    
              
                
          <div class="form-group">
                         <label class="control-label col-sm-2">Reason</label>                     
                        <div class="col-sm-4">
                            <textarea  class="form-control" name="reason" <?php echo $readonly; ?>  placeholder="Enter Detail here..."><?php echo $leave_list[0]['leave_reason']; ?></textarea>
                        </div>
                               
                        
                    
                    </div>
<?php if(isset($_REQUEST['view']))	{  ?>                   
<?php } else if(isset($_REQUEST['update']))	{  ?>
       <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-4">
                            <button type="submit" name="update_button" class="btn btn-small btn-block btn-error">Update</button>
                         </div>
                    </div>  
<?php } else {     ?>         
       <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-block btn-info">Save</button>
                         </div>
                    </div>  

<?php }?>
      
                    <br>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<?php include('../lib/footer.php'); ?>
