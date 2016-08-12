<?php 
// include database and object files 
include (dirname(__FILE__).'/../../lib/include.php'); 
$obj=new Queries();
$data = json_decode(file_get_contents("php://input"));     

$submit=$obj->insert("alpp_emp",array(
                            'emp_name'         =>$data->emp_name,
                            'emp_file'         =>$data->emp_file,
                            
              ));
 
echo "Employee was created.";
?>