<?php  
    class AlertSystem extends util {
        function GetAllAlertSystem($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_alert_systems ". " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            
            return $arr; 
        }
        
        function UpdateAlertSystem($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_alert_systems",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
        	
	
        function InsertAlertSystem($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_alert_systems",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	
	
        function DeleteAlertSystem($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_alert_systems","id = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
		
}
?>