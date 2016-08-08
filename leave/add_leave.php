<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Queries();
$objHoliday =new Holiday();
$objTransaction =new Transaction();
$total_days=$local_holiday=$final_days=0;

if(isset($_REQUEST['update_button']))  // update code
{
    if($_REQUEST['leave_duration_to'])
        {
        
        //print_r($_REQUEST);
        
        //exit;
        $date1 = new DateTime($_REQUEST['leave_duration_from']);
        $date2 = new DateTime($_REQUEST['leave_duration_to']);
        $date2 = $date2->modify( '+1 day' );
        //  $total_days = $date2->diff($date1)->format("%a");
        //exit;
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date1, $interval, $date2);
        foreach ( $period as $dt )
        {
            $day=$dt->format( "l" );
            $date=$dt->format( "d-m-Y" );
            $d = $dt->format( "d" );
            $m = $dt->format( "m" );
            if($day=='Saturday' || $day=='Sunday')
            {
                
            }
            else
            {
                if($_REQUEST['half_day'] == 0){
                    $total_days++;
                }else{
                    $total_days = $total_days + 0.5;
                }
            }   
            
            $holiday_list=array();
            $holiday_list=$objHoliday->GetAllHoliday(" month(`date`) = '".$m."' and day(`date`) = '".$d."'",array("*"));
            if($holiday_list)
            {
                $local_holiday++;
            }
        
        }
            //echo "Total :".$total_days."<br>";
            //echo "Local :".$local_holiday."<br>";        

            $final_days=$total_days-$local_holiday;
        

          
//////////////////////////////////////////////////////////////
           $submit=$obj->update("alpp_leave","leave_id=".$_REQUEST['leave_id'] ,array(
                                                 'leave_emp_id'     =>$_REQUEST['emp_id'],
                                                 'half_day'   =>   $_REQUEST['half_day'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$final_days,
                                                 'leave_duration_from'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_from'])),
                                                 'leave_duration_to'   =>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_to'])),
                                                 'leave_balance_type'   =>$_REQUEST['trans_type'],
                                                 'leave_approval'   =>$_REQUEST['approval'],
                                                 
                                                  ));
        if($_REQUEST['approval'] == 2){
            // its approved leave
            $submit=$obj->update("alpp_leave","leave_id=".$_REQUEST['leave_id'] ,array(
                'leave_datetime'   =>date('Y-m-d h:i:s'),
                'leave_user'       =>$_SESSION['session_admin_id']
            ));
        }
        if($submit){        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Leave Updated.";
        //    header('REFRESH:2, url='.SITE_ADDRESS.'leave/leave_list.php');
	}
        else        { 
            $message_type="alert-error"; 
            $message_text = "<strong>Error!</strong> Leave not Submitted ,Please try again.";
        }
}
}
 if(isset($_REQUEST['submit']))  /// insert code
{
    
        
    if($_SESSION['session_admin_role']=='admin') 
    {
        $approval=$_REQUEST['approval'];
        $employee=$_REQUEST['emp_id'];
    }
    else 
    {
        $approval=0;
        $employee=$_SESSION['session_admin_id'];
    }     
    
    if($_REQUEST['leave_duration_to']) ////////// number of days calculation just to save it in db       
    {
        $date1 = new DateTime($_REQUEST['leave_duration_from']);
        $date2 = new DateTime($_REQUEST['leave_duration_to']);
        $date2 = $date2->modify( '+1 day' );
        //echo  $total_days = $date2->diff($date1)->format("%a");

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date1, $interval, $date2);
        foreach ( $period as $dt )
        {
            $day=$dt->format( "l" );
            $date=$dt->format( "m/d/Y" );
            $d = $dt->format( "d" );
            $m = $dt->format( "m" );
            if($day=='Saturday' || $day=='Sunday')
            {
                
            }
            else
            {
                if($_REQUEST['half_day'] == 0){
                    $total_days++;
                }else{
                    $total_days = $total_days + 0.5;
                }
            }   
            
            $holiday_list=array();
            $holiday_list=$objHoliday->GetAllHoliday(" month(`date`) = '".$m."' and day(`date`) = '".$d."'",array("*"));
            if($holiday_list)
            {
                $local_holiday++;
            }
        
        }
            //echo "Total :".$total_days."<br>";
            //echo "Local :".$local_holiday."<br>";        

            $final_days=$total_days-$local_holiday;
    }
    // check if the employee has enough balance
    
    $insert_ok = 0;
    $insert_count_ok = 0;
    $max_day_count= 0;
   
    $balance_detail= $objTransaction->GetEmpBalanceDetail($employee);
    //print_r($balance_detail);
    $bI = $balance_detail['F']-$balance_detail['leavesI'];
    //echo "<br>";
    $bD = $balance_detail['D']-$balance_detail['leavesD'];

    if($_REQUEST['trans_type'] == 'F'){
         if($bI >= $final_days){
             $insert_ok =1;
         }else{
             $max_day_count = $bI;
         }
    }
    if($_REQUEST['trans_type'] == 'D' ){
         if($bD >= $final_days){
             $insert_ok =1;
         }else{
             $max_day_count = $bD;
         }
    }
