<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 

$objEmployee =new Employee();
$objTransaction =new Transaction();
$csv_data = array_map('str_getcsv', file('Soinb.csv'));
//echo "<pre>";
//print_r($csv_data);
//echo "</pre>";
foreach($csv_data as $row) {
    //echo "comming here";
    $emp_file = $row[0];
    $emp_name = $row[1];
    $emp_cellnum = $row[2];
    $emp_current_contract = $row[3];
    $emp_count = $row[4];
    $emp_balance = $row[5];
    // Save details
    $exist=$objEmployee->GetAllEmployee("emp_file = ".$emp_file,array("emp_file"));
    if(empty($exist[0])){
        $Date=explode("/", $emp_current_contract);
        $day = $Date[0];
        $month = $Date[1];
        $year = $Date[2];
        $emp_current_contract = "$year-$month-$day";
        /*
        $Date=explode("/", $emp_first_contract);
        $day = $Date[0];
        $month = $Date[1];
        $year = $Date[2];
        $emp_first_contract = "$year-$month-$day";
        ALTER TABLE `alpp_emp` CHANGE `emp_salary` `emp_count` INT(11) NOT NULL;
        */
        $inserted_emp = $objEmployee->InsertEmployee(array("emp_file"=>$emp_file,
                                            "emp_name"=>$emp_name,
                                            "emp_department"=>"Soinb",
                                            "emp_cellnum"=>$emp_cellnum,
                                            "emp_current_contract"=>date("Y-m-d",  strtotime($emp_current_contract)),
                                           // "emp_first_contract"=>date("Y-m-d",  strtotime($emp_first_contract)),
                                            "emp_count"=>$emp_count,
                                            "emp_password"=>"1234"
                                            ));
        $objTransaction->InsertTransaction(array("emp_id"=>$inserted_emp,
                "trans_type"=>"C",
                "amount"=>$emp_balance,
                "status"=>0,
                "date"=>date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                "end_month_data"=>"2015-10-31"
                ));
    }else{
        $Date=explode("/", $emp_current_contract);
        $day = $Date[0];
        $month = $Date[1];
        $year = $Date[2];
        $emp_current_contract = "$year-$month-$day";
        /*
        $Date=explode("/", $emp_first_contract);
        $day = $Date[0];
        $month = $Date[1];
        $year = $Date[2];
        $emp_first_contract = "$year-$month-$day";
        */
       
        $objEmployee->UpdateEmployee("emp_file = ".$emp_file, array(
                                            "emp_name"=>$emp_name,
                                            "emp_cellnum"=>$emp_cellnum,
                                            "emp_current_contract"=>date("Y-m-d",  strtotime($emp_current_contract)),
                                            //"emp_first_contract"=>date("Y-m-d",  strtotime($emp_first_contract)),
                                            "emp_count"=>$emp_count,
                                            "emp_password"=>"1234"
                                            ));
    }
    
}
?>
<div class="widget-body">
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Data Imported!.
                            </div>
         </div>