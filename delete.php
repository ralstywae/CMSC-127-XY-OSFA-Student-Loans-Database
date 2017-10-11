<?php
	session_start();
	error_reporting(0);
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
    $db_database = 'osfa_db';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($db_database,$conn);
	
	$num=$_GET['id'];
	$type=$_GET['type'];

	mysql_query("DELETE FROM STUDENT where STUD_NUM = '$num' AND LOAN_TYPE = '$type'");
	
	header("Location: list.php?id=$type");
?>