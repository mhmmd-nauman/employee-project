<?php
require_once dirname(__FILE__)."/lib/connect.php";
require_once dirname(__FILE__)."/lib/header_session.php";
require_once dirname(__FILE__)."/lib/classes/util_objects/util.php";
require_once dirname(__FILE__)."/lib/classes/util_objects/class.Email.php";
require_once dirname(__FILE__)."/lib/classes/business_objects/Queries.php";
require_once dirname(__FILE__)."/lib/classes/business_objects/Transaction.php";
require_once dirname(__FILE__)."/lib/classes/business_objects/Employee.php";

 
$objTransaction =new Transaction();
$objEmployee = new Employee();
$obj=new Queries();
$employee_list=$obj->select("alpp_emp","1 order by emp_name",array("*"));


$count = 0;
foreach($employee_list as $employee) {
    // check if the transaction allready exist on this date
    $trans_exist=$objTransaction->GetAllTrasanctions("alpp_emp.emp_id = ".$employee['emp_id']." and date(end_month_data) = '".date("Y-m-t")."' and trans_type = 'F'",array("alpp_emp.emp_id"));
    if(empty($trans_exist[0]['emp_id'])){

        $insert=$objTransaction->InsertTransaction(array(
            'emp_id'=>$employee['emp_id'],
            'end_month_data'=>date("Y-m-t h:i:s"),
            'amount'=>1.25,
            'trans_type'=>"F",
            'date'=> date("Y-m-d h:i:s"),
            'done_by'=>$_SESSION['session_admin_id'],
            'status'=>0
        ));

        $count++;
    }

}
$message_type="alert-success"; 
$message_text = "<strong>Success!</strong> $count enteries completed successfully.";
//header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance.php?emp_id='.$_REQUEST['emp_id']); 



?>