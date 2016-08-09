<?php  
    class Permission extends util {
	
        
        function GetAllPermissions($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_permissions ". " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
        function GetAllGroupPermissions($strWhere,$fieldaArray=""){
            global $link;
            reset($fieldaArray);
            foreach ($fieldaArray as $field){
                $strFields .=  "".$field . " ,";
            } 
            //remove the last comma
            $strFields = substr($strFields, 0, strlen($strFields) - 1);	
            $sql="SELECT $strFields FROM alpp_user_permissions ". " WHERE $strWhere " ;
            $result=mysqli_query($link,$sql) ;
            while($row=mysqli_fetch_array($result)){
                $arr[] = $row;
            }
            //log_error($encoded_query);
            return $arr; 
        }
        function UpdateGroupPermission($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_user_permissions",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}
	function UpdatePermission($where,$array){
            if($array){
                $updated_id = util::updateRecord("alpp_permissions",$where,$array);
                return $updated_id;
            } else {
                return 0;
            }
	}	
        	
	
        function InsertPermission($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_permissions",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	function InsertUserPermission($array){
            if($array){
                $inserted_id = util::insertRecord("alpp_user_permissions",$array);
                return $inserted_id;
            } else {
                return 0;
            }
	}
	
        function DeletePermission($ID){
            if($ID){
                    $deleted_id = util::deleteRecord("alpp_permissions","id = $ID");
                    return $deleted_id;
            } else {
                    return 0;
            }
        }
		
}
 
?>