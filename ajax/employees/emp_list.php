<?php 
include (dirname(__FILE__).'/../../lib/include.php');
$objTransaction =new Transaction(); 
$obj=new Queries();
$query="select * from alpp_emp ; ";
$result = $link->query($query) or die($link->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}

$json_response = json_encode($arr);
// # Return the response
echo $json_response;