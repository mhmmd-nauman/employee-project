<?php 
header('Content-Type: text/html; charset=utf-8');
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$obj=new Queries();
if($_REQUEST['viewworkers'] == 1){
   $id = $_REQUEST['emp_id'];
   if($id){
        $str = " and emp_supervisor = $id";
        $supervisor_data=$obj->select("alpp_emp","emp_id = $id",array("*"));
        $title_supervisor = " - Supervisor/Jefe - ".$supervisor_data[0]['emp_name'];
   }
}
$employee_list=$obj->select("alpp_emp","emp_status = 0 and  emp_type <> 4 $str order by emp_name",array("*"));
?>
<script>
    $(document).ready(function(){
        $(".add_employee").colorbox({iframe:true, width:"70%", height:"80%"});
        $(".add_monthly").colorbox({iframe:true, width:"70%", height:"80%"});
        $(".add_employee_notes").colorbox({iframe:true, width:"80%", height:"90%"});

    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner ">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>  Ver empleados <?php echo $title_supervisor;?> </h2>
            </div>
           <div class="box-content">
            <?php 
            
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
               <table id="data_list" class="table table-striped table-bordered dataTable   responsive" style=" font-size: 12px;">
  
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nombre<br>Supervisor/Jefe</th>
                    <th>Departamento</th>
                    <th>Rut</th>
                    <th>Saldo actual</th>
                    <th>FERIADO LEGAL</th>
                    <th>DIAS PROGRESIVOS</th>
                    <th width="13%">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($employee_list as $employee) {
                
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." ");
            $balance=($balance_detail['F']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);
            $supervisor_data=$obj->select("alpp_emp","emp_id = ".$employee['emp_supervisor'],array("*"));
            ?>
        
            <tr>
                <td>
                    <?php echo $employee['emp_file']; ?>
                </td>
                <td><?php echo $employee['emp_name']; ?><br><span style="font-size: 10px;"><?php echo $supervisor_data[0]['emp_file'].'-'.$supervisor_data[0]['emp_name'];?></span></td>
                <td><?php echo $employee['emp_department']; ?></td>
                <td><?php echo $employee['emp_cellnum']; ?></td>

                <td><?php  echo number_format($balance, 2); ?>
                </td>
                <td><?php   echo number_format(($balance_detail['F']-$balance_detail['leavesI']), 2);?></td>
                <td><?php   echo number_format(($balance_detail['D']-$balance_detail['leavesD']), 2);?></td>

                <td class="center">
                    <div class="btn-group">
                        <button class="btn btn-success btn-sm">Acciones</button>
                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle b2 btn-sm"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php if($_SESSION['session_admin_role'] == 'admin'){?>
                            <li>
                                <a class="  " href="emp_balance.php?emp_id=<?php echo $employee['emp_id']; ?>"><span class="glyphicon glyphicon-file"></span> Modificar saldos</a>
                            </li>
                            <?php }?>
                            <li>
                                <a class=" " href="emp_leave.php?emp_id=<?php echo $employee['emp_id']; ?>" title="Ingresar solicitud individual"><span class="glyphicon glyphicon-file"></span> Solicitud</a>
                            </li>
                             <li role="separator" class="divider"></li>
                            <?php 
                            if($_SESSION['session_admin_role'] == 'admin'){
                                if($employee['emp_status']==0) { ?>
                                    <li>    
                                        <a class=""><i title="Status" class="glyphicon glyphicon-ok icon-ok"></i> Estatus</a>
                                    </li>
                                       <?php } else{ ?>
                                    <li> 
                                          <a class=""><i title="Status" class="glyphicon glyphicon-remove"></i> Status</a>
                                    </li>
                                <?php } 
                            }
                            ?>
                            <li>
                                <a title="Manage Notes" class=" add_employee_notes" href="add_employee_notes.php?emp_id=<?php echo $employee['emp_id']; ?>"><span class="glyphicon glyphicon-file"></span> Notes</a>
                            </li>
                            <?php if( $_SESSION['session_admin_role'] == 'admin' ){?>  
                            <li>
                                <a class=" add_employee" href="add_employee.php?update=<?php echo $employee['emp_id']; ?>">
                                   <i class="glyphicon glyphicon-edit"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="" onclick="return confirmation();" href="emp_list.php?del=<?php echo $employee['emp_id']; ?>">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </a>
                            </li>
                        <?php }?>
                        </ul>
                    </div>
                    
                    
                
                </td>
                
            </tr>
            <?php 
            $balance = 0;
           } ?>
    
    </tbody>
    </table>
               <br><br>
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

