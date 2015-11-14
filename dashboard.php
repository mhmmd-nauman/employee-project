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
<div>
    <ul class="breadcrumb">
        <li>
            <h5>  <?php echo $emp_link; ?>  </h5>
        </li>
    </ul>
</div>
        
        
<table class="table table-striped table-bordered ">
    <thead>
    <tr>
        <th>Ficha</th>
        <th>Nombre</th>
        <th>Department</th>
        <th>RUT</th>
        <th>FECHA INGRESO</th>
        <th>FERIADO LEGAL<br> PROPORCIONAL 2015<br> A LA FECHA</th>
        <th>Vacaciones Anuales</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {  
            $balance = $objTransaction->GetEmpBalance($employee['emp_id']);
            ?>
        
    <tr>
        <td><a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>"><?php echo $employee['emp_file']; ?></a></td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo $employee['emp_cellnum']; ?></td>
        <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php echo $employee['emp_count']; ?></td>
       
       
        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php echo $balance; ?>
            </a>
            </td>
        <td class="center">
           <?php if($employee['emp_status']==0) { ?>
            <span class="label-success label label-default">Active</span>
           <?php } ?>
        </td>
  </tr>
        <?php 
        $balance = 0;
           } ?>
    
    </tbody>
    </table>
    
            

<div>
    <ul class="breadcrumb">
        <li>
            <h5>  <?php echo $leave_link; ?>  </h5>
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
    </tr>
    </thead>
    <tbody>
    <?php 
    if(is_array($leave_list))
    {
        foreach($leave_list as $leave) {      ?>
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
        <?php }
    }
    else
        {
           echo "<tr><td colspan=5 >No Record Found</td></tr>"; 
        }
?>
    
    </tbody>
    </table>
<?php 
 
        
 //////////// code below is for employee dashboard
?>
  
<div class="row"></div>

<?php require('lib/footer.php'); ?>
