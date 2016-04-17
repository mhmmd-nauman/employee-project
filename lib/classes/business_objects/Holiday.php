<?php  
    class Holiday extends util {
	
        
        function GetAllHoliday($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_holidays join  alpp_holidays_type on  alpp_holidays_type.id=alpp_holidays.type "
                    
                    . " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
        function GetAllHolidaytype($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_holidays_type  "
                    
                    . " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
	function UpdateHoliday($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_holidays",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
        function UpdateHolidaytype($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_holidays_type",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
	
        function InsertHolidaytype($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_holidays_type",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	function InsertHoliday($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_holidays",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	
        function DeleteHoliday($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_holidays","id = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
               
        function DeleteHolidaytype($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_holidays_type","id = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
		
}
 
?>