<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
 ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_employee.php">Add</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php">Employee List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Employee</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
      $obj=new Queries();
      $employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));

      
 	 
if(isset($_REQUEST['del']))	
{	

        $id = $_REQUEST['del'];
	$del = $obj->Delete("alpp_emp",'emp_id='.$id);
	 
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
		header('refresh:1, url=emp_list.php');
	}
}
?>
      
      
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" id="example1">
    <thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Balance</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {  
            $balance = $objTransaction->GetEmpBalance($employee['emp_id']);
            ?>
        
    <tr>
        <td><img src="<?php echo SITE_ADDRESS.$employee['emp_pic']; ?>" height="50" width="50"></td>
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_email']; ?></td>
       
        <td><?php echo $balance; ?></td>
        <td class="center">
           <?php if($employee['emp_status']==0) { ?>
            <span class="label-success label label-default">Active</span>
           <?php } ?>
        </td>
        <td class="center">
            <a class="btn btn-success" href="emp_balance.php?view=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon icon-white"></i>
                Balance Details
            </a>
             <a class="btn btn-warning" href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php?view=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon glyphicon-star icon-white"></i>
                Leaves
            </a>
            <a class="btn btn-success" href="add_employee.php?view=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                View
            </a>
            <a class="btn btn-info" href="add_employee.php?update=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="emp_list.php?del=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Delete
            </a>
        </td>
    </tr>
        <?php 
        $balance = 0;
           } ?>
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php include('../lib/footer.php'); ?>