<?php 
// include database and object files 
include (dirname(__FILE__).'/../../lib/include.php'); 

$data = json_decode(file_get_contents("php://input"));     

 
$query="select * from alpp_emp where emp_file =  $data->id ; ";
$result = $link->query($query) or die($link->error.__LINE__);
$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}
// create array

 
// make it json format
print_r(json_encode($arr));
?>