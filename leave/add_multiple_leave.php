<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$objHoliday=new Holiday();
$objTransaction =new Transaction();
$employee_list=$obj->select("alpp_emp","1 order by emp_name ASC ",array("*"));
$leave_array=array("2"=>"Approved","0"=>"Pending","1"=>"Cancelled"); 
if(isset($_REQUEST['submit']))  /// insert code
{
   $employees=$_REQUEST['emp_ids'];
    
   $total_days=$local_holiday=$final_days=0;
    if($_REQUEST['leave_duration_to'])
    {
    $date1 = new DateTime($_REQUEST['leave_duration_from']);
    $date2 = new DateTime($_REQUEST['leave_duration_to']);
    if((strtotime($date1) < strtotime($date2)) ||  (date("d",strtotime($date1)) === date("d",strtotime($date2)))){
         //|| (date("d",strtotime($date1)) == ate("d",strtotime($date2)))   
        
        $date2 = $date2->modify( '+1 day' ); 
        //echo  $total_days = $date2->diff($date1)->format("%a");

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date1, $interval, $date2);
        //echo "<pre>";
        //print_r($period);
        //echo "</pre>";
        foreach ( $period as $dt )
        {
            //echo "<pre>";
            //print_r($dt);
            //echo "</pre>";
            $day=$dt->format( "l" );
            $date=$dt->format( "m/d/Y" );
            
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
            $holiday_list=$objHoliday->GetAllHoliday(" date='".$date."'",array("*"));
            if($holiday_list)
            {
                $local_holiday++;
            }
        
       
            //echo "Total :".$total_days."<br>";
            //echo "Local :".$local_holiday."<br>";        

            $final_days=$total_days-$local_holiday;
    }
    
//////////////////////////////////////////////////////////////
    $insert_ok = 0;
    $insert_count_ok = 0;
    $error_I_count= 0;
    $error_D_count= 0;
    //print_r($employees);
   foreach($employees as $emp)
    {    
       // check weather employee have enough balance 
       $balance_detail= $objTransaction->GetEmpBalanceDetail($emp);
       //print_r($balance_detail);
       $bI = $balance_detail['I']-$balance_detail['leavesI'];
       //echo "<br>";
       $bD = $balance_detail['D']-$balance_detail['leavesD'];
       
       if($_REQUEST['trans_type'] == 'I'){
            if($bI >= $final_days){
                $insert_ok =1;
            }else{
                $error_I_count++;
            }
       }
       if($_REQUEST['trans_type'] == 'D' ){
            if($bD >= $final_days){
                $insert_ok =1;
            }else{
                $error_D_count++;
            }
       }
       if($insert_ok){
            $insert_count_ok++;
            $inserted=$obj->insert("alpp_leave",array(
                                                 'leave_emp_id'     =>$emp,
                                                 'date'   =>   date("Y-m-d"),
                                                 'half_day'   =>   $_REQUEST['half_day'],
                                                 'leave_reason'     =>$_REQUEST['reason'],
                                                 'leave_duration'   =>$final_days,
                                                 'leave_duration_from'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_from'])),
                                                 'leave_duration_to'   =>date("Y-m-d h:i:s",  strtotime($_REQUEST['leave_duration_to'])),
                                                 'leave_balance_type'   =>$_REQUEST['trans_type'],
                                                 'leave_approval'   =>$_REQUEST['approval'],
                                                 'leave_datetime'   =>date('Y-m-d h:i:s'),
                                                 'leave_user'       =>$_SESSION['session_admin_email']
                                                 ));
       } 
       $insert_ok = 0;
    }    
    if($insert_count_ok)
    {     $message_success="
        <div class='widget-body'>
            <div class='alert alert-success'>
                    <button class='close' data-dismiss='alert'>×</button>
                    <strong>Success!</strong> $insert_count_ok Leave(s) Application Added Successfully.
            </div>
        </div>"; 
     } 

        if($error_I_count > 0 || $error_D_count > 0)
        {	
            $total_issue = $error_I_count + $error_D_count;
            $message_success="
            <div class='widget-body'>
                <div class='alert alert-danger'>
                        <button class='close' data-dismiss='alert'>×</button>
                        <strong>Error!</strong> $total_issue Leave(s) Application have Less Balance Issue.
                </div>
            </div>";
           // $message_error= "<script> alert('RECORD NOT INSERTED'); </script> ";        
        
        }
        }else{
            $message_success="
            <div class='widget-body'>
                <div class='alert alert-danger'>
                        <button class='close' data-dismiss='alert'>×</button>
                        <strong>Error!</strong>  Start date can not be greater then end date.
                </div>
            </div>";
        }

    }
}

        ?>