//////////////////////////////////////////////////////////////
    if($insert_ok){
        $submit=$obj->insert("alpp_leave",array(
                                                 'leave_emp_id'     =>$employee,
                                                 'date'   =>   date("Y-m-d"),
                                                 'half_day'   =>   $_REQUEST['half_day'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$final_days,
                                                 'leave_duration_from'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_from'])),
                                                 'leave_duration_to'   =>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_to'])),
                                                 'leave_balance_type'   =>$_REQUEST['trans_type'],
                                                 'leave_approval'   =>$approval,
                                                 'leave_datetime'   =>date('Y-m-d h:i:s'),
                                                 'leave_user'       =>$_SESSION['session_admin_id']
                                                  
              ));
        
        // send the alert email to admin
        $objEmployee =new Employee();
        $emp_data = $objEmployee->GetAllEmployee("emp_id = ".$employee,array("*"));
        
        $objEmail = new Email();
        //$objEmail->To = 'mhmmd.nauman@gmail.com';
        $objEmail->To = 'fsf@indubal.com';
        
        $objEmail->From = "Admin <nauman@indubalfriction.com>";
        $objEmail->TextOnly = false;
        $objEmail->Subject="New Leave Request From ".$emp_data[0]['emp_name'];
        $Content .= "Hi,<br><br>You have new leave request from ".$emp_data[0]['emp_name'];
        $Content .="<br>Ficha: ".$emp_data[0]['emp_file'];
        $Content .="<br>From: ".date("d/m/Y",  strtotime($_REQUEST['leave_duration_from']));
        $Content .="<br>To: ".date("d/m/Y",  strtotime($_REQUEST['leave_duration_to']));
        $Content .="<br>Total Days: ".$final_days;
        $Content .="<br><br><br>Regards<br><br> Admin Team";
        $objEmail->Content = $Content;
        $objEmail->Send();    
        if($submit)
        {       
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Leave Application Submitted.";
        }
    }else{
        $message_type="alert-danger";
        if($max_day_count > 0){
            $message_text = "<strong>Error!</strong> Leave Application not Submitted ,You can only request $max_day_count day(s).";
        }else{
            $message_text = "<strong>Error!</strong> You are out of balance.";
        }
        
        }
    
}
      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) { $id = $_REQUEST['view']; $readonly="readonly"; }
        else  $id = $_REQUEST['update'];
    
        $leave_list=$obj->select("alpp_leave","leave_id=$id ",array("*")); 
        $leave_duration_to=date("d-m-Y",strtotime($leave_list[0]['leave_duration_to']));
        if(empty($leave_duration_to) || $leave_duration_to == "01-01-1970" ){
            $leave_duration_to = "";
        }
        $leave_duration_from=date("d-m-Y",strtotime($leave_list[0]['leave_duration_from']));
        if(empty($leave_duration_from) || $leave_duration_from == "01-01-1970" ){
            $leave_duration_from = "";
        }
}else{
    $leave_duration_to = date("d-m-Y");
    $leave_duration_from = date("d-m-Y");
}
?>

<div class="row">
    <div class="box col-md-6">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Ingresar solicitud individual</h2>
            </div>
            
<div class="box-content">
     <?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
    <?php if($message_type == "alert-success"){ ?>
        <script> window.parent.location.reload();</script>
    <?php }
    }?>

<form class="form-horizontal" role="form"  method="post" >
     
<?php   $employee_list=$obj->select("alpp_emp","1 order by emp_name ASC ",array("*"));    

