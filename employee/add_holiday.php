<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$objHoliday =new Holiday();
$holidaytype_list=$objHoliday->GetAllHolidaytype("1 order by type",array("*"));

if(isset($_REQUEST['update_button']))  // update code
{
    $submit=$objHoliday->UpdateHoliday("id=".$_REQUEST['update'],
                array(
                    'type'  => $_REQUEST['type'],
                    'title'  => $_REQUEST['title'],
                    'date'   => date("Y-m-d",strtotime($_REQUEST['date']))
                    ));
        if($submit )
	{
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Holiday Detail Updated.";
	} 
        else
        {
            $message_type="alert-warning"; 
            $message_text = "<strong>Error!</strong> Holiday Detail not Updated.";
        }
}

 if(isset($_REQUEST['submit']))  /// insert code
{
   $submit=$objHoliday->InsertHoliday(
           array(
                    'type'  => $_REQUEST['type'],
                    'title'  => $_REQUEST['title'],
                    'date'   => date("Y-m-d",strtotime($_REQUEST['date']))
            ));
    if($submit)
    {        
        $message_type="alert-success"; 
        $message_text = "<strong>Success!</strong> Holiday Detail Submitted.";
    }
    else{ 
        $message_type="alert-error"; 
        $message_text = "<strong>Error!</strong> Holiday Detail not Submitted ,Please try again.";

    }
}
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
    if($_REQUEST['view']) $id = $_REQUEST['view'];  else  $id = $_REQUEST['update'];
    $holiday_list=$objHoliday->GetAllHoliday(" alpp_holidays.id = $id order by title",array("alpp_holidays.*"));
}
//print_r($holiday_list);
?>
<div class="row">
    <div class="box col-md-9">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Holiday</h2>
            </div>
            
<div class="box-content">
             <br>    
               
     
     <?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>   
        <script> window.parent.location.reload();</script>
     <?php }?>

<form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
    <div class="form-group">
        <label class="control-label col-sm-2">Holiday Type</label>
        <div class="col-sm-4">          
            <select name="type" class="form-control">
                <?php foreach($holidaytype_list as $type){  
                    $sel=($holiday_list[0]['type']==$type['id'])? 'selected': '';?>
                
                    <option value="<?php echo $type['id'];?>" <?php echo $sel;  ?>><?php echo $type['type'];?></option>
                <?php   }   ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">Holiday Title</label>
        <div class="col-sm-4">          
            <input type="text" class="form-control" value="<?php echo $holiday_list[0]['title']; ?>" placeholder="Title" name="title">
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-2">Date</label>                     
            <div class="col-sm-4">
                <?php if($holiday_list[0]['date']){
                    $date=date("d-m-Y",strtotime($holiday_list[0]['date']));
                }?>
               <input type="text" id="date" class="form-control" value="<?php echo $date;?>" name="date">
            </div>
    </div>

  
<?php if(isset($_REQUEST['view']))	{  ?>                   
<?php } else if(isset($_REQUEST['update']))	{  ?>
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="update_button" class="btn btn-small btn-block btn-error">Update</button>
                         </div>
                    </div>  
<?php } else {     ?>         
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-small btn-block btn-error">Save</button>
                         </div>
                    </div>  

<?php }?>
                    <br>
</form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<?php include('../lib/modal_footer.php'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
  $( "#date" ).datepicker({
        dateFormat: "dd-mm-yy"
        //beforeShowDay: $.datepicker.noWeekends
    });
});
</script>