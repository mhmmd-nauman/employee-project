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

foreach($employee_list as $employee) {  
    $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']);
    $inc=0;
    $css_string = "";
    $next_date =  get_next_incrementday(date("d-m-Y",strtotime($employee['emp_current_contract'])));

    if(date("Y",strtotime($next_date)) == date("Y",strtotime("+1 Year")) &&  date("m",strtotime($next_date)) == date("m")){
                 
        $d1 = new DateTime(date("Y-m-d"));
        $d2 = new DateTime(date("Y-m-d",strtotime($employee['emp_current_contract'])));

        $diff = $d2->diff($d1);
        $effective_year = $diff->y ;
        if($effective_year >= 13){
            $trans_exist=$objTransaction->GetAllTrasanctions("alpp_emp.emp_id = ".$employee['emp_id']." and month(end_month_data) = '".date("m")."' and year(end_month_data) = '".date("Y")."' and trans_type = 'D'",array("alpp_transactions.ID"));
            $inc = 1;
            $css_string = "class=\" danger\"";
            if(empty($trans_exist[0]['ID'])){
               //
                $emp_data[$employee['emp_id']][] = $employee['emp_id'];
                $emp_data[$employee['emp_id']][] = $employee['emp_file'];
                $emp_data[$employee['emp_id']][] = $employee['emp_department'];
                $emp_data[$employee['emp_id']][] = $employee['emp_name'];
            }
        }
    
        //$emp_data[$employee['emp_id']]['emp_id'] = $employee['emp_id'];
        //$emp_data[$employee['emp_id']]['emp_file'] = $employee['emp_file'];
        //$emp_data[$employee['emp_id']]['emp_department'] = $employee['emp_department'];
        //$emp_data[$employee['emp_id']]['emp_name'] = $employee['emp_name'];
           
    }
}
//echo "<pre>";
//print_r($emp_data);
//echo "</pre>";
$objEmail = new Email();
$Content .= "Hi,<br><br>You have new Dias Progresivos balance alerts for the following employees.";
foreach($emp_data as $emp){
    $Content .= "<br>Employee Name: ".$emp['emp_name'];
    $Content .= "<br>Employee Ficha: ".$emp['emp_file'];
    $Content .= "<br>Employee Department: ".$emp['emp_department'];
    
}
if(count($emp_data)){
    $objEmail->To = 'fsf@indubal.com';        
    $objEmail->From = "Admin <nauman@indubalfriction.com>";
    $objEmail->TextOnly = false;
    $objEmail->Subject = "Dias Progresivos Balance Alerts ";

    $Content .="<br><br><br>Regards<br><br> Admin Team";
    $objEmail->Content = $Content;
    $objEmail->Send();
}
function get_next_incrementday($birthday) {
    $date = new DateTime($birthday);
    $date->modify('+' . date('Y') - $date->format('Y') . ' years');
    if($date < new DateTime()) {
        $date->modify('+1 year');
    }

    return $date->format('d-m-Y');
}
?>