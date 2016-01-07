<?php 
include ('../lib/include.php');
include('../lib/header.php');
$obj=new Queries();
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
        //echo  $total_days = $date2->diff($date1)->format("%a");

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date1, $interval, $date2);
        foreach ( $period as $dt )
        {
            $day=$dt->format( "l" );
            $date=$dt->format( "m/d/Y" );
            
            if($day=='Saturday' || $day=='Sunday')
            {
                
            }
            else
            {
                $total_days++;
            }   
            
            $holiday_list=array();
            $holiday_list=$objHoliday->GetAllHoliday(" date='".$date."'",array("*"));
            if($holiday_list)
            {
                $local_holiday++;
            }
        
        }
            //echo "Total :".$total_days."<br>";
            //echo "Local :".$local_holiday."<br>";        

            $final_days=$total_days-$local_holiday;
    }
    
//////////////////////////////////////////////////////////////
   
   foreach($employees as $emp)
    {    
       
       $inserted=$obj->insert("alpp_leave",array(
                                                 'leave_emp_id'     =>$emp,
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
    if($inserted)
		{     $message_success="
                    <div class='widget-body'>
                        <div class='alert alert-success'>
                                <button class='close' data-dismiss='alert'>×</button>
                                <strong>Success!</strong> Leave Added.
                        </div>
                    </div>"; 
                 } 

        else    {	$message_error= "<script> alert('RECORD NOT INSERTED'); </script> ";        }

}

        ?>

<style>
							.multiselect {
								width:38em;
								height:8em;
								border:solid 1px #c0c0c0;
								overflow:auto;
                                                                
							}
							 
							.multiselect label {
								display:block;
							}
							 
							.multiselect-on {
								color:#ffffff;
								background-color:#000099;
							}
</style>
						 
<script type="text/javascript">

    function do_this(){

        var checkboxes = document.getElementsByName('emp_ids[]');
        var button = document.getElementById('toggle');

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

<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li> Leave   </li>
    </ul>
</div>
    
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Employee Mass Leave Applications</h2>
                 <div class="box-icon">
            <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
<div class="box-content">
     <br>
<?php
if($inserted)		{   echo  $message_success; header('REFRESH:2, url=leave_list.php'); }
else                    {   echo  $message_error; }
    ?>
     <form class="form-horizontal" role="form"  method="post">
               
                        
         
<div class="form-group">
    <label class="control-label col-sm-2">Name</label>
    <div class="col-sm-4">                                    
        <fieldset class="multiselect form-control">
        <label> <input type="checkbox" id="toggle" value="select" onClick="do_this()" />&nbsp;&nbsp;&nbsp;Select All</label>
        <?php
                 foreach($employee_list as $employee)
                                        {  
        echo"<label><input type=checkbox class=selectedId name=emp_ids[] value=".$employee['emp_id']."/>&nbsp;&nbsp;&nbsp;".$employee['emp_file']."  -  ".$employee['emp_name']."  -  ".$employee['emp_department']."</label>";
                                        }
        ?>
        </fieldset>
    </div>
</div>
               
         
                       <div class="form-group">                    
                        <label class="control-label col-sm-2">Duration from *</label>                     
                        <div class="col-sm-4">
                            <input type="text" required="" class="form-control col-sm-4"  style="width:180px;"  id="leave_duration_from" name="leave_duration_from">
                        </div>
                    </div>
         
                    <div class="form-group">                    
                        <label class="control-label col-sm-2">Duration to *</label>                     
                        <div class="col-sm-4">
                            <input type="text" required="" class="form-control col-sm-4" style="width:180px;"  id="leave_duration_to" name="leave_duration_to">
                        </div>
                    </div>
         
         <div class="form-group">
              <label class="control-label col-sm-2">Type</label>
              <div class="col-sm-4">
                  <select name="trans_type" class="form-control" >
<!--                      <option value="M" <?php //if($transaction[0]['trans_type']=='M')echo"selected";?>>Manual</option>
                      <option value="C" <?php //if($transaction[0]['trans_type']=='C')echo"selected";?>>Auto System Added</option>-->
                      <option value="D" <?php if($transaction[0]['trans_type']=='D')echo"selected";?>>DIAS PROGRESIVOS</option>
                      <option value="I" <?php if($transaction[0]['trans_type']=='I')echo"selected";?>>FERIADO LEGAL</option>
                      
                  </select>
              </div>
         </div>             

         <div class="form-group">
                        <label class="control-label col-sm-2">Approval</label>
                        <div class="col-sm-4">          
                            <select name="approval" class="form-control" required="">
                          <option value="">SELECT</option>
                           <?php 
                                foreach($leave_array as $status=>$value)
                                {   
                                    echo "<option value=".$status." $sel>".$value."</option>";
                                }
                                ?>
                        </select>
                        </div>
                    
                    </div>

         
                
          <div class="form-group">
                         <label class="control-label col-sm-2">Reason</label>                     
                        <div class="col-sm-4">
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#leave_duration_from" ).datepicker();
  $( "#leave_duration_to" ).datepicker();
});
</script>