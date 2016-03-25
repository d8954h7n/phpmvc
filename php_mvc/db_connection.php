<?php
function error_login($log){
	echo 'Log:'.$log.'<br />';
}

try{
	$config_set['db_connection']['dsn'] = 'mysql:dbname=school;host=127.0.0.1;charset=utf8';
	$config_set['db_connection']['user_name'] = 'Nicky';
	$config_set['db_connection']['password'] = 'a11111';

	$dbh = new PDO(
		$config_set['db_connection']['dsn'],
		$config_set['db_connection']['user_name'],
		$config_set['db_connection']['password'],
		array(
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			)
		);	
}
catch(PDOException $error){
	echo "Something Error!!<br />";
	error_login($error->getMessage());
}

date_default_timezone_set("Asia/Taipei");
session_start();
?>
