<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 

$objEmployee =new Employee();
$objTransaction =new Transaction();
$csv_data = array_map('str_getcsv', file('Soinb-03-08-2016.csv'));
//echo "<pre>";
//print_r($csv_data);
//echo "</pre>";
//exit();
foreach($csv_data as $row) {
    //echo "comming here";
    $emp_file = $row[0];
    $emp_name = $row[1];
    $emp_department = $row[2];
    $emp_cellnum = $row[3];
    $emp_current_contract = $row[4];
    //$emp_DIAS_VACACIONES_2016 = $row[4];
    //$emp_date = $row[5];
    //$emp_return = $row[6];
    $emp_SALDO_FERIADO_LEGAL = $row[6];
    $emp_SALDO_DIAS_PROGRESIVOS = $row[7];
    // Save details
    $exist=$objEmployee->GetAllEmployee("emp_file = ".$emp_file."",array("emp_file","emp_id"));
    //print_r($exist);
    if(empty($exist[0])){
        
        
        $inserted_emp = $objEmployee->InsertEmployee(array("emp_file"=>$emp_file,
                                            "emp_name"=>$emp_name,
                                            "emp_department"=>"Soinb",
                                            "emp_cellnum"=>$emp_cellnum,
                                            "emp_current_contract"=>date("Y-m-d",  strtotime($emp_current_contract)),
                                            "emp_status"=>0,
                                            "emp_type"=>1,
                                            "emp_password"=>"1234"
                                            ));
        $objTransaction->InsertTransaction(array("emp_id"=>$inserted_emp,
                "trans_type"=>"F",
                "amount"=>$emp_SALDO_FERIADO_LEGAL,
                "status"=>0,
                "date"=>date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                "end_month_data"=>"2016-08-03"
                ));
        $objTransaction->InsertTransaction(array("emp_id"=>$inserted_emp,
                "trans_type"=>"D",
                "amount"=>$emp_SALDO_DIAS_PROGRESIVOS,
                "status"=>0,
                "date"=>date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                "end_month_data"=>"2016-08-03"
                ));
    }else{
        
        
       
        $objEmployee->UpdateEmployee("emp_file = ".$emp_file, array(
                                            "emp_name"=>$emp_name,
                                            "emp_cellnum"=>$emp_cellnum,
                                            "emp_department"=>$emp_department,
                                            "emp_current_contract"=>date("Y-m-d",  strtotime($emp_current_contract)),
                                            
                                            ));
        
        $objTransaction->InsertTransaction(array("emp_id"=>$exist[0]['emp_id'],
                "trans_type"=>"F",
                "amount"=>$emp_SALDO_FERIADO_LEGAL,
                "status"=>0,
                "date"=>date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                "end_month_data"=>"2016-08-03"
                ));
        $objTransaction->InsertTransaction(array("emp_id"=>$exist[0]['emp_id'],
                "trans_type"=>"D",
                "amount"=>$emp_SALDO_DIAS_PROGRESIVOS,
                "status"=>0,
                "date"=>date("Y-m-d h:i:s"),
                'done_by'=>$_SESSION['session_admin_id'],
                "end_month_data"=>"2016-08-03"
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