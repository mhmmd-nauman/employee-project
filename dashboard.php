<?php 
include ('lib/include.php');
include('lib/header.php'); 

$obj=new Queries();
$objEmployee =new Employee();
$objTransaction =new Transaction();

if($_SESSION['session_admin_role']=='admin')
    {
    $active_employee=$obj->select("alpp_emp"," emp_status=0",array("count(emp_id)"));
    $inactive_employee=$obj->select("alpp_emp"," emp_status=1",array("count(emp_id)"));
    $active_admin=$obj->select("alpp_emp"," emp_type=1",array("count(emp_id)"));
    $pending_leaves=$obj->select("alpp_leave"," leave_approval=0",array("count(leave_id)"));
    
    $leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","1 order by emp_name limit 3",array("*"));
    $emp_link ="<a href=".SITE_ADDRESS."employee/emp_list.php>Employee list [All]</a>";
    $leave_link ="<a href=".SITE_ADDRESS."leave/leave_list.php>Dias solicitados [All]</a>";
    }
else 
    {
    $employee_list=$obj->select("alpp_emp","emp_id = ".$_SESSION['session_admin_id'] ." order by emp_name limit 3",array("*"));
    $leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","leave_emp_id=".$_SESSION['session_admin_id']." order by emp_name limit 3",array("*"));
    $emp_link="Balance Detail";
    $leave_link ="Dias solicitados";
    } 


?>
<script>
    $(document).ready(function(){
            $(".add_employee").colorbox({iframe:true, width:"70%", height:"80%"});
    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">

 <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
    </ul>


            <?php if($_SESSION['session_admin_role']=='admin')
            { ?>
        
             <div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $active_employee[0][0]; ?>">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Active Members</div>
            <div><?php echo $active_employee[0][0]; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $inactive_employee[0][0]; ?>">
            <i class="glyphicon glyphicon-user green"></i>
            <div>InActive Members</div>
            <div><?php echo $inactive_employee[0][0]; ?></div>
        </a>
    </div>


    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $active_admin[0][0]; ?>">
            <i class="glyphicon glyphicon-user Red"></i>
            <div>Admin(s)</div>
            <div><?php echo $active_admin[0][0]; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $pending_leaves[0][0]; ?>">
            <i class="glyphicon glyphicon-star yellow"></i>
            <div>Pending Leaves</div>
            <div><?php echo $pending_leaves[0][0]; ?></div>
        </a>
    </div>
</div>

        <?php 
        } else{?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">      <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-star-empty"></i> Welcome <?php echo $_SESSION['session_admin_name'];?></h2>
    </div>
            <div class="box-content" style="text-align: center;">
                <div class="row alert alert-info" style=" text-align: center;">
                You can login using RUT or Email and Password.
                </div>
                <br>
                <a class="btn btn-success add_employee" href="<?php echo SITE_ADDRESS; ?>employee/update_employee_profile.php?update=<?php echo $_SESSION['session_admin_id']; ?>">Change Login Details</a>
                <br>
            </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->
     <?php }?>


<?php require('lib/footer.php'); ?>
