<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$objTransaction =new Transaction();

if(isset($_REQUEST['update_button']))  // update code
{
           $updated=$obj->update("alpp_emp","emp_id=$id ",array(
                                                 'emp_name'         =>$_REQUEST['emp_name'],
                                                 'emp_fathername'   =>$_REQUEST['emp_fname'],
                                                 'emp_gender'       =>$_REQUEST['gender'],
                                                 'emp_designation'  =>$_REQUEST['emp_des'],
                                                 'emp_account_no'   =>$_REQUEST['emp_acc'],
                                                 'emp_cellnum'      =>$_REQUEST['emp_cell'],
                                                 'emp_landline'     =>$_REQUEST['emp_landline'],
                                                 'emp_address'      =>$_REQUEST['emp_address'],
                                                 'emp_qualification'=>$_REQUEST['emp_qua'],
                                                 'emp_email'        =>$_REQUEST['emp_email'],
                                                 'emp_password'      =>$_REQUEST['emp_password'],
                                                 'emp_salary'      =>$_REQUEST['emp_salary']
                                                  
              ));
}
if(isset($_REQUEST['submit']))  /// insert code
{
    $insert=$objTransaction->InsertTransaction(array(
                'emp_id'=>1,
                'amount'=>$_REQUEST['amount'],
                'trans_type'=>$_REQUEST['trans_type'],
                'date'=> date("Y-m-d h:i:s"),
                'done_by'=>1,
                'status'=>1
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
            <a href="<?php echo SITE_ADDRESS; ?>employee/emp_balance.php">Transaction List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Transaction</h2>
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
        <?php      header('REFRESH:2, url=emp_balance.php');
		}
	
      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) $id = $_REQUEST['view'];
        else  $id = $_REQUEST['update'];
    
        $transaction=$obj->select("alpp_emp","emp_id=$id ",array("*"));   
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Amount</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $transaction[0]['amount']; ?>" placeholder="Amount in $" name="amount">
                        </div>
                    
                        <label class="control-label col-sm-2">Transaction Type</label>                     
                        <div class="col-sm-3">
                        <?php if($transaction[0]['trans_type']=='C') 
                        {   ?>
                                        <input type="radio" name="trans_type" value="D" />Debit
                                        <input type="radio" name="trans_type" value="C"  checked="" />Credit
                        <?php    } else { ?> 

                                                 <input type="radio" name="trans_type" value="D"  checked="" />Debit
                                                 <input type="radio" name="trans_type" value="C"  />Credit
                        <?php     } ?> 
                        
                        </div>
                    
                    </div>
          <div class="form-group">
              <label class="control-label col-sm-2">Status</label>                     
                        <div class="col-sm-3">
                        <?php if($transaction[0]['status']==0) 
                        {   ?>
                                        <input type="radio" name="status" value="1" />Active
                                        <input type="radio" name="status" value="0"  checked="" />Disabled
                        <?php    } else { ?> 

                                                 <input type="radio" name="status" value="1"  checked="" />Active
                                                 <input type="radio" name="status" value="0"  />Disabled
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