if($_SESSION['session_admin_role']=='admin') 
{ ?>
    <div class="form-group">
                   <label class="control-label col-sm-2">Name</label>
                   <div class="col-sm-2">          
                       <input type="hidden" value="<?php echo $leave_list[0]['leave_id']; ?>"  name="leave_id">
                   <?php     if(isset($_REQUEST['emp_id']))  ///  ?? ?>
                       <select name="emp_id" class="form-control" <?php echo $readonly; ?>>
                           <?php 
                           foreach($employee_list as $employee)
                           {    
                                    if(isset($_REQUEST['emp_id']) && $_REQUEST['emp_id']==$employee['emp_id']) 
                                    {
                                        echo "<option value=".$employee['emp_id']." selected>".$employee['emp_name']."</option>";
                                    }   
                                    else{
                                            $sel=   ($employee['emp_id']==$leave_list[0]['leave_emp_id']) ? 'selected' : '' ;
                                           echo "<option value=".$employee['emp_id']." $sel>".$employee['emp_name']."</option>";
                                       }
                           }
                           ?>
                       </select>
                   </div>
    </div>
<?php } ?>                 
       
    <div class="form-group">                    
        <label class="control-label col-sm-2">1/2 Día</label>                     
        <div class="col-sm-2">
            <select name="half_day" class="form-control" >
                <option value="0" <?php if($leave_list[0]['half_day']==0)echo"selected";?>>No</option>
                <option value="1" <?php if($leave_list[0]['half_day']==1)echo"selected";?>>Yes</option>
            </select>
        </div>
    </div>
    <div class="form-group">                    
        <label class="control-label col-sm-2">Fecha de Inicio</label>                     
        <div class="col-sm-2">
            <input type="text" id="leave_duration_from" required="" class="form-control col-sm-2"  <?php //echo $readonly; ?> value="<?php echo $leave_duration_from; ?>"  name="leave_duration_from">
        </div>
    </div>

    <div class="form-group">                    
        <label class="control-label col-sm-2">Fecha de Término</label>                     
        <div class="col-sm-2">
            <input type="text" id="leave_duration_to"  required="" class="form-control col-sm-2" <?php echo $readonly; ?> value="<?php echo $leave_duration_to; ?>"  name="leave_duration_to">
        </div>
    </div>
      <div class="form-group">
              <label class="control-label col-sm-2">Tipo</label>
              <div class="col-sm-4">
                  <select name="trans_type" class="form-control" >
<!--                      <option value="M" <?php //if($transaction[0]['trans_type']=='M')echo"selected";?>>Manual</option>
                      <option value="C" <?php //if($transaction[0]['trans_type']=='C')echo"selected";?>>Auto System Added</option>-->
                      <option value="D" <?php if($leave_list[0]['leave_balance_type']=='D')echo"selected";?>>DIAS PROGRESIVOS</option>
                      <option value="F" <?php if($leave_list[0]['leave_balance_type']=='F')echo"selected";?>>FERIADO LEGAL</option>
                      
                  </select>
              </div>
         </div>                         
<?php  if($_SESSION['session_admin_role']=='admin') {  ?>
    <div class="form-group">
        <label class="control-label col-sm-2">Approval</label>
        <div class="col-sm-2">          
        <select name="approval" class="form-control" <?php echo $readonly; ?>>
        <?php $leave_array=array("2"=>"Approved","0"=>"Pending","1"=>"Cancelled"); ?>
            <option value="">SELECT</option>
           <?php 
                foreach($leave_array as $status=>$value)
                {    $sel=   ($status==$leave_list[0]['leave_approval']) ? 'selected' : '' ;
                      echo "<option value=".$status." $sel>".$value."</option>";
                }
                ?>
        </select>
        </div>
    </div>
    <?php } ?>
              
    <div class="form-group">
        <label class="control-label col-sm-2">Observación</label>                     
            <div class="col-sm-4">
                <textarea  class="form-control" name="reason" <?php echo $readonly; ?>  placeholder="Observación"><?php echo $leave_list[0]['leave_reason']; ?></textarea>
            </div>
    </div>

<?php 
if(isset($_REQUEST['view']))            {  }  
else if(isset($_REQUEST['update']))	{  ?>
    <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-4">
            <button type="submit" name="update_button" class="btn btn-small btn-block btn-error">Guardar</button>
         </div>
    </div>  
<?php } else {     ?>         
    <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-4">
            <button type="submit" name="submit" class="btn btn-block btn-info">Guardar</button>
         </div>
    </div>  
<?php }?>
      
                    <br>
                </form>
            </div>
        </div>
    </div>
</div><!--/row-->

<?php include('../lib/modal_footer.php'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  //$( "#leave_duration_from" ).datepicker();
  $( "#leave_duration_from" ).datepicker({
        dateFormat: "dd-mm-yy",
        beforeShowDay: $.datepicker.noWeekends
    });
    //var dateFormat = $( "#leave_duration_from" ).datepicker( "option", "dateFormat" );
    //alert(dateFormat);
  $( "#leave_duration_to" ).datepicker({
        dateFormat: "dd-mm-yy",
        beforeShowDay: $.datepicker.noWeekends
    });
});

</script>
<!--
ALTER TABLE `alpp_leave` ADD `half_day` TINYINT(1) NOT NULL DEFAULT '0' ;
-->