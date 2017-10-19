<?php
	session_start();
	error_reporting(0);
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
    $db_database = 'osfa_db';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($db_database,$conn);
	
	$num = $_GET['num'];
	$type = $_GET['type'];
	$outbal = $_GET['outbal'];

	if($outbal <= 0){
		echo"<script>alert('This student has an outstanding balance!');
		location = 'list.php?num=$num&type=$type';</script>";
		//header("Location: a_scho_list.php?id=$id&type=$type");
	}

	mysql_query("DELETE FROM STUDENT where STUD_NUM = '$num' AND LOAN_TYPE = '$type'");
	
	header("Location: list.php?type=$type");
?>