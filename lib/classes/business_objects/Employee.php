<?php  
    class Employee extends util {
	
        
        function GetAllEmployee($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_emp  "
                    
                    . " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
	
	function UpdateEmployee($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_emp",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
	
        function InsertEmployee($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_emp",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	
        function DeleteEmployee($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_emp","emp_id = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
               
		
}
 
?>