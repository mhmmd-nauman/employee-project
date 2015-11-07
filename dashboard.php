<?php 
include ('lib/include.php');
include('lib/header.php'); 

$obj=new Queries();

$objTransaction =new Transaction();
$trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_SESSION['session_admin_id']." ");
$balance=0.00;
$balance = $objTransaction->GetEmpBalance($_SESSION['session_admin_id']);

$leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id "," leave_emp_id=".$_SESSION['session_admin_id']."  order by leave_id desc limit 3",array("*")); 




// $employee_list=$obj->select("alpp_emp","1 ",array("count(emp_id)"));
// $leave_list=$obj->select("alpp_leave","1 ",array("count(leave_id)"));
// $balance = $objTransaction->GetEmpBalance($_SESSION['session_admin_id']);
// 
// /// to get the leaves of current month
// $last_day = date("Y-m-t", strtotime(date('Y-m-01')) ) ;
// $leaves_applied=$obj->select("alpp_leave","leave_emp_id=".$_SESSION['session_admin_id']." and  "
//         . "( leave_duration_from  between '".date('Y-m-01')."' and '".$last_day."' || leave_duration_to  between '".date('Y-m-01')."' and '".$last_day."') " ,array("count(leave_id)"));
 
     
if($_SESSION['session_admin_role']=='admin')
{       
?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="dashboard.php">Dashboard</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $employee_list[0][0]; ?> new employees." class="well top-block" href="#">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Employees</div>

            <div><?php echo $employee_list[0][0]; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $leave_list[0][0]; ?>." class="well top-block" href="#">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Leave Notification</div>
            <div><?php echo $leave_list[0][0]; ?></div>
        </a>
    </div>

    
</div>
   <?php }
if($_SESSION['session_admin_role']=='employee')
{
?>
<div>
    <ul class="breadcrumb">
        <li>
            <h5>  <a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php?emp_id=<?php echo $_SESSION['session_admin_id']; ?>">Balance </a> <?php echo $balance;?> day(s) after deducting leaves    </h5>
        </li>
    </ul>
</div>
  
     <table class="table table-striped table-bordered" >
    <thead>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Days</th>
        <th>Description</th>
        <th>Data Added</th>
        <th>Status</th>
<?php if($_SESSION['session_admin_role']=='admin') { ?>
        <th>Actions</th>
<?php } ?>   
    </tr>
    </thead>
    <tbody>
        <?php foreach($trasanction_list as $trasanction) {   ?>
        
    <tr>
        <td><?php echo $trasanction['id']; ?></td>
        <td><?php echo date("m/d/Y",strtotime($trasanction['entered_on_date'])); ?></td>
        <td><?php echo $trasanction['days']; ?></td>
        <td>
            <?php
            switch($trasanction['trans_type']) {
                case"C":
                echo "Received";
                    break;
                
                case"L":
                    echo "Leave";
                    break;
                    
                    
            }?></td>
        <td><?php echo date("m/d/Y",strtotime($trasanction['entry_date'])); ?></td>
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


<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Leaves</a>
        </li>
    </ul>
</div>



     <table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Days</th>
        <th>Duration</th>
        <th>Reason</th>
        <th>Status</th>
        <?php   if($_SESSION['session_admin_role']=='admin') { ?><th>Actions</th><?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach($leave_list as $leave) {      ?>
    <tr>
        <td><?php echo $leave['emp_name']; ?></td>
        <td><?php echo $leave['leave_duration']; ?></td>
        <td>
        <?php   $from=$to='';
                    if($leave['leave_duration_from'])
                    {
                               $from = new DateTime($leave['leave_duration_from']);
                               echo  $from = $from->format("d-m-Y");

                            if($leave['leave_duration_to'])
                            {
                                        echo "  -  "; 
                                        $to = new DateTime($leave['leave_duration_to']);
                                       echo $to = $to->format("d-m-Y");
                            }
                    }
        ?>
        </td>
        <td><?php echo $leave['leave_reason']; ?></td>           			
<?php	if($leave['leave_approval']==0)       echo"<td class='hidden-phone '><span class='label label-danger'>Pending</span></td>";
	else if($leave['leave_approval']==2)	echo"<td class='hidden-phone '><span class='label label-success'>Approved</span></td>";
	else if($leave['leave_approval']==1)  echo"<td class='hidden-phone '><span class='label label-small label-danger'>Cancelled </span></td>";
?>      </tr>
        <?php } ?>
    
    </tbody>
    </table>

    </div><!--/row-->

   <?php } ?>
  
<div class="row"></div>


</div><!--/row-->
<?php require('lib/footer.php'); ?>
