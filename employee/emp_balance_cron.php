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
            $(".add_employee").colorbox({iframe:true, width:"70%", height:"80%"});
    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">


<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Expected Balance</h2>
            </div>
            
            
            
           <div class="box-content">
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
 <thead>
    <tr>
        <th>Ficha</th>
        <th>Nombre</th>
        <th>Department</th>
        <th>FECHA INGRESO</th>
<!--        <th>Year</th>-->
        <th>Current Balance</th>
        <th>Increment</th>
        
        <th>New Balance</th>
       
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {  
            
            ?>
        
    <tr>
        <td><a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>"><?php echo $employee['emp_file']; ?></a></td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($employee['emp_current_contract'])); ?></td>
<!--        <td><?php //echo $employee['emp_count']; ?></td>-->
        <td><?php echo $balance = $objTransaction->GetEmpBalance($employee['emp_id']); ?></td>
        <td><?php
        $d1 = new DateTime(date("Y-m-d"));
        $d2 = new DateTime(date("Y-m-d",strtotime($employee['emp_current_contract'])));

         $diff = $d2->diff($d1);
         $effective_year = $diff->y ;
         //$objEmployee->UpdateEmployee("emp_id = ".$employee['emp_id'], array("emp_count"=>$effective_year));
//         //echo "=";
//         if($effective_year > 0){
//             echo number_format((double)(($effective_year+15)/12),2);
//         }
        
        echo "1.25";
          ?></td>
       
       
        
        <td class="center">
           <?php
        echo $balance+1.25;
           
//           echo number_format((double)(($effective_year+15)/12)+$balance,2);
           ?>
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