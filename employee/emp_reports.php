<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();

if(isset($_REQUEST['search']))
{
    $employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
}
?>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
<?php if($_SESSION['session_admin_role']=='admin') { ?>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php?emp_id=<?php echo $_REQUEST['emp_id']?>">Add Balance</a>
        </li>
   <?php } ?>
        <li>
            Employee Balance Details
        </li>
    </ul>
</div>
<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php }?>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">

    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>Balance Report</h2>
            </div>
        <div class="box-content">
        <br>
            <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">  
                    <div class="form-group">                    
                        <label class="control-label col-sm-2">Choose Date</label>                     
                        <div class="col-sm-2">
                            <input type="text" id="date" required="" class="form-control col-sm-2"  value="<?php echo $_REQUEST['date'];?>"  name="date">
                        </div>
                        <div class=" col-sm-4 " style=" text-align: left;">
                            <button type="submit" name="search" class="btn btn-small btn-info">Search By Date</button>
                         </div>
                    </div>
                        
            </form>
        </div>
       <div class="box-content">
           <h3>Balance till : <?php echo $_REQUEST['date'];?></h3>
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
          
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." and date <= '".$_REQUEST['date']." 12:60:60'");
            $balance=($balance_detail['I']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);
        ?>      
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
<?php include('../lib/footer.php'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    function confirmation() {
        var answer = confirm("Do you want to delete this record?");
    if(answer){
            return true;
    }else{
            return false;
    }
}
</script>
<script>
$(function() {
$('#date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
});

</script>
