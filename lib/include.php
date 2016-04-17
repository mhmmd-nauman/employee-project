<?php
error_reporting("all");
#@session_start();
# User will be logged in for 5 hours if the user is ideal

#@ini_set('session.gc_maxlifetime', 3*60*60);
#$sessionCookieExpireTime=3*60*60;
#@session_set_cookie_params($sessionCookieExpireTime);

////ini_set('session.gc_maxlifetime', 7200);
//session_set_cookie_params(7200);

ob_start();
session_start();
 

                
require_once dirname(__FILE__)."/../lib/connect.php";
require_once dirname(__FILE__)."/../lib/header_session.php";
require_once dirname(__FILE__)."/../lib/classes/util_objects/util.php";
require_once dirname(__FILE__)."/../lib/classes/business_objects/Queries.php";
require_once dirname(__FILE__)."/../lib/classes/business_objects/Transaction.php";
require_once dirname(__FILE__)."/../lib/classes/business_objects/Employee.php";
require_once dirname(__FILE__)."/../lib/classes/business_objects/Holiday.php";


?>
