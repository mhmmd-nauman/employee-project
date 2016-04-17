<?php 
include (dirname(__FILE__).'/../lib/include.php');
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee("1 order by emp_name",array("*"));
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

 // include "emp_reports.php";
  $flag = false;
  
  
  $data=array();
foreach($employee_list as $employee) { 
    $balance_detail= $objTransaction->GetEmpBalanceDetail($employee['emp_id']." and date <= '".$_REQUEST['date']." 12:60:60'");
    $balance=($balance_detail['I']-$balance_detail['leavesI'])+($balance_detail['D']-$balance_detail['leavesD']);
  
   
  $data[] = array("Ficha" =>$employee['emp_file'],
                   "Ficha" =>$employee['emp_file'],
                    "Nombre" => $employee['emp_name'],
                    "Department" => $employee['emp_department'],
                    "RUT" => $employee['emp_cellnum'],
                    "FECHA INGRESO" => date("m/d/Y",strtotime($employee['emp_current_contract'])),
                    "Today Balance" => number_format($balance, 2),
                    "FERIADO LEGAL" => number_format(($balance_detail['I']-$balance_detail['leavesI']), 2),
                    "DIAS PROGRESIVOS" => number_format(($balance_detail['D']-$balance_detail['leavesD']), 2)
                );
        $balance = 0;
} 
   
  
  
  

  
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;

?>