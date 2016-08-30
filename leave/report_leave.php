<?php 
include (dirname(__FILE__).'/../lib/include.php');
include('../lib/modal_header.php'); 
$obj=new Queries();
$objTransaction =new Transaction();
$where='1';  
if($_REQUEST['emp_id'] > 0 ){
    $employee_data=$obj->select("alpp_emp","emp_id = ".$_REQUEST['emp_id'],array("*"));
    //print_r($employee_data);
}


	           
$leave_data=$obj->select("alpp_leave","leave_id = ".$_REQUEST['view'],array("*"));
//echo "<pre>";
//print_r($leave_data);
//echo "</pre>";
$date=date('Y-m-d',strtotime($leave_data[0]['leave_datetime']));
//echo "<pre>";
$balance_detail= $objTransaction->GetEmpBalanceDetail($_REQUEST['emp_id'] . " and date <= '".$date." 12:60:60' ",$_REQUEST['view']);
//print_r($balance_detail);
//echo "</pre>";

$approver_data=$obj->select("alpp_emp","emp_id = '".trim($leave_data[0]['leave_user'])."' or emp_email = '".trim($leave_data[0]['leave_user'])."'",array("*"));
//print_r($approver_data);
    


//balance calculations
switch($leave_data[0]['leave_balance_type']){
    case"D":
        $balance_before_leave = $balance_detail['D']-$balance_detail['leavesD'];
        break;
    case"F":
        $balance_before_leave = $balance_detail['F']-$balance_detail['leavesI'];
        break;
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
<script>
function PrintWindow() {
    window.print();
}
</script>
<!-- start of first copy -->

<div class="row">
    
    <div class="col-md-12 pull-right">
         <button type="button" onclick="PrintWindow()" name="search" class="btn btn-small btn-success pull-right"><i title="Report" class="glyphicon glyphicon-print icon-white"> Print</i></button>
     </div>
</div>
<?php
   include('report_leave_inner.php'); ?>
<div class="row" style="border-bottom: 1px dotted black;">
    &nbsp;
</div>
<div class="row">
    &nbsp;
</div>
<?php
   include('report_leave_inner.php'); 
?>
    <!--/row-->
<!-- end of first copy -->

<?php //include('../lib/footer.php'); ?>
<style type="text/css">
.rep_background{
 
 border-bottom: 1px solid black;
 padding: 5px;
 font-size: 11px;
 margin: 5px;
 font-weight: bold;
}
.row_data{
   margin-top: 7px;
   margin-bottom: 7px;
}
.cel_data{
     border-top: 1px solid black;
     padding: 3px;
     margin: 1px 5px 1px 5px;
     text-align:   center;
  
}
.big_cel_data{
    height: 50px;
}
.row{
    padding-left: 15px;
    
}
</style>