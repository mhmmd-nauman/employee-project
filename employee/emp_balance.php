<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_REQUEST['emp_id']."");
// need bit of manaul sorting of data for now
foreach($trasanction_list as $trasanction) { 
    $trasanction_list_temp[$trasanction['id']] = $trasanction;
}
ksort($trasanction_list_temp);
$trasanction_list_temp = array_reverse($trasanction_list_temp);

$trasanction_list = $trasanction_list_temp;
$balance=0.00;
$balance = $objTransaction->GetEmpBalance($_REQUEST['emp_id']);
$balance_detail= $objTransaction->GetEmpBalanceDetail($_REQUEST['emp_id']);
$emp_data = $objEmployee->GetAllEmployee("emp_id = ".$_REQUEST['emp_id'],array("*"));
//print_r($balance_detail);
if(isset($_REQUEST['del']))	
{	
        $id = $_REQUEST['del'];
	$del = $objTransaction->DeleteTransantion($id);
	
        if($del)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Transaction Deleted.";
            header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance.php?emp_id='.$_REQUEST['emp_id']);
	}
}
?>


<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php }?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i><?php echo $emp_data[0]['emp_name'];?>  - Modificar saldos</h2>
            </div>
            
            <div class="col-md-7">
                <br>
                 <table class="table table-striped table-bordered" >
                        <tr>
                            <th>Feriado Legal</th><td style=" background-color: #FFFFFF"><?php echo $balance_detail['F']-$balance_detail['leavesI'];?></th>
                            <th>Dias Progresivos</th><td style=" background-color: #FFFFFF"><?php echo $balance_detail['D']-$balance_detail['leavesD'];?></th>
                        </tr>
                </table>   
            </div>
        
          <?php if($_SESSION['session_admin_role']=='admin') { ?>
            <div class="col-md-4">
                <br>
                <p style="text-align: right;">
                <a class="btn add_balance btn-success btn-sm " href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php?emp_id=<?php echo $_REQUEST['emp_id']?>"><i class="glyphicon icon-white"></i>Añadir Manual de Balanza</a>
                <a class="btn btn-success btn-sm" href="emp_list.php">Ver empleados</a>
                </p><br>
            </div>
          <?php } ?>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">            
<div class="box-content">
   <br>
   <table class="table table-striped table-bordered   responsive" style=" font-size: 12px;" >
    <thead>
    <tr>
<!--        <th>ID</th>-->
        <th style=" width: 10%;">Date</th>
      
        
        <th>Reason</th>
      
<!--        <th>Data Added</th>-->
        <th>Days</th>
        <th>Status</th>
<?php if($_SESSION['session_admin_role']=='admin') { ?>
        <th style=" width: 10%;">Actions</th>
<?php } ?>   
    </tr>
    </thead>
    <tbody>
        <?php foreach($trasanction_list as $trasanction) {   ?>
        
    <tr>
<!--        <td><?php //echo $trasanction['id']; ?></td>-->
        <td><?php echo date("d-m-Y",strtotime($trasanction['entered_on_date'])); ?></td>
        
            <?php
            switch($trasanction['trans_type']) {
                case"M":
                    echo "<td>Manual</td>";
                    break;
                case"C":
                    echo "<td>Auto System Added</td>";
                    break;
                case"F":
                    echo "<td>FERIADO LEGAL</td>";
                    break;
                case"D":
                    echo "<td>DIAS PROGRESIVOS</td>";
                    break;
                case"L":
                    echo "<td>Leave -  (";
                    if($trasanction['leave_type']=='D') echo "DIAS PROGRESIVOS";
                        else if($trasanction['leave_type']=='F') echo "FERIADO LEGAL";
                        else echo "";
                  
                        echo")</td>";
                    break;
            }?></td>
<!--        <td><?php //echo date("m/d/Y",strtotime($trasanction['entry_date'])); ?></td>-->
        <td><?php echo $trasanction['days']; ?></td>
        <td class="center">
           <?php if($trasanction['status']==0 && $trasanction['trans_type'] !='L') { ?>
            <span class="label-success label label-default">Active</span>
           <?php } 
            if($trasanction['status']==0 && $trasanction['trans_type'] =='L')       echo"<span class='label label-danger'>Pending</span>";
            else if($trasanction['status']==2 && $trasanction['trans_type'] =='L')	echo"<span class='label label-success'>Approved</span>";
            else if($trasanction['status']==1 && $trasanction['trans_type'] =='L')  echo"<span class='label label-small label-danger'>Cancelled </span>";
        ?>
        </td>
        <?php if($_SESSION['session_admin_role']=='admin') { ?>    
        <td class="center">
            <?php if($trasanction['trans_type'] !="L"){?>
            <a class="btn add_balance btn-info btn-sm" href="add_balance.php?update=<?php echo $trasanction['id']; ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
            </a>
            <a onclick="return confirmation();" class="btn btn-danger btn-sm" href="emp_balance.php?del=<?php echo $trasanction['id']; ?>&emp_id=<?php echo $trasanction['emp_id']; ?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
            </a>
            <?php }?>
        </td>
        <?php }?>    </tr>
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
$(".add_balance").colorbox({iframe:true, width:"50%", height:"90%"});
</script>
