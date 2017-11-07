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
	
	$type = $_GET['type'];

	mysqli_query($MyConnection, "DELETE FROM LOAN_LIST WHERE LOAN_TYPE = '$type'");

	header("Location: index.php?type=$type");
?>