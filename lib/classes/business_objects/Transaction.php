<?php  
    class Transaction extends util {
	
        function GetBalanceDetail($strWhere){
            global $link;
             $sql="SELECT distinct(alpp_transactions.id) as id,
                   end_month_data as entered_on_date,
                   trans_type,
                   alpp_transactions.emp_id as emp_id, 
                   alpp_transactions.amount as days, 
                   `date` as entry_date,
                   '0' as leave_type,
                   status
                   FROM alpp_transactions 
                   JOIN alpp_emp ON alpp_emp.emp_id = alpp_transactions.emp_id 
                   WHERE status = 0 AND  $strWhere  
                   UNION ALL
                   SELECT 
                   distinct(alpp_leave.leave_id) as id, 
                   leave_datetime as entered_on_date,
                   'L' as trans_type,
                   leave_emp_id as emp_id, 
                   leave_duration as days, 
                   leave_datetime as entry_date,
                   leave_balance_type as leave_type,
                   leave_approval as status 
                   FROM alpp_transactions 
                   JOIN alpp_leave ON alpp_leave.leave_emp_id = alpp_transactions.emp_id 
                   WHERE leave_approval = 2 and  $strWhere "; 
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
        function GetAllTrasanctions($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_transactions  "
                    . "JOIN alpp_emp ON alpp_emp.emp_id = alpp_transactions.emp_id "
                    . ""
                    . " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
	
        function GetEmpBalanceDetail ($emp_id){
            global $link;
            	
            $sqld="Select sum(amount) as D from alpp_transactions where trans_type ='D' AND emp_id = $emp_id and status = 0" ;
            $resultd=mysqli_query($link,$sqld) ;
            $rowd=mysqli_fetch_array($resultd);
            $arr['D'] = $rowd['D'];
            
            $sqli="Select sum(amount) as I from alpp_transactions where trans_type ='I' AND emp_id = $emp_id and status = 0" ;
            $resulti=mysqli_query($link,$sqli) ;
            $rowi=mysqli_fetch_array($resulti);
            $arr['I'] = $rowi['I'];
            
            $emp_id=  str_replace("date", "leave_datetime", $emp_id);// this is for emp_reports.php page only , it will not run for anyother page
            
            $sql_leaved="SELECT sum(leave_duration) as leavesD  FROM alpp_leave WHERE leave_emp_id = $emp_id and leave_balance_type='D' and leave_approval = 2 " ;
            $result_leaved=mysqli_query($link,$sql_leaved) ;
            $row_leaved=mysqli_fetch_array($result_leaved);
            $arr['leavesD'] = $row_leaved['leavesD'];
            
           $sql_leavei="SELECT sum(leave_duration) as leavesI  FROM alpp_leave WHERE leave_emp_id = $emp_id and leave_balance_type='I' and leave_approval = 2 " ;
            $result_leavei=mysqli_query($link,$sql_leavei) ;
            $row_leavei=mysqli_fetch_array($result_leavei);
            $arr['leavesI'] = $row_leavei['leavesI'];

            //log_error($encoded_query);
            return $arr; 
        }
        function GetEmpLeaveBalanceDetail ($emp_id,$first_day_this_month,$last_day_this_month){
            global $link;
            $first_day_this_month  = $first_day_this_month." 00:00:00";
            $last_day_this_month  = $last_day_this_month." 12:00:00";   
            $Dsum=$Isum=0.00;
       
         $sql_leaved="SELECT *  FROM alpp_leave WHERE leave_emp_id = $emp_id  "
            . "and (( leave_duration_from >= '".$first_day_this_month."' && leave_duration_from <= '".$last_day_this_month."' ) "
            . "|| (leave_duration_to <= '".$last_day_this_month."' && leave_duration_to >= '".$first_day_this_month."' ))"
            . " and leave_balance_type='D' and leave_approval = 2 " ;
            $result_leaved=mysqli_query($link,$sql_leaved) ;
            while($row_leaved=mysqli_fetch_array($result_leaved))
            {            
                $arr1['start'] = $row_leaved['leave_duration_from'];
                $arr1['end'] = $row_leaved['leave_duration_to'];

                if($first_day_this_month > $arr1['start'])
                {
                    $date1 = new DateTime($first_day_this_month);
                    $date2 = new DateTime($arr1['end']);
                    //$diff = $date2->diff($date1)->format("%a");
                    //echo "<br><br>Starting of first IF".$first_day_this_month."<br><br>";
                    //echo "<br><br>Ending".$arr1['end']."<br><br>";
                    include "days_calculation.php";
                    $Dsum+= $final_days;
                }
                else if($last_day_this_month < $arr1['end'])
                {
                    $date1 = new DateTime($arr1['start']);
                    $date2 = new DateTime($last_day_this_month);
                    //$diff = $date2->diff($date1)->format("%a");
                    //echo "<br><br>Starting of Second IF".$arr1['start']."<br><br>";
                    //echo "<br>Ending of Secong IF".$last_day_this_month ."<br><br>";
                    include "days_calculation.php";
                    $Dsum+=$final_days;
                }
                else
                {
                      $Dsum+= $row_leaved['leave_duration'];
                }
            }
            $arr['leavesD'] = $Dsum;
         
            $sql_leavei="SELECT *  FROM alpp_leave WHERE leave_emp_id = $emp_id  "
            . "and (( leave_duration_from >= '".$first_day_this_month."' && leave_duration_from <= '".$last_day_this_month."' ) "
            . "|| (leave_duration_to <= '".$last_day_this_month."' && leave_duration_to >= '".$first_day_this_month."' ))"
             . " and leave_balance_type='I' and leave_approval = 2 " ;
            $result_leavei=mysqli_query($link,$sql_leavei) ;
            while($row_leavei=mysqli_fetch_array($result_leavei))
            {            
                $arr2['start'] = $row_leavei['leave_duration_from'];
                $arr2['end'] = $row_leavei['leave_duration_to'];

                if($first_day_this_month > $arr2['start'])
                {
                    $date1 = new DateTime($first_day_this_month);
                    $date2 = new DateTime($arr1['end']);
                     include "days_calculation.php";
                    $Isum+= $final_days;
                }
                else if($last_day_this_month < $arr2['end'])
                {
                    $date1 = new DateTime($arr1['start']);
                    $date2 = new DateTime($last_day_this_month);
                     include "days_calculation.php";
                    $Isum+=$final_days;
                }
                else
                {
                     $Isum+= $row_leavei['leave_duration'];
                }
            }
                $arr['leavesI'] = $Isum;
                return $arr; 
        }
        function GetEmpBalance($emp_id){
            global $link;
            	
            $sql="SELECT (Select sum(amount) from alpp_transactions where trans_type in ('C','I','M','D') AND emp_id = $emp_id and status = 0 ) as Credit  FROM alpp_transactions WHERE emp_id = $emp_id and status = 0 group by emp_id" ;
            $result=mysqli_query($link,$sql) ;
            $row=mysqli_fetch_array($result);
            
            $sql_leave="SELECT sum(leave_duration) as leaves  FROM alpp_leave WHERE leave_emp_id = $emp_id and leave_approval = 2 group by leave_emp_id" ;
            $result_leave=mysqli_query($link,$sql_leave) ;
            $row_leave=mysqli_fetch_array($result_leave);
            
            //log_error($encoded_query);
            return ((float)$row['Credit'] - (float)$row_leave['leaves']); 
        }

        function UpdateTransaction($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_transactions",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
	function UpdateTransactionByEmployee($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_transactions join alpp_emp on alpp_emp.emp_id=alpp_transactions.emp_id",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
	
        function InsertTransaction($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_transactions",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	
        function DeleteTransantion($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_transactions","ID = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
               
		
}
 
?>