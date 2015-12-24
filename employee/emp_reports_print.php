<?php 
include (dirname(__FILE__).'/../lib/include.php');
//include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_file",array("*"));
if($_REQUEST['date']) 
    $date=date('Y-m-d',strtotime($_REQUEST['date']));
else 
    $date=date('Y-m-d');
?>

  
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Report of <?php echo $date; ?></h2>
    <div class="box-content">    
        
        <table style=" font-size: 12px ; width: 100%" cellpadding="7" cellspacong="0" border="1">
        <thead>
        <tr>
            <th style=" width:5% ">Ficha</th>
            <th style=" width:35% ">Nombre</th>
            <th style=" width:10% ">Department</th>
            <th style=" width:10% ">RUT</th>
            <th style=" width:10% ">FECHA INGRESO</th>
            <th style=" width:10% ">Today Balance</th>
            <th style=" width:10% ">FERIADO LEGAL</th>
            <th style=" width:10% ">DIAS PROGRESIVOS</th>
        </tr>
        </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {           
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." and date <= '".$date." 12:60:60'");
            $balance=($balance_detail['I']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);?>      
        <tr>
            <td style=" text-align:center;"><?php echo $employee['emp_file']; ?></td>
            <td><?php echo $employee['emp_name']; ?></td>
            <td><?php echo $employee['emp_department']; ?></td>
            <td style=" text-align:center;"><?php echo $employee['emp_cellnum'];?></td>
            <td style=" text-align:center;"><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
            <td style=" text-align:right;"><?php   echo number_format($balance, 2);?></td>
            <td style=" text-align:right;"><?php   echo number_format(($balance_detail['I']-$balance_detail['leavesI']), 2);?></td>
            <td style=" text-align:right;"><?php   echo number_format(($balance_detail['D']-$balance_detail['leavesD']), 2);?></td>
        </tr>
        <?php 
        $balance = 0;
           } ?>
    </tbody>
    </table>
            </div>
        </div>
    </div>
</div>
<?php //include('../lib/footer.php'); ?>
<script>
$(function() {
$('#date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
});
</script>