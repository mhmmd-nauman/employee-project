<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$trasanction_list=$objTransaction->GetAllTrasanctions("alpp_transactions.emp_id = ".$_REQUEST['view']." ORDER BY end_month_data DESC",array("alpp_transactions.*"));
$balance=0.00;
$balance = $objTransaction->GetEmpBalance($_REQUEST['view']);
 ?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php?view=<?php echo $_REQUEST['view']?>">Add Balance</a>
        </li>
        <li>
            Employee Balance Details
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Employee Balance Details</h2>
            </div>
            
            <div class="col-md-12">
                <br>
                <h4>Balance: <?php echo $balance;?> day(s) after deducting leaves</h4>
                <br>
            </div>
            
           <div class="box-content">
     <br>
<?php 
      
      
 	 
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
        <th>Date</th>
        <th>Days</th>
        <th>Consumed/Received</th>
        <th>Data Added</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($trasanction_list as $trasanction) {   ?>
        
    <tr>
        <td><?php echo date("m/d/Y",strtotime($trasanction['end_month_data'])); ?></td>
        <td><?php echo $trasanction['amount']; ?></td>
        <td>
            <?php
            if($trasanction['trans_type']=='C') {
                echo "Received"; 
            }else{
                echo "Consumed";
            }?></td>
        <td><?php echo $trasanction['date']; ?></td>
        <td class="center">
           <?php if($trasanction['status']==0) { ?>
            <span class="label-success label label-default">Active</span>
           <?php } ?>
        </td>
        <td class="center">
            
            <a class="btn btn-info" href="add_balance.php?update=<?php echo $trasanction['id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="emp_balance.php?del=<?php echo $trasanction['id']; ?>">
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