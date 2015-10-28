<?php  
    class Transaction extends util {
	
	function GetAllTrasanctions($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_transactions  JOIN alpp_emp ON alpp_emp.emp_id = alpp_transactions.emp_id WHERE $strWhere " or die("Error in the consult.." . mysqli_error($link));
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
	
	function UpdateTransaction($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_transactions",$where,$array);
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