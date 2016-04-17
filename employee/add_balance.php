<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();
$objTransaction =new Transaction();


if(isset($_REQUEST['update_button']))  // update code
{
   $emp_id=$_REQUEST['emp_id_update'];

  $updated=$objTransaction->UpdateTransaction("id=".$_REQUEST['id'],array(
                'end_month_data'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['end_month_data'])),
                'amount'=>$_REQUEST['amount'],
                'trans_type'=>$_REQUEST['trans_type'],
                'date'=> date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                'status'=>$_REQUEST['status']
            ));
           
}
if(isset($_REQUEST['submit']))  /// insert code
{
    $_REQUEST['amount']=str_replace(",", ".", $_REQUEST['amount']);
    $insert=$objTransaction->InsertTransaction(array(
                'emp_id'=>$_REQUEST['emp_id'],
                'end_month_data'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['end_month_data'])),
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
            Add Manual Balance
        </li>
        <li>
            Balance Details
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Manual Balance</h2>
            </div>
            
            
            
           <div class="box-content">
               <div class="col-md-10">
                   &nbsp;
               </div>
                <div class="col-md-2">
                    <a class="btn btn-success" href="emp_balance.php?emp_id=<?php echo $_REQUEST['emp_id']?>">Go Back</a>
               </div>
               <div class="col-md-12">
                   &nbsp;
               </div>
               
     <br>
<?php 
    if($updated)
    {         ?>
        <div class="widget-body">
            <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Balance Detail Update.
            </div>
        </div>
<?php      header('REFRESH:2, url=emp_balance.php?emp_id='.$emp_id);
    }
	



    if($insert)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Balance Detail Submitted.
                        </div>
                    </div>
        <?php      header('REFRESH:2, url=emp_balance.php?emp_id='.$_REQUEST['emp_id']);
		}
	
      
 	 
if(isset($_REQUEST['emp_id']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['emp_id']) $id = $_REQUEST['view'];
        else  $id = $_REQUEST['update'];
    
        $transaction=$obj->select("alpp_transactions","id=$id ",array("*")); 
       // var_dump($transaction);
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
         <input type="hidden" value="<?php echo $_REQUEST['update'];?>" name="id">
         <input type="hidden" value="<?php echo $transaction[0]['emp_id'];?>" name="emp_id_update">
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Day</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $transaction[0]['amount']; ?>" placeholder="Days" name="amount">
                        </div>
                    <label class="control-label col-sm-2">Date</label>
                    <div class="col-sm-4">
                        <?php
                         $end_month_data=date("m/d/Y",strtotime($transaction[0]['end_month_data']));
                        if(empty($end_month_data) || $end_month_data == "01/01/1970" ){
                            //$end_month_data = lastOfMonth();
                            $end_month_data = date("m/d/Y");
                        }
                        ?>
                        <input type="text" id="datepicker" class="form-control" value="<?php echo $end_month_data;?>" placeholder="" name="end_month_data">
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
              <label class="control-label col-sm-2">Status</label>                     
                        <div class="col-sm-4">
                        <?php if($transaction[0]['status']==0) 
                        {   ?>
                                        <input type="radio" name="status" value="0" checked />Active
                                        <input type="radio" name="status" value="1"  />Disabled
                        <?php    } else { ?> 

                                                 <input type="radio" name="status" value="0"  />Active
                                                 <input type="radio" name="status" value="1"  checked />Disabled
                        <?php     } ?> 
                        
                        </div>
          </div>
                    
<?php  if(isset($_REQUEST['update']))	{  ?>
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="update_button" class="btn btn-small btn-block btn-info">Update</button>
                         </div>
                    </div>  
<?php } else {     ?>         
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-small btn-block btn-info">Save</button>
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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <?php
 function lastOfMonth()  
 {  
      return date("m/d/Y", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));  
 } 
 ?>