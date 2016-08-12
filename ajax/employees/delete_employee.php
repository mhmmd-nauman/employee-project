<?php 
// include database and object files 
include (dirname(__FILE__).'/../../lib/include.php'); 
$obj=new Queries();
$data = json_decode(file_get_contents("php://input")); 

$del = $obj->Delete("alpp_emp",'emp_file='.$data->emp_file); 

echo "Employee was deleted.";
?>