<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
//ALTER TABLE `alpp_leave` ADD `date` DATE NULL AFTER `leave_emp_id`;
$obj=new Queries();
$where='1';  
if($_SESSION['session_admin_role']=='employee')    $where='leave_emp_id='.$_SESSION['session_admin_id'];
$leave_list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id "," $where order by date desc",array("*")); ?>

<?php
if(isset($_REQUEST['leave_id']) && isset($_REQUEST['status']))	// code to edit status only 
{	           
    if($_REQUEST['status']==1 || $_REQUEST['status']==2)  {  // cancel | Approve
        $action=$obj->Update("alpp_leave",'leave_id='.$_REQUEST['leave_id'] , array('leave_approval'=>$_REQUEST['status']));
    } 
    else if($_REQUEST['status']==3) { // delete
        $action = $obj->Delete("alpp_leave",'leave_id='.$_REQUEST['leave_id']);
    }
    if($action) {        
        $message_type="alert-success"; 
        $msg=($_REQUEST['status']==3)? 'Deleted' : ($_REQUEST['status']==1)?  'Cancelled' : 'Approved';  
        $message_text = "<strong>Success!</strong> Leave Record ". $msg ;
    }
}

if(isset($_REQUEST['del']))	// delete  a record
{	
    $id = $_REQUEST['del'];
    $del = $obj->Delete("alpp_leave",'leave_id='.$id);
    if($del)
    {        
        $message_type="alert-success"; 
        $message_text = "<strong>Success!</strong> Leave Record Deleted.";
    }
}
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
        
            $(".report_leave").colorbox({iframe:true, width:"90%", height:"95%"});
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
                <h2><i class="glyphicon glyphicon-star-empty"></i> Deja Aplicaciones</h2>
            </div>
            

<div class="box-content">
    <table class="table table-striped table-bordered datatable   responsive" id="leave_list" style=" font-size: 12px; padding-bottom: 0px;">
    <thead>
    <tr>
        <th style=" width: 8%;">Req. Date</th>
        <th style=" width: 10%;">Nombre</th>
        <th style=" width: 2%;">Days</th>
        <th style=" width: 8%;">From<br>To</th>
        <th style=" width: 20%;">Reason</th>
        <th style=" width: 10%;">Type</th>
        <th style=" width: 12%;">Status</th>
        <?php   if($_SESSION['session_admin_role']=='admin' || $_SESSION['session_admin_role']=='supervisor') { ?><th style=" width: 13%;">Actions</th><?php } ?>
    </tr>
    </thead>
    <tbody>
        <?php 
        $i=0;
        foreach($leave_list as $leave) { $i++;      ?>
        
    <tr>
        <td><?php echo date("d-m-Y",strtotime($leave['date'])); ?></td>
             <td><?php echo $leave['emp_file']; ?><br>
                 <?php echo $leave['emp_name']; ?></td>
        <td><?php echo $leave['leave_duration']; ?></td>
        <td>
        <?php   $from=$to='';
                    if($leave['leave_duration_from'])
                    {
                               $from = new DateTime($leave['leave_duration_from']);
                               echo  $from = $from->format("d-m-Y");

                            if($leave['leave_duration_to'])
                            {
                                        echo "<br>"; 
                                        $to = new DateTime($leave['leave_duration_to']);
                                       echo $to = $to->format("d-m-Y");
                            }
                    }
        ?>
        
        
        </td>
       <td><?php echo $leave['leave_reason']; ?></td>
        <td><?php if($leave['leave_balance_type']=='D') echo "DIAS PROGRESIVOS";
                  else if($leave['leave_balance_type']=='I') echo "FERIADO LEGAL";
                  else echo "";
            ?>
        </td>
       <?php if($_SESSION['session_admin_role']=='admin' || $_SESSION['session_admin_role']=='supervisor' ) {?>
        <td>
        <div class="btn-group">
            <?php switch ($leave['leave_approval']){
                case 0:?>
                    <button class="btn btn-danger btn-sm">Pending</button>
                    <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle b2 btn-sm"><span class="caret"></span></button>
            <?php  break;
                case 1:?>
                    <button class="btn btn-danger btn-sm">Cancel</button>
                    <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle b2 btn-sm"><span class="caret"></span></button>
            <?php break;
                case 2:?>
                    <button class="btn btn-success btn-sm">Approved</button>
                    <button data-toggle="dropdown" class="btn btn-success dropdown-toggle b2 btn-sm"><span class="caret"></span></button>
            <?php break;
            }?>
            <ul class="dropdown-menu">
                <li><a class="status_leave" href="edit_status.php?id=<?php echo $leave['leave_id']; ?>&status=2"><i class="icon-ok"></i> Approve</a></li>
                <li><a class="status_leave" href="edit_status.php?id=<?php echo $leave['leave_id']; ?>&status=1"><i class="icon-minus"></i> Cancel</a></li>
                <li><a href="javascript:;" onclick="return action('3','<?php  echo $leave['leave_id']; ?>');"><i class="icon-remove"></i>Delete</a></li>
            </ul>
        </div>
        </td>
       <?php }else{?>			
<?php	if($leave['leave_approval']==0)       echo"<td class='hidden-phone '><span class='label label-danger'>Pending</span></td>";
	else if($leave['leave_approval']==2)	echo"<td class='hidden-phone '><span class='label label-success'>Approved</span></td>";
	else if($leave['leave_approval']==1)  echo"<td class='hidden-phone '><span class='label label-small label-danger'>Cancelled </span></td>";

       }
      
        if($_SESSION['session_admin_role']=='admin' || $_SESSION['session_admin_role']=='supervisor') { ?> 
        <td>
            
            
                           
      
            <?php if($leave['leave_approval']==2){ ?>
            <a class="btn btn-success report_leave btn-sm" href="<?php echo SITE_ADDRESS; ?>leave/report_leave.php?view=<?php echo $leave['leave_id']; ?>&emp_id=<?php echo $leave['leave_emp_id']; ?>">
                <i title="Report" class="glyphicon glyphicon-print icon-white"></i>
            </a>
            <?php } ?>
            <a class="btn btn-info add_leave btn-sm" href="<?php echo SITE_ADDRESS; ?>leave/add_leave.php?update=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
               
            </a>
            <a onclick="return confirmation();" class="btn btn-danger btn-sm" href="<?php echo SITE_ADDRESS; ?>leave/leave_list.php?del=<?php echo $leave['leave_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
           
            </a>
        </td>
         <?php } ?>
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