<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_REQUEST['emp_id']."");
$balance=0.00;
$balance = $objTransaction->GetEmpBalance($_REQUEST['emp_id']);
$balance_detail= $objTransaction->GetEmpBalanceDeatil($_REQUEST['emp_id']);
$emp_data = $objEmployee->GetAllEmployee("emp_id = ".$_REQUEST['emp_id'],array("*"));
//var_dump($balance_detail);
if(isset($_REQUEST['del']))	
{	
        $id = $_REQUEST['del'];
	$del = $objTransaction->DeleteTransantion($id);
	
        if($del)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Transaction Deleted.";
            header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance.php?emp_id='.$_REQUEST['emp_id']);
	}
}
?>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
<?php if($_SESSION['session_admin_role']=='admin') { ?>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php?emp_id=<?php echo $_REQUEST['emp_id']?>">Add Balance</a>
        </li>
   <?php } ?>
        <li>
            Employee Balance Details
        </li>
    </ul>
</div>
<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php }?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i><?php echo $emp_data[0]['emp_name'];?>  ( Employee Balance Details )</h2>
            </div>
            
            <div class="col-md-8">
                <br><div class="alert"  style=" background-color:#f9f9f9;">
                    <b>You Have Total: <?php echo $balance;?> days available on <?php echo date("d M, Y");?></b> 
                    <br>FERIADO LEGAL         (<?php echo $balance_detail['I']-$balance_detail['leavesI'];?>)
                    <br>DIAS PROGRESIVOS    (<?php echo $balance_detail['D']-$balance_detail['leavesD'];?>)
                <br>
                </div>
            </div>
          <?php if($_SESSION['session_admin_role']=='admin') { ?>
            <div class="col-md-4 pull-right">
                <br>
                <p style="text-align: right;"><a class="btn btn-success" href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php?emp_id=<?php echo $_REQUEST['emp_id']?>"><i class="glyphicon icon-white"></i>Add Manual Balance</a></p>
                <br>
            </div>
          <?php } ?>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">            
<div class="box-content">
   <br>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" >
    <thead>
    <tr>
<!--        <th>ID</th>-->
        <th>Date</th>
      
        
        <th>Reason</th>
      
<!--        <th>Data Added</th>-->
        <th>Days</th>
        <th>Status</th>
<?php if($_SESSION['session_admin_role']=='admin') { ?>
        <th>Actions</th>
<?php } ?>   
    </tr>
    </thead>
    <tbody>
        <?php foreach($trasanction_list as $trasanction) {   ?>
        
    <tr>
<!--        <td><?php //echo $trasanction['id']; ?></td>-->
        <td><?php echo date("m/d/Y",strtotime($trasanction['entered_on_date'])); ?></td>
        
            <?php
            switch($trasanction['trans_type']) {
                case"M":
                    echo "<td>Manual</td>";
                    break;
                case"C":
                    echo "<td>Auto System Added</td>";
                    break;
                case"I":
                    echo "<td>FERIADO LEGAL</td>";
                    break;
                case"D":
                    echo "<td>DIAS PROGRESIVOS</td>";
                    break;
                case"L":
                    echo "<td>Leave</td>";
                    break;
            }?></td>
<!--        <td><?php //echo date("m/d/Y",strtotime($trasanction['entry_date'])); ?></td>-->
        <td><?php echo $trasanction['days']; ?></td>
        <td class="center">
           <?php if($trasanction['status']==0 && $trasanction['trans_type'] !='L') { ?>
            <span class="label-success label label-default">Active</span>
           <?php } 
            if($trasanction['status']==0 && $trasanction['trans_type'] =='L')       echo"<span class='label label-danger'>Pending</span>";
            else if($trasanction['status']==2 && $trasanction['trans_type'] =='L')	echo"<span class='label label-success'>Approved</span>";
            else if($trasanction['status']==1 && $trasanction['trans_type'] =='L')  echo"<span class='label label-small label-danger'>Cancelled </span>";
        ?>
        </td>
    
<?php if($_SESSION['session_admin_role']=='admin') { ?>    
        
        <td class="center">
            <?php if($trasanction['trans_type'] !="L"){?>
            <a class="btn btn-info" href="add_balance.php?update=<?php echo $trasanction['id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a onclick="return confirmation();" class="btn btn-danger" href="emp_balance.php?del=<?php echo $trasanction['id']; ?>&emp_id=<?php echo $trasanction['emp_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Delete
            </a>
            <?php }?>
        </td>
        
            
<?php }?>

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
<script>
    function confirmation() {
        var answer = confirm("Do you want to delete this record?");
    if(answer){
            return true;
    }else{
            return false;
    }
}
</script>
