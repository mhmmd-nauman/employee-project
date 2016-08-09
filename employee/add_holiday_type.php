<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$objHoliday =new Holiday();

if(isset($_REQUEST['update_button']))  // update code
{
    $submit=$objHoliday->UpdateHolidaytype("id=".$_REQUEST['update'],array('type'  => $_REQUEST['type']));
        if($submit )
	{
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Employee Detail Updated.";
	} 
        else
        {
            $message_type="alert-error"; 
            $message_text = "<strong>Error!</strong> Employee Detail not Updated.";
        }
}

 if(isset($_REQUEST['submit']))  /// insert code
{
   $submit=$objHoliday->InsertHolidaytype(array('type'  => $_REQUEST['type'] ));
    if($submit)
    {        
        $message_type="alert-success"; 
        $message_text = "<strong>Success!</strong> Holiday Detail Submitted.";
    }
    else{ 
        $message_type="alert-warning"; 
        $message_text = "<strong>Error!</strong> Holiday Detail not Submitted ,Please try again.";

    }
}
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
    if($_REQUEST['view']) $id = $_REQUEST['view'];  else  $id = $_REQUEST['update'];
    $holiday_list=$objHoliday->GetAllHolidaytype(" id=$id order by type",array("*"));
}
?>
<div class="row">
    <div class="box col-md-9">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Holiday Type</h2>
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
            <input type="text" class="form-control" value="<?php echo $holiday_list[0]['type']; ?>" placeholder="Type" name="type">
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
  $( "#date" ).datepicker();
});
</script>