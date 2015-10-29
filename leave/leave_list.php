<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
 ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php">Add</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php">Leave List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Leave List</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
      $obj=new Queries();
if(isset($_REQUEST['view']))	
{	
      $leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","leave_emp_id=".$_REQUEST['view']." order by leave_id desc",array("*"));
}
else
{         $leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","1 order by leave_id desc",array("*"));
}
 	 
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
	else if($leave['leave_approval']==1)  echo"<td class='hidden-phone '><button class='btn btn-small btn-danger'>Cancelled </button></td>";

        
      ?>
        <td>
            
            
 <?php //if($_SESSION['session_admin_role']=='admin') { ?> 
<!--                            <div class="btn-group">
                                    <button class="btn btn-warning">Action</button>
                                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle b2"><span class="caret"></span></button>
                                    <ul class="dropdown-menu">
<li><a href="javascript:;" onclick="return action('2','<?php // echo $rec['institute_program_id']; ?>');"><i class="icon-ok"></i> Approve</a></li>
<li><a href="javascript:;" onclick="return action('1','<?php // echo $rec['institute_program_id']; ?>');"><i class="icon-minus"></i> Cancel</a></li>
<li><a href="javascript:;" onclick="return action('3','<?php // echo $rec['institute_program_id']; ?>');"><i class="icon-remove"></i>Delete</a></li>
                                    </ul>
                                </div>-->
       <?php// } ?>
            
            <a class="btn btn-success" href="add_leave.php?view=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                View
            </a>
            <a class="btn btn-info" href="add_leave.php?update=<?php echo $leave['leave_id']; ?>">
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