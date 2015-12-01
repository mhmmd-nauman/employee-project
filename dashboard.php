<?php 
include ('lib/include.php');
include('lib/header.php'); 

$obj=new Queries();
$objEmployee =new Employee();
$objTransaction =new Transaction();

if($_SESSION['session_admin_role']=='admin')
    {
    $employee_list=$obj->select("alpp_emp","1 order by emp_name limit 3",array("*"));
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
<div class="row"></div>

<?php require('lib/footer.php'); ?>
