<?php 
include ('lib/include.php');
include('lib/header.php'); 
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
        <a data-toggle="tooltip" title="6 new members." class="well top-block" href="#">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Total Employees</div>
<?php  

      $obj=new Queries();
      $employee_list=$obj->select("alpp_emp","1 ",array("count(emp_id)"));
      //var_dump($employee_list);
   ?>
            <div><?php echo $employee_list[0][0]; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="4 new pro members." class="well top-block" href="#">
            <i class="glyphicon glyphicon-star green"></i>

            <div>Leave Notification</div>
            <div>0</div>
        </a>
    </div>

    
</div>

<div class="row"></div>


</div><!--/row-->
<?php require('lib/footer.php'); ?>
