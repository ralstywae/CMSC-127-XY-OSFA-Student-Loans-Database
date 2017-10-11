<?php
	session_start();
	error_reporting(0);
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
    $db_database = 'osfa_db';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($db_database,$conn);
	
	$type = $_GET['type'];

	mysql_query("DELETE FROM LOAN_LIST where LOAN_TYPE = '$type'");
	
	header("Location: home.php?id=$type");
?>