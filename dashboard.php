<?php 
include ('lib/include.php');
include('lib/header.php'); 

 $obj=new Queries();
 $objTransaction =new Transaction();
 
 $employee_list=$obj->select("alpp_emp","1 ",array("count(emp_id)"));
 $leave_list=$obj->select("alpp_leave","1 ",array("count(leave_id)"));
 $balance = $objTransaction->GetEmpBalance($_SESSION['session_admin_id']);
 
 /// to get the leaves of current month
 $last_day = date("Y-m-t", strtotime(date('Y-m-01')) ) ;
 $leaves_applied=$obj->select("alpp_leave","leave_emp_id=".$_SESSION['session_admin_id']." and  "
         . "( leave_duration_from  between '".date('Y-m-01')."' and '".$last_day."' || leave_duration_to  between '".date('Y-m-01')."' and '".$last_day."') " ,array("count(leave_id)"));
 
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
<?php  

     
   if($_SESSION['session_admin_role']=='admin')
   {
       
?>
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
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $balance; ?> balance." class="well top-block" href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php?emp_id=<?php echo $_SESSION['session_admin_id']; ?>">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Balance</div>

            <div><?php echo $balance; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $leaves_applied[0][0]; ?> Applied." class="well top-block" href="#">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Leaves of  <?php 
            
                                $timestamp = mktime(0, 0, 0, date('m'), 10);
                                $monthName = date("F", $timestamp);
                                echo $monthName; 
                            ?>
            </div>
            <div><?php echo $leaves_applied[0][0]; ?></div>
        </a>
    </div>

    
</div>

   <?php } ?>
  
<div class="row"></div>


</div><!--/row-->
<?php require('lib/footer.php'); ?>
