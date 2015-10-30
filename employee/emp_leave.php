<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
 ?>
<script>
function action(status,leave_id,emp_id){
        
        if(status==1){                
                                var answer = confirm ("Are you sure want to cancel Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=1&emp_id="+emp_id;
                            }        
   else if(status==2){                
                               var answer = confirm ("Are you sure want to Approve Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=2&emp_id="+emp_id;
                            }        
    else if(status==3) {                
                                var answer = confirm ("Are you sure want to Delete Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=3&emp_id="+emp_id;
                              }        
    }
</script>
<?php
  $obj=new Queries();
  
  /// code to edit status only /////
if(isset($_REQUEST['leave_id']) && isset($_REQUEST['status']))	
{	           
if($_REQUEST['status']==1 || $_REQUEST['status']==2) { // cancel | Approve
            $action=$obj->Update("alpp_leave",'leave_id='.$_REQUEST['leave_id'] , array('leave_approval'=>$_REQUEST['status']));
} 
else if($_REQUEST['status']==3) { // delete
    $action = $obj->Delete("alpp_leave",'leave_id='.$_REQUEST['leave_id']);
}
if(isset($action) )
	 {		 ?>
         <div class="widget-body">
                <div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> <?php echo ($_REQUEST['status']==3) ? 'Record Deleted' : 'Record Updated' ;?>
                </div>
         </div>
     	 <?php
		header('refresh:1, url=emp_list.php?emp_id='.$_REQUEST['emp_id']);
	}
}
//// basic query to show records in table ///    

$leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","leave_emp_id=".$_REQUEST['emp_id']." order by leave_id desc",array("*"));

      

 

// delete  a record
if(isset($_REQUEST['del']))	
{	

        $id = $_REQUEST['del'];
	$del = $obj->Delete("alpp_leave",'leave_id='.$id);
	 
	if($del)
	{
		 ?>
         <div class="widget-body">
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Deleted.
                            </div>
         </div>
     	 <?php
		header('refresh:1, url=leave_list.php');
	}
}

        ?>
     


<div>
    <ul class="breadcrumb">
        <li><a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a></li>
        <li><a href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php">Employee</a></li>
        <li>Leave List</li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Leave List</h2>
            </div>
            

            <div class="box-content">
                <p><a href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?emp_id=<?php echo $_REQUEST['emp_id']; ?>"><button class="btn btn-inverse btn-default btn-sm">Add Leaves</button></a> </p>
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" id="">
    <thead>
    <tr>
        <th>Name</th>
        <th>Duration</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($leave_list as $leave) {   ?>
        
    <tr>
             <td><?php echo $leave['emp_name']; ?></td>
        <td><?php echo $leave['leave_duration']; ?></td>
        <td><?php echo $leave['leave_reason']; ?></td>
       
        
        			
<?php	if($leave['leave_approval']==0)       echo"<td class='hidden-phone '><span class='label label-danger'>Pending</span></td>";
	else if($leave['leave_approval']==2)	echo"<td class='hidden-phone '><span class='label label-success'>Approved</span></td>";
	else if($leave['leave_approval']==1)  echo"<td class='hidden-phone '><span class='label label-small label-danger'>Cancelled </span></td>";

        
      ?>
        <td>
            
            
 <?php if($_SESSION['session_admin_role']=='admin') { ?> 
                           <div class="btn-group">
                                    <button class="btn btn-warning">Status</button>
                                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle b2"><span class="caret"></span></button>
                                    <ul class="dropdown-menu">
<li><a href="javascript:;" onclick="return action('2','<?php  echo $leave['leave_id']; ?>','<?php  echo $leave['leave_emp_id']; ?>');"><i class="icon-ok"></i> Approve</a></li>
<li><a href="javascript:;" onclick="return action('1','<?php  echo $leave['leave_id']; ?>','<?php  echo $leave['leave_emp_id']; ?>');"><i class="icon-minus"></i> Cancel</a></li>
<li><a href="javascript:;" onclick="return action('3','<?php  echo $leave['leave_id']; ?>','<?php  echo $leave['leave_emp_id']; ?>');"><i class="icon-remove"></i>Delete</a></li>
                                    </ul>
                                </div>
       <?php } ?>
            
            <a class="btn btn-success" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?view=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                View
            </a>
            <a class="btn btn-info" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?update=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="leave_list.php?del=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Delete
            </a>
        </td>
    </tr>
        <?php } ?>
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php include('../lib/footer.php'); ?>