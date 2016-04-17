<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
$month_array=array("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");

if($_REQUEST['month']) { $month=$_REQUEST['month']; $year=$_REQUEST['year'];}
else                   { $month=date('m'); $year=date('Y');}

 $first_day_this_month = date($year.'-'.$month.'-01'); // hard-coded '01' for first day
 $last_day_this_month  = date($year.'-'.$month.'-t');
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
                    <div class="controls col-md-2">
                        <select name="month" required class="form-control col-md-12"  >
                        <?php	foreach($month_array as $key=>$value) 	
                        {
                            $sel=($month==$key) ? 'selected' : '';
                            echo"<option value=".$key." $sel>".$value."</option>";
                        
                        } ?>	
                        </select>
                    </div>
                    <div class="controls  col-md-2">
                    <select name="year" required class="form-control col-md-12" >
                        <?php	for($i=date('Y'); $i>=2015; $i--) 	
                        {
                            $sel=($year==$i) ? 'selected' : '';
                            echo"<option value=".$i." $sel>".$i."</option>";
                        
                        } ?>	
                        </select>
                    </div>
            </div>  
            <div class=" col-md-4 " style=" text-align: left;">
                <button type="submit" name="search" class="btn btn-small btn-info">Search</button>
            </div>            
            <div class=" col-md-4 " style=" text-align: right;">
<!--                <a href="emp_reports_csv.php?date=<?php echo $date;?>"  class="btn btn-small btn-success">Export to CSV</a>-->
                <a href="emp_monthly_reports_print.php?month=<?php echo $month;?>&year=<?php echo $year;?>"  class="btn btn-small btn-warning">Print</a>
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
            <th>Total Used</th>
            <th>FERIADO LEGAL</th>
            <th>DIAS PROGRESIVOS</th>
        </tr>
        </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {           
?>      
        <tr>
            <td><?php 
            $balance_detail= $objTransaction->GetEmpLeaveBalanceDetail($employee['emp_id'] ,$first_day_this_month ,$last_day_this_month);
            
            //$balance_detail= $objTransaction->GetEmpLeaveBalanceDetail($employee['emp_id']." and ( leave_duration_from >= '".$first_day_this_month." 00:00:00' && leave_duration_to <= '".$last_day_this_month." 12:60:60' )");
            $balance=$balance_detail['leavesI']+$balance_detail['leavesD'];
            
            echo $employee['emp_file']; ?></td>
            <td><?php echo $employee['emp_name']; ?></td>
            <td><?php echo $employee['emp_department']; ?></td>
            <td><?php echo $employee['emp_cellnum'];?></td>
            <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
            <td><?php   echo number_format($balance, 2);?></td>
            <td><?php   echo number_format(($balance_detail['leavesI']), 2);?></td>
            <td><?php   echo number_format(($balance_detail['leavesD']), 2);?></td>
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