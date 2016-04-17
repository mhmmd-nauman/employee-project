<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Transaction();
$objEmployee =new Employee();
?>
<div class="row">
    <div class="box col-md-10">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>Upload new csv by browsing to file and clicking on Upload </h2>
            </div>
            
            
            
           <div class="box-content">
     <br>
    <?php
     if (isset($_POST['submit'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']);
	}
	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //update initial balance
//        $submit=$obj->UpdateTransactionByEmployee("alpp_emp.emp_file=".$data[0],array("alpp_transactions.amount"=>$data[6]));
       
            $emp_data = $objEmployee->GetAllEmployee("emp_file = ".$data[0],array("emp_id"));

          if($emp_data[0][0])
          {          
          $submit=$obj->InsertTransaction(array( 
                                                'emp_id'=>$emp_data[0][0], 
                                                'end_month_data'=>'2015-11-30 00:00:00', 
                                                'amount'=>$data[7], 
                                                'trans_type'=>'M', 
                                                'date'=>'2015-12-06 00:00:00', 
                                                'done_by'=>'2', 
                                                'status'=>0
                                            ));         
        }
        }
   
	fclose($handle);
	print "Import done";
	//view upload form
}    ?>

  

	<form enctype='multipart/form-data'  method='post'>

            
              <div class="form-group">
                        <label class="control-label col-sm-2"> Balance Sheet</label>
                        <div class="col-sm-3">          
                           <input size='50' type='file' name='filename' >
                        </div>
                    
                    </div>
            
            <div class="form-group">
                        <label class="control-label col-sm-2">Department</label>
                        <div class="col-sm-3">          
                            <select name="dept">
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
                    
                    </div>
	<input type='submit' name='submit' value='Upload'>
        </form>


        
        
     
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<?php include('../lib/modal_footer.php'); ?>