<?php 
include (dirname(__FILE__).'/../lib/include.php');
$obj=new Queries();
$notes_data=$obj->select("alpp_emp_notes","id = ".$_REQUEST['id'],array("*"));
//print_r($notes_data);
//echo dirname(__FILE__)."/../".$notes_data[0]['file'];
//exit;
header("Content-Type: ".$notes_data[0]['filetype']);
header("Content-Disposition: attachment; filename=".$notes_data[0]['filename']);
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
readfile(dirname(__FILE__)."/../".$notes_data[0]['file']);
//exit();
?>