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
                <h2><i class="glyphicon glyphicon-star-empty"></i> Expected Dias Progresivos Balance on <?php echo date("t-m-Y");?></h2>
            </div>
            
            
            
           <div class="box-content">
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
 <thead>
    <tr>
        <th>Ficha</th>
        <th style="width: 25%;">Nombre</th>
        <th>Department</th>
        <th>FECHA INGRESO</th>
        <th>Years</th>
        <th>Dias Progresivos</th>
        <th>Increment</th>
        
        <th>Dias Progresivos <br>on <?php echo date("t-m-Y");?></th>
        <th style="width: 13%;">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {  
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']);
            $inc=0;
            $css_string = "";
            $next_date =  get_next_incrementday(date("d-m-Y",strtotime($employee['emp_current_contract'])));
            
            if(date("Y",strtotime($next_date)) == date("Y",strtotime("+1 Year")) &&  date("m",strtotime($next_date)) == date("m")){
                 
                 $d1 = new DateTime(date("Y-m-d"));
                 $d2 = new DateTime(date("Y-m-d",strtotime($employee['emp_current_contract'])));

                 $diff = $d2->diff($d1);
                 $effective_year = $diff->y ;
                 if($effective_year >= 13){
                     $inc = 1;
                     $css_string = "class=\" danger\"";
                 }
            ?>
        
        <tr <?php echo $css_string; ?> >
        <td><?php echo $employee['emp_file']; ?></td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php 
         echo $effective_year ; ?></td>
        <td><?php echo $balance = $balance_detail['D']-$balance_detail['leavesD'];?></td>
        <td><?php
          //echo ;
            echo $inc;
            ?>
        </td>
        <td class="center">
           <?php
           $balance= $balance+$inc;
           
           echo number_format($balance,2);
           ?>
        </td>
        <td>
        <?php if($inc == 1){
        ?>
        <a class=" btn-success btn-sm add_balance" href="<?php echo SITE_ADDRESS; ?>/employee/add_balance.php?emp_id=<?php echo $employee['emp_id']; ?>&inc=<?php echo $inc;?>&day=<?php echo date("d",strtotime($next_date));?>&trans_type=D">Add Manually</a>
            <?php } ?>
        </td>
       
       
        
        
        
    </tr>
        <?php 
        $balance = 0;
           
        }
      } ?>
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php include('../lib/footer.php'); 
function get_next_incrementday($birthday) {
    $date = new DateTime($birthday);
    $date->modify('+' . date('Y') - $date->format('Y') . ' years');
    if($date < new DateTime()) {
        $date->modify('+1 year');
    }

    return $date->format('d-m-Y');
}
?>
