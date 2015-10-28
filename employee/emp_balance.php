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
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php">Add Balance</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php">Transaction List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Employee Balance Details</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
      $objTransaction =new Transaction();
      $trasanction_list=$objTransaction->GetAllTrasanctions("alpp_transactions.emp_id = ".$_REQUEST['view'],array("alpp_transactions.*"));

      
 	 
if(isset($_REQUEST['del']))	
{	

        $id = $_REQUEST['del'];
	$del = $objTransaction->DeleteTransantion($id);
	 
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
		header('refresh:1, url=emp_balance.php');
	}
}
?>
      
      
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" id="example1">
    <thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Account #</th>
        <th>Basic Salary</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($trasanction_list as $trasanction) {   ?>
        
    <tr>
        <td><?php echo $trasanction['id']; ?></td>
        <td><?php echo $trasanction['amount']; ?></td>
        <td><?php echo $trasanction['trans_type']; ?></td>
        <td><?php echo $trasanction['date']; ?></td>
        <td><?php echo $trasanction['done_by']; ?></td>
        <td class="center">
           <?php if($employee['status']==0) { ?>
            <span class="label-success label label-default">Active</span>
           <?php } ?>
        </td>
        <td class="center">
            
            <a class="btn btn-success" href="add_employee.php?view=<?php echo $employee['id']; ?>">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                View
            </a>
            <a class="btn btn-info" href="add_employee.php?update=<?php echo $employee['id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="emp_list.php?del=<?php echo $employee['id']; ?>">
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