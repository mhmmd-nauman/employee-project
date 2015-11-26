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
	
        function GetEmpBalance($emp_id){
            global $link;
            	
            $sql="SELECT (Select sum(amount) from alpp_transactions where trans_type in ('C','I','M') AND emp_id = $emp_id and status = 0 ) as Credit  FROM alpp_transactions WHERE emp_id = $emp_id and status = 0 group by emp_id" ;
            $result=mysqli_query($link,$sql) ;
            $row=mysqli_fetch_array($result);
            // Transaction types are C, I , M and L (Need to check this query )some file missing at my end . live is showing more links
            // also get the leave data 
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