<style>
    .multiselectcheck {
            width:38em;
            height:8em;
            border:solid 1px #c0c0c0;
            overflow:auto;

    }

    .multiselectcheck label {
            display:block;
    }

    .multiselectcheck-on {
            color:#ffffff;
            background-color:#000099;
    }
</style>
						 
<script type="text/javascript">

    function do_this(){
        var checkboxes = document.getElementsByName('emp_ids[]');
        var button = document.getElementById('togglecheck');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }
</script>    
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Ingresar solicitud masiva</h2>
            </div>
<div class="box-content">
     <br>
<?php
if($message_success){
    echo  $message_success;
}
    ?>
     <form class="form-horizontal" role="form"  method="post">
               
                        
    <div class="form-group">                    
        <label class="control-label col-sm-2">1/2 Day Leave</label>                     
        <div class="col-sm-2">
            <select name="half_day" class="form-control" >
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>
<div class="form-group">
    <label class="control-label col-sm-2">Name</label>
    <div class="col-sm-8">                                    
        <fieldset class="multiselectcheck form-control">
        <label> <input type="checkbox" id="togglecheck" value="select" onClick="do_this()" />&nbsp;&nbsp;&nbsp;Select All</label>
        <?php
          foreach($employee_list as $employee)
          {  
            $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']);
            $bI=$balance_detail['I'] - $balance_detail['leavesI'];
            if($bI < 0)$bI="($bI)";
            $bD=$balance_detail['D']-$balance_detail['leavesD'];
            if($bD < 0)$bD="($bD)";
            echo"<label><input type=checkbox class=selectedId name=emp_ids[] value=".$employee['emp_id'].">&nbsp;&nbsp;&nbsp;".$employee['emp_file']."  -  ".$employee['emp_name']."  -  ".$employee['emp_department']." - ".$bD." - ".$bI."</label>";
          }
        ?>
        </fieldset>
        &nbsp;(Ficha - Employee Name - Department - DIAS PROGRESIVOS - FERIADO LEGAL)
    </div>
</div>
      
         
            <div class="form-group">                    
             <label class="control-label col-sm-2">From Date *</label>                     
             <div class="col-sm-2">
                 <input type="date" required="" class="form-control col-sm-4"  style="width:180px;"  id="leave_duration_from" name="leave_duration_from" value="<?php echo date('Y-m-d'); ?>">
             </div>
                            
             <label class="control-label col-sm-2">To Date *</label>                     
             <div class="col-sm-2">
                 <input type="date" required="" class="form-control col-sm-4" style="width:180px;"  id="leave_duration_to" name="leave_duration_to" value="<?php echo date('Y-m-d'); ?>">
             </div>
         </div>
         
         <div class="form-group">
              <label class="control-label col-sm-2">Type</label>
              <div class="col-sm-2">
                  <select name="trans_type" class="form-control" >
<!--                      <option value="M" <?php //if($transaction[0]['trans_type']=='M')echo"selected";?>>Manual</option>
                      <option value="C" <?php //if($transaction[0]['trans_type']=='C')echo"selected";?>>Auto System Added</option>-->
                      <option value="D" <?php if($transaction[0]['trans_type']=='D')echo"selected";?>>DIAS PROGRESIVOS</option>
                      <option value="I" <?php if($transaction[0]['trans_type']=='I')echo"selected";?>>FERIADO LEGAL</option>
                      
                  </select>
              </div>
         
                        <label class="control-label col-sm-2">Approval</label>
                        <div class="col-sm-2">          
                         <select name="approval" class="form-control" required="">
                          <option value="">SELECT</option>
                           <?php 
                                foreach($leave_array as $status=>$value)
                                {   
                                    if($status == 0)$sel="selected";
                                    echo "<option value=".$status." $sel>".$value."</option>";
                                    $sel="";
                                }
                                ?>
                        </select>
                        </div>
                    
                    </div>

         
                
          <div class="form-group">
                         <label class="control-label col-sm-2">Reason</label>                     
                        <div class="col-sm-8">
                            <textarea  class="form-control" name="reason"  placeholder="Enter Detail here..."></textarea>
                        </div>
                               
                        
                    
                    </div>

         <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-block btn-info">Save</button>
                         </div>
                    </div>  

                    <br>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


<?php include('../lib/footer.php'); ?>

<script>
$(function() {
  $( "#leave_duration_from" ).datepicker();
  $( "#leave_duration_to" ).datepicker();
});
</script>