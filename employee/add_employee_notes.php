<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Queries();
$pic='';     
if($_REQUEST['action'] =='remove')  // update code
{
   $submit=$obj->Delete("alpp_emp_notes","id=".$_REQUEST['id']
              );
        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Notes Deleted.";
            
     
}

 if(isset($_REQUEST['submit']))  /// insert code
{
   //// insert query
                
    $submit=$obj->insert("alpp_emp_notes",array(
                            'emp_id'         =>$_REQUEST['emp_id'],
                            'notes'          =>$_REQUEST['notes'],
                            'creation_date' => date("Y-m-d h:i:s"),
                            'entered_by'  =>$_SESSION['session_admin_id'],
                                     
              ));
        if($submit)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Notes Submitted.";
          //  header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_list.php');
	}
	else{ 
            $message_type="alert-error"; 
            $message_text = "<strong>Error!</strong> Notes not Submitted ,Please try again.";
            
        }
}


?>



<div class="row">
    <div class="box col-md-9">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Employee Notes</h2>
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
     <?php }?>

     <form action="?emp_id=<?php echo $_REQUEST['emp_id'];?>" class="form-horizontal" role="form"  method="post" >
               
    <div class="form-group">
        <label class="control-label col-sm-4">Add Notes</label>
        <div class="col-sm-8"> 
            <textarea name="notes" rows="3" cols="60"></textarea>
            
        </div>
       
        
    </div>
  
    

    
                
          
       
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-small btn-block btn-error">Save</button>
                         </div>
                    </div>  


                    <br>
</form>

           
        <!-- display -->
        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
  
         <thead>
            <tr>
                <th>Notes</th>
                <th style="width: 22%">Date</th>
                <th style="width: 10%">Action</th>
            </tr>
            <?php  
            $employee_notes = $obj->select("alpp_emp_notes","emp_id = ".$_REQUEST['emp_id']." order by creation_date DESC",array("*")); 
            foreach($employee_notes as $notes){
            ?>
            <tr>
                <td>
                    <?php echo $notes['notes'];?>
                </td>
                <td><?php echo date("M d, Y m:i:s A",  strtotime($notes['creation_date']));?></td>
                <td>
                    <a onclick="return confirmation();" title="Remove Notes" class=" add_employee_notes" href="add_employee_notes.php?emp_id=<?php echo $notes['emp_id']; ?>&id=<?php echo $notes['id'];?>&action=remove"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            <?php }?>
         </thead>
        </table>
           
           
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
    function confirmation() {
        var answer = confirm("Do you want to delete this record?");
    if(answer){
            return true;
    }else{
            return false;
    }
}
</script>
