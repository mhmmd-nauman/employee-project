<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
if($_REQUEST['date']) 
    $date=date('Y-m-d',strtotime($_REQUEST['date']));
else 
    $date=date('Y-m-d');
?>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Report</h2>
            </div>         
    <div class="box-content">    
        <form class="form-horizontal" role="form"  method="post" >  
            <div class="control-group">
                <label class="control-label" >Select Date</label>
                    <div class="controls">
                        <input type="date" style=" width: 20%" id="date" required="" class="form-control col-sm-2"  value="<?php echo $date;?>"  name="date">
                    </div>
            </div>  
            <div class=" col-sm-5 " style=" text-align: left;">
                <button type="submit" name="search" class="btn btn-small btn-info">Search</button>
            </div>            
            <div class=" col-sm-4 " style=" text-align: right;">
                <a href="emp_reports_csv.php?date=<?php echo $date;?>"  class="btn btn-small btn-success">Export to CSV</a>
                <a href="emp_reports_excel.php?date=<?php echo $date;?>"  class="btn btn-small btn-success">Export to Excel</a>
                <a href="emp_reports_print.php?date=<?php echo $date;?>"  class="btn btn-small btn-warning">Print</a>
            </div>            
        </form> 
    <br><br><br>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
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
            </div>
        </div>
    </div>
</div>
<?php include('../lib/footer.php'); ?>
<script>
$(function() {
$('#date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
});
</script>