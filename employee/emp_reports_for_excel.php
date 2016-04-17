<?php 
include (dirname(__FILE__).'/../lib/include.php');
//include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
if($_REQUEST['date']) 
    $date=date('Y-m-d',strtotime($_REQUEST['date']));
else 
    $date=date('Y-m-d');
?>
   
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
        <thead>
        <tr>
            <th>Ficha</th>
            <th>Nombre</th>
            <th>Department</th>
            <th>RUT</th>
            <th>FECHA INGRESO</th>
            <th>Today Balance</th>
            <th>FERIADO LEGAL</th>
            <th>DIAS PROGRESIVOS</th>
        </tr>
        </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {           
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." and date <= '".$date." 12:60:60'");
            $balance=($balance_detail['I']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);?>      
        <tr>
            <td><?php echo $employee['emp_file']; ?></td>
            <td><?php echo $employee['emp_name']; ?></td>
            <td><?php echo $employee['emp_department']; ?></td>
            <td><?php echo $employee['emp_cellnum'];?></td>
            <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
            <td><?php   echo number_format($balance, 2);?></td>
            <td><?php   echo number_format(($balance_detail['I']-$balance_detail['leavesI']), 2);?></td>
            <td><?php   echo number_format(($balance_detail['D']-$balance_detail['leavesD']), 2);?></td>
        </tr>
        <?php 
        $balance = 0;
           } ?>
    </tbody>
    </table>
            