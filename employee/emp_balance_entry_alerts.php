<?php 
include ('../lib/include.php');
include('../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee = new Employee();
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));
?> 
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <?php if($_SESSION['session_admin_role']=='admin')
            {?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Manual Balance Entry Alerts</h2>
            </div>
           <div class="box-content">
     <br>
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
 <thead>
    <tr>
        <th>Ficha</th>
        <th>Nombre</th>
        <th>Department</th>
        <th>FECHA INGRESO</th>
        
        <th>Current Balance</th>
        <th>Increment</th>
        <th>New Balance</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {
            $hire_date=date("d-m-Y",strtotime($employee['emp_current_contract']));
            $date_array = explode("-", $hire_date);
            $day = $date_array[0];
            $month = $date_array[1];
            $year = date("Y");
            $check_manual_balance_date =  date("Y-m-d",strtotime((int)$year."-".(int)$month."-".$day));
           
            //echo "<br>";
            $starting = new DateTime($hire_date);
            $today = new DateTime($check_manual_balance_date);
            $diff = $starting->diff($today);
            if($day >= date("d") && $month == date('m')){
            //if(1){   
            
            ?>
        
    <tr>
        <td>
            <a class="btn btn-success btn-sm" href="<?php echo SITE_ADDRESS; ?>/employee/emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>"><?php echo $employee['emp_file']; ?></a>
        </td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo $hire_date=date("d-m-Y",strtotime($employee['emp_current_contract'])); ?></td>
        
        <td><?php echo $balance = number_format($objTransaction->GetEmpBalance($employee['emp_id']),2); ?></td>
        <td><?php
        //echo $hire_date;
        //echo "<br>";
        //echo $check_manual_balance_date;
        //echo "<br>";
        //echo "<pre>";
        //print_r($date_array);
        //echo "</pre>";
        //ALTER TABLE `alpp_emp` ADD `emp_last_transaction_date` DATE NULL ;
         echo "1.25";
          ?></td>
       
       
        
        <td class="center">
           <?php
        echo $balance+1.25;
           
//           echo number_format((double)(($effective_year+15)/12)+$balance,2);
           ?>
        </td>
        <td>
             <a class="btn btn-success btn-sm" href="<?php echo SITE_ADDRESS; ?>/employee/add_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">Add Manually</a>
        </td>
    </tr>
        <?php 
        $balance = 0;
           }
          
        }?>
    
    </tbody>
    </table>
    
    </div>
     <?php } else{?>
      <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-star-empty"></i> Welcome <?php echo $_SESSION['session_admin_name'];?></h2>
    </div>
            <div class="box-content" style="text-align: center;">
                <div class="row alert alert-info" style=" text-align: center;">
                You can login using RUT or Email and Password.
                </div>
                <br>
                <a class="btn btn-success add_employee" href="<?php echo SITE_ADDRESS; ?>employee/update_employee_profile.php?update=<?php echo $_SESSION['session_admin_id']; ?>">Change Login Details</a>
                <br>
            </div>
     <?php }?>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php require('../lib/footer.php'); ?>
