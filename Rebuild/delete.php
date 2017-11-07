<?php
	session_start();
	error_reporting(0);
	
	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'osfa_db';

	//Start Connection
	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);

	$num = $_REQUEST['num'];
	$type = $_REQUEST['type'];
	$sem = $_REQUEST['sem'];
	$year = $_REQUEST['year'];
	
	mysqli_query($MyConnection, "DELETE FROM STUDENT where (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$year' AND STUDENT.LOAN_SEM = '$sem')");
	
	//mysqli_query($MyConnection, "DELETE FROM BAL_HIST where (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$year' AND STUDENT.LOAN_SEM = '$sem'");
	
	header("Location: list.php?type=$type");
?>