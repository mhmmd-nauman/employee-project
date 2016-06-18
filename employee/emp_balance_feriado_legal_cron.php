<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee = new Employee();
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));
?>
<script>
    $(document).ready(function(){
        $(".add_balance").colorbox({iframe:true, width:"70%", height:"80%"});
    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Expected Feriado Legal Balance on <?php echo date("t-m-Y");?></h2>
            </div>
            
            
            
           <div class="box-content">
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
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
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']);
            ?>
        
    <tr>
        <td>
            <?php echo $employee['emp_file']; ?>
        </td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo $balance = $balance_detail['I']-$balance_detail['leavesI'];?></td>
        <td><?php
        $d1 = new DateTime(date("Y-m-d"));
        $d2 = new DateTime(date("Y-m-d",strtotime($employee['emp_current_contract'])));

         $diff = $d2->diff($d1);
         $effective_year = $diff->y ;
         
        
        echo "1.25";
          ?></td>
        <td class="center">
           <?php
        $balance = $balance+1.25;
         echo number_format($balance,2);
           ?>
        </td>
        <td>
       
        <a class=" btn-success btn-sm add_balance" href="<?php echo SITE_ADDRESS; ?>/employee/add_balance.php?emp_id=<?php echo $employee['emp_id']; ?>&inc=<?php echo 1.25;?>&day=<?php echo date("t");?>&trans_type=I">Add Manually</a>
            
        </td>
    </tr>
        <?php 
        $balance = 0;
           } ?>
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php include('../lib/footer.php'); ?>