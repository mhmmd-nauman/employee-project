<?php 
include ('lib/include.php');
include('lib/header.php'); 

$obj=new Queries();
$objEmployee =new Employee();
$objTransaction =new Transaction();

if($_SESSION['session_admin_role']=='admin')
    {
    $active_employee=$obj->select("alpp_emp"," emp_status=0 and emp_type = 1",array("count(emp_id)"));
    $inactive_employee=$obj->select("alpp_emp"," emp_status=1",array("count(emp_id)"));
    $active_admin=$obj->select("alpp_emp"," emp_type=2",array("count(emp_id)"));
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

 


            <?php if($_SESSION['session_admin_role']=='admin' || $_SESSION['session_admin_role']=='supervisor')
            { ?>
        
             <div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="employee/active_emp_reports.php" data-original-title=" Empleados activos <?php echo $active_employee[0][0]; ?>">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Empleados activos</div>
            <div><?php echo $active_employee[0][0]; ?></div>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="employee/inactive_emp_reports.php" data-original-title=" Empleados Inactivos <?php echo $inactive_employee[0][0]; ?>">
            <i class="glyphicon glyphicon-user green"></i>
            <div>Empleados Inactivos</div>
            <div><?php echo $inactive_employee[0][0]; ?></div>
        </a>
    </div>

 <?php if($_SESSION['session_admin_role']=='admin'){?>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="employee/admin_emp_reports.php" data-original-title=" Supervisors/Managers <?php echo $active_admin[0][0]; ?>">
            <i class="glyphicon glyphicon-user Red"></i>
            <div>Supervisors/Managers</div>
            <div><?php echo $active_admin[0][0]; ?></div>
        </a>
    </div>
<?php }?>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="" class="well top-block" href="leave/leave_list.php" data-original-title="Solicitudes Pendientes <?php echo $pending_leaves[0][0]; ?>">
            <i class="glyphicon glyphicon-star yellow"></i>
            <div>Solicitudes Pendientes</div>
            <div><?php echo $pending_leaves[0][0]; ?></div>
        </a>
    </div>
</div>

        <?php 
        } else{
            // emp balance
            //print_r($_SESSION);
            $balance_detail= $objTransaction->GetEmpBalanceDetail($_SESSION['session_admin_id']);
            $bI = $balance_detail['I']-$balance_detail['leavesI'];
            $bD = $balance_detail['D']-$balance_detail['leavesD'];
            ?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">      
            <div class="box-header well" data-original-title="">
            <h2><i class="glyphicon glyphicon-star-empty"></i> Bienvenido ( <?php echo $_SESSION['session_admin_name'];?> )</h2>
            </div>
            <div class="box-content" style="text-align: center;">
                <div class="row">
                    <div class=" col-md-12">
                    <div class="row alert alert-info" style=" text-align: center;">
                    You can login using RUT or Email and Password.
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-12">
                        <table class="table table-striped table-bordered" >
                            <tr>
                                
                                <th>Feriado  Legal</th><td style=" background-color: #FFFFFF"><?php echo $bI;?></td>
                                <th>Dias Progresivos</th><td style=" background-color: #FFFFFF"><?php echo $bD;?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-12">
                    <a class="btn btn-success add_employee" href="<?php echo SITE_ADDRESS; ?>employee/update_employee_profile.php?update=<?php echo $_SESSION['session_admin_id']; ?>">Actualizar Inicio de Sesión detalles</a>
                    <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->

    </div><!--/row-->
     <?php }?>


<?php require('lib/footer.php'); ?>
