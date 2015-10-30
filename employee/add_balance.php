<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$objTransaction =new Transaction();

if(isset($_REQUEST['update_button']))  // update code
{
           
}
if(isset($_REQUEST['submit']))  /// insert code
{
    $insert=$objTransaction->InsertTransaction(array(
                'emp_id'=>$_REQUEST['view'],
                'end_month_data'=>$_REQUEST['end_month_data'],
                'amount'=>$_REQUEST['amount'],
                'trans_type'=>$_REQUEST['trans_type'],
                'date'=> date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                'status'=>$_REQUEST['status']
            ));
                
                
}
?>


<div>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>dashboard.php">Home</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/add_balance.php">Add Balance</a>
        </li>
        <li>
            <a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php">Balance Details</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Balance</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
    if($updated)
    {         ?>
        <div class="widget-body">
            <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Record Update.
            </div>
        </div>
<?php      header('REFRESH:2, url=emp_balance.php');
    }
	



    if($insert)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Inserted.
                        </div>
                    </div>
        <?php      header('REFRESH:2, url=emp_balance.php?view='.$_REQUEST['view']);
		}
	
      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) $id = $_REQUEST['view'];
        else  $id = $_REQUEST['update'];
    
        $transaction=$obj->select("alpp_emp","emp_id=$id ",array("*"));   
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
         <input type="hidden" value="<?php echo $_REQUEST['view'];?>" name="view">
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Day</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $transaction[0]['amount']; ?>" placeholder="Days" name="amount">
                        </div>
                    
                        <label class="control-label col-sm-2">Balance Type</label>                     
                        <div class="col-sm-3">
                        <?php if($transaction[0]['trans_type']=='C') 
                        {   ?>
                                        <input type="radio" name="trans_type" value="D" />Consumed
                                        <input type="radio" name="trans_type" value="C"  checked="" />Received
                        <?php    } else { ?> 

                                                 <input type="radio" name="trans_type" value="D"  checked="" />Consumed
                                                 <input type="radio" name="trans_type" value="C"  />Received
                        <?php     } ?> 
                        
                        </div>
                    
                    </div>
          <div class="form-group">
              <label class="control-label col-sm-2">Month End</label>
                    <div class="col-sm-4">          
                        <input type="text" class="form-control" value="<?php echo date("Y-m-d");?>" placeholder="" name="end_month_data">
                    </div>
              <label class="control-label col-sm-2">Status</label>                     
                        <div class="col-sm-3">
                        <?php if($transaction[0]['status']==0) 
                        {   ?>
                                        <input type="radio" name="status" value="0" />Active
                                        <input type="radio" name="status" value="1"  checked="" />Disabled
                        <?php    } else { ?> 

                                                 <input type="radio" name="status" value="0"  checked="" />Active
                                                 <input type="radio" name="status" value="1"  />Disabled
                        <?php     } ?> 
                        
                        </div>
          </div>
                    
<?php  if(isset($_REQUEST['update']))	{  ?>
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

<?php include('../lib/footer.php'); ?>
