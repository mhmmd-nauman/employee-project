<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$obj=new Queries();

$change = $obj->update("alpp_emp","emp_password!='1234'", array('emp_password' => '1234')); 
	if($change)
	{ ?>
            <div class="widget-body">
                <div class="alert alert-success">
                   <button class="close" data-dismiss="alert">×</button>
                   <strong>Success!</strong> Access Changed.
                </div>
            </div>
     	<?php header('refresh:1, url=emp_list.php');
	}
include('../lib/footer.php'); ?>