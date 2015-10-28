<?php
class util
{
    function util (){   }
	   
      function insertRecord($strTable, $arrValue){
         global $link;
             $strQuery = "	INSERT INTO $strTable (";

            reset($arrValue);
                    while(list ($strKey, $strVal) = each($arrValue))
                    {
                    $strQuery .= $strKey . ",";
                    }

            // remove last comma
            $strQuery = substr($strQuery, 0, strlen($strQuery) - 1);

            $strQuery .= ") VALUES (";

            reset($arrValue);
                    while(list ($strKey, $strVal) = each($arrValue))
                    {
                    $strQuery .= "'" . $this->fixString($strVal) . "',";
                    }

            // remove last comma
            $strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
            $strQuery .= ");" ;

//or die("Error in the consult.." . mysqli_error($link));
//              $strQuery."<br> execute query";
//             
//            echo $strQuery;
//
//             echo "<br/>";
            mysqli_query($link,$strQuery) ;

            $last_inserted_id = mysqli_insert_id($link);
            return ($last_inserted_id);


     }//endof function
     
	  function fixString($strString){
        
			$strString = trim($strString);
			$strString = str_replace("'", "''", $strString);
			$strString = str_replace("\'", "'", $strString);
			$strString = str_replace("", ",", $strString);
			$strString = str_replace("\\", "", $strString);
			$strString = str_replace("\"", "&#34;", $strString);
			$strString = str_replace('\"', '"', $strString);
			return $strString;

      }//endof function
	 
     
    function updateRecord($strTable, $strWhere, $arrValue){
        global $link;
	$strQuery = "	UPDATE $strTable SET ";
	
	reset($arrValue);
	
		while (list ($strKey, $strVal) = each ($arrValue))
		{
		$strQuery .= $strKey . "='" . $this->fixString($strVal) . "',";
		}
	
	// remove last comma
	$strQuery = substr($strQuery, 0, strlen($strQuery) - 1);
	
	 $strQuery .= " WHERE $strWhere;" or die("Error in the consult.." . mysqli_error($link));
	
	// execute query
//         echo" hhhhfhdhfdfdhdhhj";
//	 echo $strQuery;
//	 echo "<br />";
//	 echo"quary fail";
	  mysqli_query($link,$strQuery) ;
	 
     
	 return mysqli_affected_rows( $link);
	
	}



      function deleteRecord($strTable, $strCriteria){
	  global $link;

	 $strQuery = "DELETE FROM $strTable WHERE $strCriteria" or die("Error in the consult.." . mysqli_error($link));
	//echo"vcvcvcvc";		
	 mysqli_query($link,$strQuery) ;
	
         return mysqli_affected_rows($link);
  }//endof function



  
    function getSingleRow($tbl,$condition){
	global $link;
        $query="SELECT * FROM $tbl WHERE $condition" or die("Error in the consult.." . mysqli_error($link));
		
		$result=mysqli_query($link,$query);
		$row = mysqli_fetch_array($result);
		return $row;
    }


   function getMultipleRowAssoc($tbl,$condition){
   global $link;
            $query="SELECT * FROM $tbl WHERE $condition" or die("Error in the consult.." . mysqli_error($link));
			// "$query";
			$result=mysqli_query($link,$query)  ;
			//$row=$this->FetchObject($result);
			$arr = array();
			while($row=mysqli_fetch_assoc($result)){
				array_push($arr,$row);
			}
			return $arr;
    }
	
	
       function getMultipleRow($tbl,$condition){
        global $link;
            $query="SELECT * FROM $tbl WHERE $condition" or die("Error in the consult.." . mysqli_error($link));
			//echo "$query";
			$result=mysqli_query($link,$query);
			//$row=$this->FetchObject($result);
			$arr = array();
			while($row=mysqli_fetch_array($result)){
			array_push($arr,$row);
			}
			return $arr;
    }
	
	
	function FetchObject($result){
	global $link;
		$row=mysqli_fetch_object($result);
		return $row;
	}	 
	

        
function checkEmail($email){
  // checks proper syntax
  if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
  {
    return false;
  }     

}
 


}

?>