<?php 
include ('../lib/include.php');
include('../lib/header.php');
$obj=new Queries();
?>
<script>
function checkPhoto(target) {
 {
var fileName = target.value;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG" )
		{
							if(target.files[0].size > 2097152) 
							{
								alert("Image too big (max 2MB)");
								document.getElementById("img1").value = "";
								return false;
							}
		}
		else
							{
								alert("Extension will be jpeg, gif or png");
								document.getElementById("img1").value = "";
								return false;
							}
}
}
</script>

<div>
    <ul class="breadcrumb">
        <li>
            <a href="../dashboard.php">Home</a>
        </li>
        <li>
            <a href="add_employee.php">Add</a>
        </li>
        <li>
            <a href="emp_list.php">Employee List</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Employee</h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
<?php 
if(isset($_REQUEST['update_button']))  // update code
{
           $submit=$obj->update("alpp_emp","emp_id=$id ",array(
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
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Update.
                        </div>
                    </div>
        <?php      header('REFRESH:2, url=emp_list.php');
		}
	else    	echo "<script> alert('RECORD NOT Updated'); </script> ";
}

 if(isset($_REQUEST['submit']))  /// insert code
{
      
     /// upload pic code
      $pic='';
      function getExtension($str) 
	{
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}

		if(isset($_FILES['image']['name']))
		{
		$image=$_FILES['image']['name'];

		if ($image) 
		{
			$filename = stripslashes($_FILES['image']['name']);
			$extension = getExtension($filename);
			$extension = strtolower($extension);
			$size=filesize($_FILES['image']['tmp_name']);

				$image_name=time().'.'.$extension;
				$pic="img/employee/".$image_name; // db path
				$copied = copy($_FILES['image']['tmp_name'], "../".$pic); // actual path
                            
		}
		}

    //// insert query
                
                $submit=$obj->insert("alpp_emp",array(
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
                                                 'emp_salary'      =>$_REQUEST['emp_salary'],
                                                    'emp_pic'       =>$pic
              ));
        if($submit)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Record Inserted.
                        </div>
                    </div>
        <?php      header('REFRESH:2, url=emp_list.php');
		}
	else    	echo "<script> alert('RECORD NOT INSERTED'); </script> ";
}

        

      
 	 
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) $id = $_REQUEST['view'];
        else  $id = $_REQUEST['update'];
    
        $employee_list=$obj->select("alpp_emp","emp_id=$id ",array("*"));   
}
        ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Employee Name</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_name']; ?>" placeholder="Employee Name" name="emp_name">
                        </div>
                    
                        <label class="control-label col-sm-2">Gender</label>                     
                        <div class="col-sm-3">
                        <?php if($employee_list[0]['emp_gender']==0) 
                        {   ?>
                                        <input type="radio" name="gender" value="1" />Male
                                        <input type="radio" name="gender" value="0"  checked="" />Female
               <?php    } else { ?> 
                        
                                        <input type="radio" name="gender" value="1"  checked="" />Male
                                        <input type="radio" name="gender" value="0"  />Female
               <?php     } ?> 
                        
                        </div>
                    
                    </div>
                    
                    <div class="form-group">
                    
                        <label class="control-label col-sm-2">Designation</label>                     
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_designation']; ?>" placeholder="Designation" name="emp_des">
                        </div>
                    
                        <label class="control-label col-sm-2">Father Name</label>
                        <div class="col-sm-3">          
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_fathername']; ?>" placeholder="Father Name" name="emp_fname">
                        </div>
                    
                    </div>
                    
                   <div class="form-group">
                   
                       <label class="control-label col-sm-2">Cell</label>                     
                        <div class="col-sm-4">
                             <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_cellnum']; ?>" placeholder="Cell" name="emp_cell">
                        </div>
                     
                       <label class="control-label col-sm-2">Landline</label>                     
                        <div class="col-sm-3">
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_landline']; ?>" placeholder="Landline" name="emp_landline">
                        </div>
                 
                    </div>
                    
                   
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Email</label>                     
                        <div class="col-sm-4">
                            <input type="email" name="emp_email" class="form-control"  value="<?php echo $employee_list[0]['emp_email']; ?>" placeholder="Enter email">
                        </div>
                        
                        <label class="control-label col-sm-2">Password</label>                     
                        <div class="col-sm-3">
                            <input type="password" name="emp_password" class="form-control" value="<?php echo $employee_list[0]['emp_password']; ?>"  placeholder="Password">
                        </div>
                    
                    </div>
                   
                   
                   <div class="form-group">
                        
                        <label class="control-label col-sm-2">Account #</label>                     
                        <div class="col-sm-4">
                            <input type="text" name="emp_acc" class="form-control" value="<?php echo $employee_list[0]['emp_account_no']; ?>"  placeholder="Enter Account #" >
                        </div>
                        
                        <label class="control-label col-sm-2">Qualification</label>                     
                        <div class="col-sm-3">
                            <input type="text" name="emp_qua" class="form-control" value="<?php echo $employee_list[0]['emp_qualification']; ?>"   placeholder="Qualification">
                        </div>
                    
                    </div>
                   
                    <div class="form-group">
                       
                        <label class="control-label col-sm-2">Image</label>                     
                        <div class="col-sm-4">
                            <input type="file" name="image" id="img1" onChange="checkPhoto(this)" class="btn btn-info">
                        </div>        
                        
                      <label class="control-label col-sm-2">Salary</label>                     
                        <div class="col-sm-2">
                            <input type="text" name="emp_salary" class="form-control" value="<?php echo $employee_list[0]['emp_salary']; ?>"  placeholder="Basic Salary">
                        </div> 
                    
                    </div>
                    
                
          <div class="form-group">
                         <label class="control-label col-sm-2">Address</label>                     
                        <div class="col-sm-4">
                            <textarea  class="form-control" name="emp_address"  placeholder="Enter Address"><?php echo $employee_list[0]['emp_address']; ?></textarea>
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

<?php include('../lib/footer.php'); ?>
