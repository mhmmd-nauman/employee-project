<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee = new Employee();
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));

if($_REQUEST['process_now'] == 1){
    $count = 0;
    foreach($employee_list as $employee) {
        // check if the transaction allready exist on this date
        $trans_exist=$objTransaction->GetAllTrasanctions("alpp_emp.emp_id = ".$employee['emp_id']." and date(end_month_data) = '".date("Y-m-t")."' and trans_type = 'F'",array("alpp_emp.emp_id"));
        if(empty($trans_exist[0]['emp_id'])){
            
            $insert=$objTransaction->InsertTransaction(array(
                'emp_id'=>$employee['emp_id'],
                'end_month_data'=>date("Y-m-t h:i:s"),
                'amount'=>1.25,
                'trans_type'=>"F",
                'date'=> date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                'status'=>0
            ));
             
            $count++;
        }
        
    }
    $message_type="alert-success"; 
    $message_text = "<strong>Success!</strong> $count enteries completed successfully.";
    //header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance.php?emp_id='.$_REQUEST['emp_id']); 
}
if($_REQUEST['process_now'] == 2){
    $count = 0;
    foreach($employee_list as $employee) {
        // check if the transaction exist on this date
        $trans_exist=$objTransaction->GetAllTrasanctions("alpp_emp.emp_id = ".$employee['emp_id']." and date(end_month_data) = '".date("Y-m-t")."' and trans_type = 'F'",array("alpp_transactions.ID"));
        if($trans_exist[0]['ID']>0){
            
            $objTransaction->DeleteTransantion($trans_exist[0]['ID']);
             
            $count++;
        }
        
    }
    $message_type="alert-success"; 
    $message_text = "<strong>Success!</strong> $count enteries removed successfully.";
    //header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance.php?emp_id='.$_REQUEST['emp_id']); 
}

?>
<script>
    $(document).ready(function(){
        $(".add_balance").colorbox({iframe:true, width:"70%", height:"80%"});
    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">

<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php }?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Expected Feriado Legal Balance on <?php echo date("t-m-Y");?></h2>
            </div>
            <div class="col-md-7">
                <br>
                    
            </div>
            <div class="col-md-4">
                <br>
                <p style="text-align: right;">
                <a class="btn  btn-success btn-sm " href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_feriado_legal_cron.php?process_now=1"><i class="glyphicon icon-white"></i>Process Balance Now</a>
                <a class="btn  btn-success btn-sm " href="<?php echo SITE_ADDRESS; ?>employee/emp_balance_feriado_legal_cron.php?process_now=2"><i class="glyphicon icon-white"></i>Undo Process Balance Now</a>
                </p><br>
            </div>
            
           <div class="box-content">
               <table id="data_list" class="table table-striped table-bordered bootstrap-datatable  responsive" style="font-size: 12px;">
 <thead>
    <tr>
        <th>Ficha</th>
         <th style="width: 25%;">Nombre</th>
        <th>Department</th>
        
        <th>Feriado Legal</th>
        <th>Increment</th>
        
        <th>Feriado Legal <br>on <?php echo date("t-m-Y");?></th>
        <th style="width: 13%;">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {
            $inc = 1.25;
            $trans_exist=$objTransaction->GetAllTrasanctions("alpp_emp.emp_id = ".$employee['emp_id']." and date(end_month_data) = '".date("Y-m-t")."' and trans_type = 'F'",array("alpp_transactions.ID"));
            if($trans_exist[0]['ID']>0){
                $inc = 0;
            }
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']);
            ?>
        
    <tr>
        <td>
            <?php echo $employee['emp_file']; ?>
        </td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php  $balance = $balance_detail['F']-$balance_detail['leavesI'];
        echo number_format($balance,2);
        ?></td>
        <td><?php
        $d1 = new DateTime(date("Y-m-d"));
        $d2 = new DateTime(date("Y-m-d",strtotime($employee['emp_current_contract'])));

         $diff = $d2->diff($d1);
         $effective_year = $diff->y ;
         
        
        echo $inc;
          ?></td>
        <td class="center">
           <?php
        $balance = $balance+$inc;
         echo number_format($balance,2);
           ?>
        </td>
        <td>
       <?php if($inc > 0){?>
        <a class=" btn-success btn-sm add_balance" href="<?php echo SITE_ADDRESS; ?>/employee/add_balance.php?emp_id=<?php echo $employee['emp_id']; ?>&inc=<?php echo $inc;?>&day=<?php echo date("t");?>&trans_type=F">Add Manually</a>
       <?php } else {?>
        Processed
       <?php }?>
        </td>
    </tr>
        <?php 
        $balance = 0;
           } ?>
    
    </tbody>
    </table>
               <br>
               <br>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

    
<?php include('../lib/footer.php'); ?>