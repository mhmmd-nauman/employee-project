<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$objEmployee =new Employee();

$leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id ","leave_emp_id=".$_REQUEST['emp_id']." order by leave_id desc",array("*"));
$emp_data = $objEmployee->GetAllEmployee("emp_id = ".$_REQUEST['emp_id'],array("*"));

if(isset($_REQUEST['leave_id']) && isset($_REQUEST['status']))	
{	           
    if($_REQUEST['status']==1 || $_REQUEST['status']==2) { // cancel | Approve
                $action=$obj->Update("alpp_leave",'leave_id='.$_REQUEST['leave_id'] , array('leave_approval'=>$_REQUEST['status']));
    } 
    else if($_REQUEST['status']==3) { // delete
        $action = $obj->Delete("alpp_leave",'leave_id='.$_REQUEST['leave_id']);
    }
    if(isset($action) )
             {		 ?>
             <div class="widget-body">
                    <div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> <?php echo ($_REQUEST['status']==3) ? 'Record Deleted' : 'Record Updated' ;?>
                    </div>
             </div>
             <?php
                    header('refresh:1, url=emp_list.php?emp_id='.$_REQUEST['emp_id']);
            }
}
// delete  a record
if(isset($_REQUEST['del']))	
{	

        $id = $_REQUEST['del'];
	$del = $obj->Delete("alpp_leave",'leave_id='.$id);
	 
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
		header('refresh:1, url=leave_list.php');
	}
}
?>
<script>
    $(document).ready(function(){
            $(".add_leave").colorbox({iframe:true, width:"50%", height:"80%"});
    });
</script>
<script>
function action(status,leave_id,emp_id){
        
        if(status==1){                
                                var answer = confirm ("Are you sure want to cancel Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=1&emp_id="+emp_id;
                            }        
   else if(status==2){                
                               var answer = confirm ("Are you sure want to Approve Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=2&emp_id="+emp_id;
                            }        
    else if(status==3) {                
                                var answer = confirm ("Are you sure want to Delete Leave?");
                                if (answer)   window.location="?leave_id="+leave_id+"&status=3&emp_id="+emp_id;
                              }        
    }
</script>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>Ingresar solicitud individual </h2>
            </div>
            

            <div class="box-content">
            
                <h5>Empleado: <?php echo $emp_data[0]['emp_name'];?></h5> 
                
                <p style="text-align: right;">
                    <a class="add_leave" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?emp_id=<?php echo $_REQUEST['emp_id']; ?>"><button class="btn btn-warning"> <i class="glyphicon glyphicon-star icon-white"></i>Ingresar solicitud individual</button></a> 
                    <a class="btn btn-success" href="emp_list.php">Ver empleados</a>
                </p>                
                <table class="table table-striped table-bordered bootstrap-datatable  responsive" id="" style="font-size: 12px;">
    <thead>
    <tr>
       <th>N° de Días</th>
        <th width="10%">Desde<br>Hasta</th>
        <th >Observación</th>
        <th>Tipo</th>
        <th>Estatus</th>
        <th width="13%">Acciones</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($leave_list as $leave) {   ?>
        
    <tr>
        <td><?php echo $leave['leave_duration']; ?></td>
        <td>
        <?php   $from=$to='';
                    if($leave['leave_duration_from'])
                    {
                               $from = new DateTime($leave['leave_duration_from']);
                               echo  $from = $from->format("d-m-Y");

                            if($leave['leave_duration_to'])
                            {
                                        echo "  <br>  "; 
                                        $to = new DateTime($leave['leave_duration_to']);
                                       echo $to = $to->format("d-m-Y");
                            }
                    }
        ?>
        
        
        </td>
        <td><?php echo $leave['leave_reason']; ?></td>
        
         <td><?php if($leave['leave_balance_type']=='D') echo "DIAS PROGRESIVOS";
                        else if($leave['leave_balance_type']=='F') echo "FERIADO LEGAL";
                        else echo "";
                  ?>
        </td>
       
        
        			
<?php	if($leave['leave_approval']==0)       echo"<td class='hidden-phone '><span class='label label-danger'>Pendiente</span></td>";
	else if($leave['leave_approval']==2)	echo"<td class='hidden-phone '><span class='label label-success'>Aprobado</span></td>";
	else if($leave['leave_approval']==1)  echo"<td class='hidden-phone '><span class='label label-small label-danger'>Cancelado </span></td>";

        
      ?>
        <td>
            
            
 <?php if($_SESSION['session_admin_role']=='admin') { ?> 
                           <div class="btn-group">
                                    <button class="btn btn-success btn-sm">Acciones</button>
                                    <button data-toggle="dropdown" class="btn btn-success dropdown-toggle b2 btn-sm"><span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:;" onclick="return action('2','<?php  echo $leave['leave_id']; ?>','<?php  echo $leave['leave_emp_id']; ?>');"><i class="glyphicon glyphicon-ok"></i> Aprobado</a></li>
                                        <li><a href="javascript:;" onclick="return action('1','<?php  echo $leave['leave_id']; ?>','<?php  echo $leave['leave_emp_id']; ?>');"><i class="glyphicon glyphicon-remove"></i> Cancelado</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a class="add_leave" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?update=<?php echo $leave['leave_id']; ?>">
                                                <i class="glyphicon glyphicon-edit"></i>&nbsp;Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="return confirmation();" class="" href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php?del=<?php echo $leave['leave_id']; ?>">
                                                <i class="glyphicon glyphicon-trash"></i>&nbsp;Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
       <?php } ?>
            

            
            
        </td>
    </tr>
        <?php } ?>
    
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