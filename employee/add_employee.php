<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Queries();
/// upload pic code
$pic='';     
if(isset($_REQUEST['update_button']))  // update code
{
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
            $submit0=$obj->update("alpp_emp","emp_id=".$_REQUEST['id'],array('emp_pic'=>$pic));
        }
    }

    $submit=$obj->update("alpp_emp","emp_id=".$_REQUEST['id'],array(
                            'emp_name'         =>$_REQUEST['emp_name'],
                            'emp_file'          =>$_REQUEST['emp_file'],
                            'emp_department'          =>$_REQUEST['emp_department'],
                           // 'emp_gender'       =>$_REQUEST['gender'],
                          //  'emp_designation'  =>$_REQUEST['emp_des'],
                            'emp_current_contract'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['emp_current_contract'])),
                            'emp_cellnum'      =>$_REQUEST['emp_cell'],
                            'emp_first_contract'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['emp_first_contract'])),
                            'emp_address'      =>$_REQUEST['emp_address'],
                            //'emp_qualification'=>$_REQUEST['emp_qua'],
                            'emp_email'        =>$_REQUEST['emp_email'],
                            'emp_password'      =>$_REQUEST['emp_password'],
                            'emp_count'      =>$_REQUEST['emp_count']
              ));
        if($submit || $submit0)
	{
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Employee Detail Updated.";
            
     //       if($_SESSION['session_admin_role']=='admin')header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_list.php');
     //       if($_SESSION['session_admin_role']=='employee')header('REFRESH:2, url='.SITE_ADDRESS.'dashboard.php'); // only profile update
	} else{
            $message_type="alert-error"; 
            $message_text = "<strong>Error!</strong> Employee Detail not Updated.";
         }
}

 if(isset($_REQUEST['submit']))  /// insert code
{
   
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
                                     'emp_file'          =>$_REQUEST['emp_file'],
                                    'emp_department'          =>$_REQUEST['emp_department'],
                                     'emp_current_contract'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['emp_current_contract'])),
                                     //'emp_designation'  =>$_REQUEST['emp_des'],
                                     //'emp_account_no'   =>$_REQUEST['emp_acc'],
                                     'emp_cellnum'      =>$_REQUEST['emp_cell'],
                                     'emp_landline'     =>$_REQUEST['emp_landline'],
                                     'emp_address'      =>$_REQUEST['emp_address'],
                                     'emp_first_contract'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['emp_first_contract'])),
                                     'emp_email'        =>$_REQUEST['emp_email'],
                                     'emp_password'      =>$_REQUEST['emp_password'],
                                     'emp_count'      =>$_REQUEST['emp_count'],
                                     'emp_pic'       =>$pic
              ));
        if($submit)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Employee Detail Submitted.";
            header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_list.php');
	}
	else{ 
            $message_type="alert-error"; 
            $message_text = "<strong>Error!</strong> Employee Detail not Submitted ,Please try again.";
            
        }
}
if(isset($_REQUEST['view']) || isset($_REQUEST['update']))	
{	
        if($_REQUEST['view']) $id = $_REQUEST['view'];
        else  $id = $_REQUEST['update'];
    
        $employee_list=$obj->select("alpp_emp","emp_id=$id ",array("*")); 
        //print_r($employee_list);
        $emp_first_contract=date("m/d/Y",strtotime($employee_list[0]['emp_first_contract']));
        if(empty($emp_first_contract) || $emp_first_contract == "01/01/1970" ){
            $emp_first_contract = "";
        }
        $emp_current_contract=date("m/d/Y",strtotime($employee_list[0]['emp_current_contract']));
        if(empty($emp_current_contract) || $emp_current_contract == "01/01/1970" ){
            $emp_current_contract = "";
        }
}

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

<div class="row">
    <div class="box col-md-10">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Employee</h2>
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

     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
               
                    <div class="form-group">
                        <label class="control-label col-sm-2">Ficha</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_file']; ?>" placeholder="Ficha" name="emp_file">
                            
                        </div>
                        <label class="control-label col-sm-2">Nombre</label>
                        <div class="col-sm-4">          
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_name']; ?>" placeholder="Nombre" name="emp_name">
                            <input type="hidden" value="<?php echo $employee_list[0]['emp_id']; ?>" name="id">
                        </div>
                    <!--
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
                    -->
                    </div>
                    <!--
                    
                        <label class="control-label col-sm-2">Designation</label>                     
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_designation']; ?>" placeholder="Designation" name="emp_des">
                        </div>
                    -->
                    <div class="form-group">
                        <label class="control-label col-sm-2">Department</label>
                        <div class="col-sm-4">          
                            <select name="emp_department">
                                <option value="">SELECT</option>
                        <?php
                                $dep_array=array('Indubal','Soinb');                               
                                foreach ($dep_array as $dep)
                                {
                                    $sel=$employee_list[0]['emp_department']==$dep ? 'selected' : '';
                                    echo "<option value=".$dep." $sel>$dep</option>";
                                }
                                ?>
                            </select>
                        </div>
                         <label class="control-label col-sm-2">FERIADO LEGAL<br> PROPORCIONAL 2015<br> A LA FECHA</label>                     
                        <div class="col-sm-4">
                            <input type="text" name="emp_count" class="form-control" value="<?php echo $employee_list[0]['emp_count']; ?>"  placeholder="FERIADO LEGAL PROPORCIONAL 2015 A LA FECHA">
                        </div> 
                    
                    </div>
                    
                   <div class="form-group">
                   
                       <label class="control-label col-sm-2">RUT</label>                     
                        <div class="col-sm-4">
                             <input type="text" class="form-control" value="<?php echo $employee_list[0]['emp_cellnum']; ?>" placeholder="RUT" name="emp_cell">
                        </div>
                     <label class="control-label col-sm-2">FECHA INGRESO</label>                     
                        <div class="col-sm-4">
                             <input type="text" id="emp_current_contract" class="form-control" value="<?php echo $emp_current_contract; ?>" placeholder="Contrato Actual" name="emp_current_contract">
                        </div>
                       
                 
                    </div>
                    <div class="form-group">
                        
                        
                       
                       
                    
                    </div>
                   
                    <div class="form-group">
                        
                        
                        <label class="control-label col-sm-2">Email</label>                     
                        <div class="col-sm-4">
                            <input type="email" name="emp_email" class="form-control"  value="<?php echo $employee_list[0]['emp_email']; ?>" placeholder="Enter email">
                        </div>
                        <label class="control-label col-sm-2">Password</label>                     
                        <div class="col-sm-3">
                            <input type="text" name="emp_password" class="form-control" value="<?php echo $employee_list[0]['emp_password']; ?>"  placeholder="Password">
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
  $( "#emp_first_contract" ).datepicker();
  $( "#emp_current_contract" ).datepicker();
  
});
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
