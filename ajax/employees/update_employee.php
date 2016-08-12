<?php 
// include database and object files 
include (dirname(__FILE__).'/../../lib/include.php'); 
$obj=new Queries();
$data = json_decode(file_get_contents("php://input"));     

$submit=$obj->update("alpp_emp","emp_file=".$data->emp_file,array(
                            'emp_name'         =>$data->emp_name,
                            
                            
              ));
 
echo "Employee was updated.";
?>