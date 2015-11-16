<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
?>
<script>
    $(document).ready(function(){
            $(".add_employee").colorbox({iframe:true, width:"70%", height:"80%"});
    });
</script>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a class="add_employee" href="<?php echo SITE_ADDRESS; ?>employee/add_employee.php">Add</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/emp_list.php">Employee List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Employee</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
      $obj=new Queries();
      $employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));

      
 	 
if(isset($_REQUEST['del']))	
{	

        $id = $_REQUEST['del'];
	$del = $obj->Delete("alpp_emp",'emp_id='.$id);
	 
	if($del)
	{
		 ?>
         <div class="widget-body">
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Deleted.
                            </div>
         </div>
     	 <?php
		header('refresh:1, url=emp_list.php');
	}
}
?>
      <p style="text-align: right;">
          <!--
          <a class="btn btn-info add_employee" href="<?php echo SITE_ADDRESS; ?>employee/emp_import_balance.php"><i class="glyphicon icon-white"></i>Import Employee Balance</a>&nbsp;
          <a class="btn btn-success" href="<?php echo SITE_ADDRESS; ?>employee/emp_import_data.php"><i class="glyphicon icon-white"></i>Import Employee Data</a>&nbsp;
          -->
          <a class="btn btn-warning add_employee" href="<?php echo SITE_ADDRESS; ?>employee/add_employee.php"><i class="glyphicon icon-white"></i>Add Employee</a>
     
     	
      </p>
        
     <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
  
         <thead>
    <tr>
        <th>Ficha</th>
        <th>Nombre</th>
        <th>Department</th>
        <th>RUT</th>
        <th>FECHA INGRESO</th>
        <th>Feriados Disponibles</th>
<!--        <th>Vacaciones Anuales</th>-->
        <th>Status</th>
        <th width="20%">Actions</th>
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
        <td><?php 
        
        echo str_replace("00", '', $employee['emp_cellnum']);
        //echo $employee['emp_cellnum']; ?></td>
        <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php echo $employee['emp_count']; ?></td>
       
       
<!--        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php //echo $balance; ?>
            </a>
            </td>-->
        <td class="center">
           <?php if($employee['emp_status']==0) { ?>
            <span class="label-success label label-default">Active</span>
           <?php } ?>
        </td>
        <td class="center">
            
             <a class="btn btn-warning btn-sm" href="emp_leave.php?emp_id=<?php echo $employee['emp_id']; ?>">
               
                Leaves
            </a>
            
            
            <a class="btn btn-info btn-sm add_employee" href="add_employee.php?update=<?php echo $employee['emp_id']; ?>">
                
                Edit
            </a>
           
            <a class="btn btn-danger btn-sm" onclick="return confirmation();" href="emp_list.php?del=<?php echo $employee['emp_id']; ?>">
                
                Delete
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