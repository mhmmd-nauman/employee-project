<?php 
include ('../lib/include.php');
include('../lib/modal_header.php');
$obj=new Employee();
/// upload pic code

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
		//readfile($_FILES['filename']['tmp_name']);
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $submit=$obj->UpdateEmployee("emp_file='".$data[0]."'",array("emp_salary"=>$data[4]));
        }

	fclose($handle);

	print "Import done";

	//view upload form
}


	    ?>

  

	<form enctype='multipart/form-data'  method='post'>

            Balance Sheet to import:<input size='50' type='file' name='filename' ><br>

	<input type='submit' name='submit' value='Upload'>
        </form>


        
        
     
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<?php include('../lib/modal_footer.php'); ?>
