<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Queries();

if(isset($_REQUEST['update_button']))  // update code
{
//////////////////////////////////////////////////////////////
$submit=$obj->update("alpp_leave","leave_id=".$_REQUEST['id'] ,array(
                                   
                                      'leave_reason'     =>$_REQUEST['reason'],
                                     
                                      'leave_approval'   =>$_REQUEST['status'],
                                      'leave_datetime'   =>date('Y-m-d h:i:s'),
                                      'leave_user'       =>$_SESSION['session_admin_email']
                                                     ));
        
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

   
 	 
if(isset($_REQUEST['id']))	
{	
   $id = $_REQUEST['id'];    
}
?>

<div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>Status Approval </h2>
            </div>
            
<div class="box-content">
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
        <label class="control-label col-sm-2">Reason</label>                     
            <div class="col-sm-4">
                <textarea  class="form-control" name="reason" <?php echo $readonly; ?>  placeholder="Enter Detail here..."><?php echo $leave_list[0]['leave_reason']; ?></textarea>
            </div>
    </div>
    <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-4" align="center">
            <button type="submit" name="update_button" class="btn btn-small btn-info">Update</button>
         </div>
    </div>  
      
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