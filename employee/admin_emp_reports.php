<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
?>
<?php 
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","emp_type = 2 order by emp_name",array("*"));
//print_r($employee_list);
?>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>  Empleados Supervisors </h2>
            </div>
           <div class="box-content">
               <br>
            <table class="table table-striped table-bordered bootstrap-datatable  responsive" style=" font-size: 12px;">
  
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nombre</th>
                    <th>Department</th>
                    <th>RUT</th>
                    <th>FECHA INGRESO</th>
                    <th style=" width: 10px;">Feriados Disponibles</th>
                    
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($employee_list as $employee) {  
            $balance = $objTransaction->GetEmpBalance($employee['emp_id']);
            ?>
        
    <tr>
        <td>
            <?php echo $employee['emp_file']; ?>
        </td>
<!--        <td><a class="btn btn-success btn-sm add_employee" href="add_employee.php?view=<?php //echo $employee['emp_id']; ?>"><?php //echo $employee['emp_file']; ?></a></td>-->
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo $employee['emp_department']; ?></td>
        <td><?php echo $employee['emp_cellnum'];
                    
                    /*
                    $submit=$obj->update("alpp_emp","emp_id=".$employee['emp_id'],array(
                            'emp_cellnum'         =>$str));
                     * 
                     */
        
        ?></td>
        <td><?php echo date("d-m-Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php   $balance = $objTransaction->GetEmpBalance($employee['emp_id']); 
        echo number_format($balance, 2);
        ?></td>
<!--        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php //echo $balance; ?>
            </a>
            </td>-->
        
       
        
        
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
  