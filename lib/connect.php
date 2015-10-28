<?php

	if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
	$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => 'root',
		"password" => 'vertrigo',
		"database" => str_replace('"',"", "db_emp")
	);
	} else {
		$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => str_replace('"',"","online_username"),
		"password" => str_replace('"',"","online_password"),
		"database" => str_replace('"',"", "online_db_af")
	);
	}
	
	if(empty($databaseConfig['password']))$databaseConfig['password']="";
	$link  = mysqli_connect($databaseConfig['server'],trim($databaseConfig['username']),trim($databaseConfig['password']),trim($databaseConfig['database']));
       if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}
        else
            {
           //echo "connected";
        }
	
?>
