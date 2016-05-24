<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
?>
<?php 
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","emp_status = 1 order by emp_name",array("*"));
//print_r($employee_list);
?>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>  En Empleados Activos </h2>
            </div>
           <div class="box-content">
               <br>
             <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style=" font-size: 12px;">
  
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nombre</th>
                    <th>Department</th>
                    <th>RUT</th>
                    <th>FECHA INGRESO</th>
                    <th style=" width: 10px;">Feriados Disponibles</th>
                    <th>Status/ Notes</th>
                    
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($employee_list as $employee) {  
            $balance = $objTransaction->GetEmpBalance($employee['emp_id']);
            ?>
        
    <tr>
        <td><a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>"><?php echo $employee['emp_file']; ?></a></td>
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
        <td><?php echo date("d/m/Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php   $balance = $objTransaction->GetEmpBalance($employee['emp_id']); 
            echo number_format($balance, 2);
            ?>
            </a>
            </td>
<!--        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php //echo $balance; ?>
            </a>
            </td>-->
        <td class="center" style="text-align: center;">
           <?php if($employee['emp_status']==0) { ?>
            <a class="btn btn-success btn-sm"><i title="Status" class="glyphicon glyphicon-ok icon-ok"></i></a>
            
           <?php } else{ ?>
              <a class="btn btn-danger btn-sm"><i title="Status" class="glyphicon glyphicon-remove"></i></a>
           <?php } ?>&nbsp;<a title="Manage Notes" class="btn btn-info btn-sm add_employee_notes" href="add_employee_notes.php?emp_id=<?php echo $employee['emp_id']; ?>"><span class="glyphicon glyphicon-file"></span>
            </a>
        </td>
        
        
        <td class="center">
            <a class="btn btn-warning btn-sm" href="emp_leave.php?emp_id=<?php echo $employee['emp_id']; ?>" title="Ingresar solicitud individual">
           Solicitud
         </a>
        <a class="btn btn-info btn-sm add_employee" href="add_employee.php?update=<?php echo $employee['emp_id']; ?>">
           <i class="glyphicon glyphicon-edit icon-white"></i>
         </a>
         <a class="btn btn-danger btn-sm" onclick="return confirmation();" href="emp_list.php?del=<?php echo $employee['emp_id']; ?>">
             <i class="glyphicon glyphicon-trash icon-white"></i>
         </a>
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
  