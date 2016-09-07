<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
?>
<?php 
$obj=new Queries();
$str = "";
if($_SESSION['session_admin_is_super'] == "Y"){
    //$str = ",3,4,1";
} 
$employee_list=$obj->select("alpp_emp","emp_type in( 2 $str) order by emp_name",array("*"));

//print_r($employee_list);
?>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Supervisors/Managers/Administrators </h2>
            </div>
           <div class="box-content">
               <br>
            <table class="table table-striped table-bordered bootstrap-datatable  responsive" style=" font-size: 12px;">
  
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>RUT</th>
                    <th>Type</th>
                    <th style="text-align: center;">Workers</th>
                    <th>Actions</th>
                    
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($employee_list as $employee) {  
            
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
        <td>
            <?php  switch ($employee['emp_type']){
                    case 1:
                        echo "Worker";
                        break;    
                    case 2:
                        echo "Supervisor";
                        break;
                    case 3:
                        echo "Manager";
                        break;
                    case 4:
                        echo "Administrators";
                        break;
                    } 
                    $workers =$obj->select("alpp_emp","emp_supervisor = ".$employee['emp_id'],array("count(*) as total_workers"));
                    ?>
        </td>
        
        <td style="text-align: center;">
            <a class="" href="emp_list.php?emp_id=<?php echo $employee['emp_id']; ?>&viewworkers=1">
            <?php echo $workers[0]['total_workers']; ?>
            </a>
            </td>
        <td>
        <?php if( $_SESSION['session_admin_role'] == 'admin' ){?>  
            <a class=" add_employee" href="add_employee.php?update=<?php echo $employee['emp_id']; ?>">
               <i class="glyphicon glyphicon-edit icon-white"></i>
            </a>&nbsp;
            <a class=" " onclick="return confirmation();" href="emp_list.php?del=<?php echo $employee['emp_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
            </a>
        <?php }?>
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
  