<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
?>
<script>
    $(document).ready(function(){
        $(".add_employee").colorbox({iframe:true, width:"70%", height:"80%"});
        $(".add_monthly").colorbox({iframe:true, width:"70%", height:"80%"});
        $(".add_employee_notes").colorbox({iframe:true, width:"70%", height:"80%"});

    });
</script>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Employee</h2>
            </div>
           <div class="box-content">
            <?php 
            $obj=new Queries();
            $employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));
            if(isset($_REQUEST['emp_id']) && isset($_REQUEST['type']))	
            {	
                    $id = $_REQUEST['emp_id'];
                    $change = $obj->update("alpp_emp",'emp_id='.$id,array('emp_type'  =>  $_REQUEST['type'])); 
                    if($change)
                    { ?>
                        <div class="widget-body">
                            <div class="alert alert-success">
                               <button class="close" data-dismiss="alert">×</button>
                               <strong>Success!</strong> Access Changed.
                            </div>
                        </div>
                    <?php header('refresh:1, url=emp_list.php');
                    }
            } 	 
            if(isset($_REQUEST['del']))	
            {	
                    $id = $_REQUEST['del'];
                    $del = $obj->Delete("alpp_emp",'emp_id='.$id); 
                    if($del)
                    { ?>
                        <div class="widget-body">
                            <div class="alert alert-success">
                               <button class="close" data-dismiss="alert">×</button>
                               <strong>Success!</strong> Record Deleted.
                            </div>
                        </div>
                    <?php header('refresh:1, url=emp_list.php');
                    }
            }
            ?>
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
                    <th>Type</th>
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
        <td><?php echo $employee['emp_cellnum'];
                    
                    /*
                    $submit=$obj->update("alpp_emp","emp_id=".$employee['emp_id'],array(
                            'emp_cellnum'         =>$str));
                     * 
                     */
        
        ?></td>
        <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php   $balance = $objTransaction->GetEmpBalance($employee['emp_id']); 
        echo number_format($balance, 2);
        ?></td>
<!--        <td>
            <a class="btn btn-success btn-sm" href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>">
            <?php //echo $balance; ?>
            </a>
            </td>-->
        <td class="center" style="text-align: center;">
           <?php if($employee['emp_status']==0) { ?>
            <span title="Status" class="glyphicon glyphicon-ok"></span>
           <?php } else{ ?>
             <span title="Status" class="glyphicon glyphicon-remove"></span>
           <?php } ?>&nbsp;<a title="Manage Notes" class=" add_employee_notes" href="add_employee_notes.php?emp_id=<?php echo $employee['emp_id']; ?>"><span class="glyphicon glyphicon-file"></span>
            </a>
        </td>
        <td>
            <div class="btn-group">
                
                    <?php if($employee['emp_type']==0) { ?>
                <a href="javascript:;" onclick="return action('0','<?php  echo $employee['emp_id']; ?>');"><span  class="label label-success">Employee<span class="caret"></span><a>
                       
                      <?php }else{ ?>
                <a href="javascript:;" onclick="return action('1','<?php  echo $employee['emp_id']; ?>');"><span class="label label-danger">Admin<span class="caret"></span><a>
                    <?php } ?>
              
            </div>   
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
    function action(str,id) {
        if(str==0)// employee
        {
            var answer = confirm("Are you sure you want to change it to Admin ?");
            if (answer)   window.location="?emp_id="+id+"&type=1";
            else   return false;
        }
        else
        {
            var answer = confirm("Are you sure you want to change it to Employee ?");
            if (answer)   window.location="?emp_id="+id+"&type=0";
            else   return false;
        }
            
    
}
</script>