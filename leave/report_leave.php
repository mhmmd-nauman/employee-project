<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$where='1';  
if($_REQUEST['emp_id'] > 0 ){
    $employee_data=$obj->select("alpp_emp","emp_id = ".$_REQUEST['emp_id'],array("*"));
    //print_r($employee_data);
}
if(isset($_REQUEST['view']) )	// code to edit status only 
{	           
    $leave_data=$obj->select("alpp_leave","leave_id = ".$_REQUEST['view'],array("*"));
    //print_r($leave_data);
    if($action) {        
        $message_type="alert-success"; 
        $msg=($_REQUEST['status']==3)? 'Deleted' : ($_REQUEST['status']==1)?  'Cancelled' : 'Approved';  
        $message_text = "<strong>Success!</strong> Leave Record ". $msg ;
    }
}

//print_r($_SESSION);
?>  
<script>
function action(action_status,id){
        
        if(action_status==1){                
                                var answer = confirm ("Are you sure want to cancel Leave?");
                                if (answer)   window.location="?leave_id="+id+"&status=1";
                            }        
   else if(action_status==2){                
                                var answer = confirm ("Are you sure want to Approve Leave?");
                                if (answer)   window.location="?leave_id="+id+"&status=2";
                            }        
    else if(action_status==3) {                
                                var answer = confirm ("Are you sure want to Delete Leave?");
                                if (answer)   window.location="?leave_id="+id+"&status=3";
                              }        
    }
    $(document).ready(function(){
            $(".add_leave").colorbox({iframe:true, width:"40%", height:"90%"});
            $(".status_leave").colorbox({iframe:true, width:"40%", height:"50%"});
    });
</script>
 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php 
      header('REFRESH:2, url='.SITE_ADDRESS.'leave/leave_list.php');
}?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Solicitud De Permiso</h2>
            </div>
            <div class="box-content">
                <div class="row">&nbsp;</div>
                <div class="row">
                    <div class="col-md-3 rep_background">
                        De Ficha
                    </div>
                    <div class="col-md-5 rep_background">
                        Nombre Del Trabajador
                    </div>
                    <div class="col-md-3 rep_background">
                        Seccion
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 cel_data">
                        <?php echo $employee_data[0]['emp_file'];?>
                    </div>
                    <div class="col-md-5 cel_data">
                       <?php echo $employee_data[0]['emp_name'];?>
                    </div>
                    <div class="col-md-3 cel_data">
                        <?php echo $employee_data[0]['emp_department'];?> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 rep_background">
                        Supervisor:
                    </div>
                    <div class="col-md-3 rep_background">
                        Fecha Del Registro
                    </div>
                    <div class="col-md-1 rep_background">
                        Hora
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 cel_data">
                        <?php echo $_SESSION['session_admin_name'];?>
                    </div>
                    <div class="col-md-3 cel_data">
                         <?php echo date("m/d/Y"); ?>
                    </div>
                    <div class="col-md-1 cel_data">
                         <?php echo date("h:i"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 ">
                        <div class="row">
                            <div class="col-md-12 rep_background">
                                Motivo Del Permiso
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 cel_data big_cel_data">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 " style="margin-right:7px;">
                        <div class="row">
                            <div class="col-md-12 rep_background">
                                Periodo Del Permiso
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 rep_background">
                                Des Sde
                            </div>
                            <div class="col-md-5 rep_background">
                                Hasta
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 cel_data">
                                <?php echo date("m/d/Y", strtotime($leave_data[0]['leave_duration_from'])); ?> 
                            </div>
                            <div class="col-md-5 cel_data">
                                <?php echo date("m/d/Y", strtotime($leave_data[0]['leave_duration_to'])); ?> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3  ">
                        <div class="row">
                            <div class="col-md-7 rep_background">
                                Horas
                            </div>
                            <div class="col-md-4 rep_background">
                               USO RRHH
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-7" >
                                <div class="row">
                                    <div class="col-md-5 rep_background">
                                        DSDE
                                    </div>
                                    <div class="col-md-5 rep_background">
                                        HASTA
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4 rep_background" style="margin-left:15px;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-7" >
                                <div class="row">
                                    <div class="col-md-5 cel_data">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-5 cel_data">
                                        &nbsp;
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4 rep_background" style="margin-left:15px;">
                                &nbsp;
                            </div>
                        </div>
                </div>
               </div>
            <div class="row">
                <div class="col-md-11 rep_background">
                    Observaciones
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-11 cel_data big_cel_data">
                    <?php echo $leave_data[0]['leave_reason'];?>
                </div>
                
            </div>
            <div class="row">
                &nbsp;
            </div>
              <div class="row">
                <div class="col-md-3 cel_data big_cel_data">
                    <b><?php echo $employee_data[0]['emp_name'];?></b><br>
                    Trabajador
                </div>
                <div class="col-md-5 cel_data big_cel_data">
                    <b><?php echo $_SESSION['session_admin_name'];?></b><br>
                    Supervisor/Jefe Directo
                </div>
                <div class="col-md-3 cel_data big_cel_data">
                    <br><br>
                    Recursos Humanos
                </div>
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
<style type="text/css">
.rep_background{ background-color: #D4D4D4;
 outline: 1px solid black;
 padding: 3px;
 font-size: 11px;
 margin: 5px;
 font-weight: bold;
}
.row_data{
   margin-top: 7px;
   margin-bottom: 7px;
}
.cel_data{
     outline: 1px solid black;
     padding: 3px;
     margin: 1px 5px 1px 5px;
     text-align:   center;
  
}
.big_cel_data{
    height: 60px;
}
.row{
    padding-left: 5px;
}
</style>