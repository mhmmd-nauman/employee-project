<?php 
include ('../lib/include.php');
include('../lib/header.php');
$obj=new Queries();
?>

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
                 <div class="box-icon">
            <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
if(isset($_REQUEST['update_button']))  // update code
{
////////// number of days calculation just to save it in db       
$total_days=1;
        if($_REQUEST['leave_duration_to'])
        {
            $date1 = new DateTime($_REQUEST['leave_duration_from']);
            $date2 = new DateTime($_REQUEST['leave_duration_to']);

            $total_days = $date2->diff($date1)->format("%a");
        
        }
//////////////////////////////////////////////////////////////
           $submit=$obj->update("alpp_leave","leave_id=".$_REQUEST['leave_id'] ,array(
                                                'leave_emp_id'     =>$_REQUEST['emp_id'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$total_days,
                                                 'leave_duration_from'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_from'])),
                                                 'leave_duration_to'   =>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_to'])),
                                                 'leave_approval'   =>$_REQUEST['approval'],
                                                 'leave_datetime'   =>date('Y-m-d h:i:s'),
                                                 'leave_user'       =>$_SESSION['session_admin_email']
                                                  
              ));
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Leave Updated.
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
if($_SESSION['session_admin_role']=='admin') 
{
    $approval=$_REQUEST['approval'];
    $employee=$_REQUEST['emp_id'];
}
else 
{
    $approval=0;
    $employee=$_SESSION['session_admin_id'];
}     
////////// number of days calculation just to save it in db       
$total_days=1;
        if($_REQUEST['leave_duration_to'])
        {
            $date1 = new DateTime($_REQUEST['leave_duration_from']);
            $date2 = new DateTime($_REQUEST['leave_duration_to']);

            $total_days = $date2->diff($date1)->format("%a");
        
        }
//////////////////////////////////////////////////////////////

$submit=$obj->insert("alpp_leave",array(
                                                 'leave_emp_id'     =>$employee,
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$total_days,
                                                 'leave_duration_from'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_from'])),
                                                 'leave_duration_to'   =>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_to'])),
                                                 'leave_approval'   =>$approval,
                                                 'leave_datetime'   =>date('Y-m-d h:i:s'),
                                                 'leave_user'       =>$_SESSION['session_admin_email']
                                                  
              ));
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Leave Added.
                        </div>
                    </div>
        <?php   
       if($_SESSION['session_admin_role']=='admin')
       { 
                    if(isset($_REQUEST['emp_id']))  { 
                                             header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_leave.php?emp_id='.$_REQUEST['emp_id']);
                                         }
                      else                        header('REFRESH:2, url=leave_list.php');
       }
       if($_SESSION['session_admin_role']=='employee')
       { 
                        header('REFRESH:2, url=leave_list.php');
       }   
                }
	else    	echo "<script> alert('RECORD NOT INSERTED'); </script> ";
}

        

      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) { $id = $_REQUEST['view']; $readonly="readonly"; }
        else  $id = $_REQUEST['update'];
    
        $leave_list=$obj->select("alpp_leave","leave_id=$id ",array("*")); 
        $leave_duration_to=date("m/d/Y",strtotime($leave_list[0]['leave_duration_to']));
        if(empty($leave_duration_to) || $leave_duration_to == "01/01/1970" ){
            $leave_duration_to = "";
        }
        $leave_duration_from=date("m/d/Y",strtotime($leave_list[0]['leave_duration_from']));
        if(empty($leave_duration_from) || $leave_duration_from == "01/01/1970" ){
            $leave_duration_from = "";
        }
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
     
<?php
     $employee_list=$obj->select("alpp_emp","1 order by emp_name ASC ",array("*"));    

if($_SESSION['session_admin_role']=='admin') 
{ ?>
         <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-4">          
                            <input type="hidden" value="<?php echo $leave_list[0]['leave_id']; ?>"  name="leave_id">
    <?php     if(isset($_REQUEST['emp_id']))  ///  ?? ?>
                            <select name="emp_id" class="form-control" <?php echo $readonly; ?>>
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
<?php } ?>                 
         
                    <div class="form-group">                    
                        <label class="control-label col-sm-2">Duration from</label>                     
                        <div class="col-sm-4">
                            <input type="text" id="leave_duration_from" class="form-control col-sm-4"  style="width:180px;" <?php echo $readonly; ?> value="<?php echo $leave_duration_from; ?>"  name="leave_duration_from">
                        </div>
                    </div>
         
                    <div class="form-group">                    
                        <label class="control-label col-sm-2">Duration to    <font style=" font-size: 10px;" ><br>(if required)</font></label>                     
                        <div class="col-sm-4">
                            <input type="text" id="leave_duration_to" class="form-control col-sm-4" style="width:180px;" <?php echo $readonly; ?> value="<?php echo $leave_duration_to; ?>"  name="leave_duration_to">
                        </div>
                    </div>
         
         
                        
      <?php  if($_SESSION['session_admin_role']=='admin') {  ?>
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
      <?php } ?>
              
                
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#leave_duration_from" ).datepicker();
  $( "#leave_duration_to" ).datepicker();
});
</script>
