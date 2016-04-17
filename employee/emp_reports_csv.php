<?php 
include (dirname(__FILE__).'/../lib/include.php');
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=IndubalReport-".$_REQUEST['date'].".csv");
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

function outputCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
        fputcsv($output, $row); // here you can change delimiter/enclosure
    }
    fclose($output);
}



outputCSV(array(
    array(
        'Balance on', $_REQUEST['date'],'','','','','',''
    ),
    array(
        'Ficha', 
        'Nombre',
        'Department',
        'RUT', 
        'FECHA INGRESO',
        'Today Balance', 
        'FERIADO LEGAL',
        'DIAS PROGRESIVOS'
        )
    ));
foreach($employee_list as $employee) { 
    $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." and date <= '".$_REQUEST['date']." 12:60:60'");
    $balance=($balance_detail['I']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);
        outputCSV(array(
                array(
                    $employee['emp_file'], 
                    $employee['emp_name'], 
                    $employee['emp_department'],
                    $employee['emp_cellnum'],
                    date("m/d/Y",strtotime($employee['emp_current_contract'])),
                    number_format($balance, 2),
                    number_format(($balance_detail['I']-$balance_detail['leavesI']), 2),
                    number_format(($balance_detail['D']-$balance_detail['leavesD']), 2)
                    )
        )); 
        $balance = 0;
} 
?>