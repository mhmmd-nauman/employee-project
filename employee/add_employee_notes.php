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
     
    if(isset($_FILES['notesfile']['name']))
    {
        $image=$_FILES['notesfile']['name'];
        
        if ($image) 
        {
            //ALTER TABLE `alpp_emp_notes` ADD `file` VARCHAR(30) NULL AFTER `notes`;
            //ALTER TABLE `alpp_emp_notes` ADD `filetype` VARCHAR(10) NULL AFTER `file`;
            $filename = stripslashes($_FILES['notesfile']['name']);
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            $size=filesize($_FILES['notesfile']['tmp_name']);

            $image_name=time().'.'.$extension;
            $pic="img/employee/".$image_name; // db path
            //echo "ddd".$_FILES['notesfile']['type'];
            $copied = copy($_FILES['notesfile']['tmp_name'], "../".$pic); // actual path

        }
    }  
    $submit=$obj->insert("alpp_emp_notes",array(
                            'emp_id'         =>$_REQUEST['emp_id'],
                            'notes'          =>$_REQUEST['notes'],
                            'creation_date' => date("Y-m-d h:i:s"),
                            'entered_by'  =>$_SESSION['session_admin_id'],
                            'file'=>$pic,
                            'filetype'=>$_FILES['notesfile']['type'],
                            'filename'=>$_FILES['notesfile']['name'],
                                     
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

$employee_data=$obj->select("alpp_emp","emp_id = ".$_REQUEST['emp_id'],array("*"));
?>



<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> <?php echo $employee_data[0]['emp_name'];?> - Notes</h2>
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

     <form action="?emp_id=<?php echo $_REQUEST['emp_id'];?>" class="form-horizontal" role="form"  method="post" enctype="multipart/form-data" >
               
    <div class="form-group">
        <label class="control-label col-sm-4">Add Notes</label>
        <div class="col-sm-8"> 
            <textarea name="notes" rows="3" cols="60"></textarea>
            
        </div>
       
    </div>
  
         <div class="form-group">
             <label class="control-label col-sm-4">Leave Report</label>
             <div class="col-sm-8">
                 <input type="file" name="notesfile">
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
                <th style="width: 15%">Document</th>
                <th style="width: 15%">Date</th>
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
                <td><?php echo $notes['filename'];?></td>
                <td><?php echo date("M d, Y m:i:s A",  strtotime($notes['creation_date']));?></td>
                <td>
                    <a onclick="return confirmation();" title="Remove Notes" class=" btn btn-danger btn-sm add_employee_notes" href="add_employee_notes.php?emp_id=<?php echo $notes['emp_id']; ?>&id=<?php echo $notes['id'];?>&action=remove"><i class="glyphicon glyphicon-trash icon-white"></i></a>
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
<?php
function getExtension($str) 
{
 $i = strrpos($str,".");
 if (!$i) { return ""; }
 $l = strlen($str) - $i;
 $ext = substr($str,$i+1,$l);
 return $ext;
}
?>