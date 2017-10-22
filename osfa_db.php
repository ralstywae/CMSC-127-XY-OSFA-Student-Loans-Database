<?php 
	$server = "localhost:3306";
	$user = "root";
	$pass = "";
	$db = "osfa_db";
	$conn = mysqli_connect($server, $user, $pass, $db);
	if(!$conn) die(mysqli_error($conn));

	$query = "CREATE TABLE STUDENT
	(
		STUD_NAME VARCHAR(100) NOT NULL,
		STUD_ADDRESS VARCHAR(50) NOT NULL,
		STUD_SEX VARCHAR(10) NOT NULL,
		STUD_COLLEGE VARCHAR(10) NOT NULL,
		STUD_YEAR NUMERIC(1) NOT NULL,
		STUD_COURSE VARCHAR(35) NOT NULL,
		STUD_CONTACT NUMERIC(10),
		STUD_EMAIL VARCHAR(50),
		STUD_NUM VARCHAR(10) NOT NULL,
		LOAN_TYPE VARCHAR(50) NOT NULL,
		LOAN_YEAR VARCHAR(10) NOT NULL,
		LOAN_SEM VARCHAR(3) NOT NULL,
		LOAN_AMOUNT NUMERIC(5) NOT NULL,
		REASON VARCHAR(200) NOT NULL
	)";
	mysqli_query($conn, $query);

	$query = "CREATE TABLE LOAN_LIST(
		LOAN_TYPE VARCHAR(50) NOT NULL,
		LOAN_MAX NUMERIC(5) NOT NULL,
		LOAN_RQMT VARCHAR(200) NOT NULL,
		PRIMARY KEY(LOAN_TYPE)
	)";
	mysqli_query($conn, $query);
	$query = "INSERT INTO LOAN_LIST VALUES
		('IM Student Loan', 20000, 'Graduate Student'),
		('Safe Cash Loan', 5000, 'Accomplished Loan Form, Photocopied Form 5 &amp; UP ID'),
		('Tuition Fee Loan', 10000, 'Bonafide Student of UP Baguio without any outstanding amount &amp; \nPhotocopy of ID with signature of co-debtor and student'),
		('Short Term Loan', 1500, 'Accomplished Loan Form, One 1 x 1 Picture, Photocopied Form 5 &amp; UP ID'),
		('Radwill Loan', 5000, 'Accomplished Loan Form, Photocopied Form 5 &amp; UP ID'),
		('UPAASV Loan', 5000, 'Accomplished Loan Form, Photocopied Form 5 &amp; UP ID')";
	mysqli_query($conn, $query);

	$query = "CREATE TABLE BAL_HIST(
		LOAN_TYPE VARCHAR(50) NOT NULL,
		AMT_BORROWED NUMERIC(8) NOT NULL,
		OUT_BAL NUMERIC(8),
		AMT_PAID NUMERIC(8),
		DATE_PAID DATE,
		OR_NUM NUMERIC(10),
		STUD_NUM VARCHAR(10) NOT NULL
	)";
	mysqli_query($conn, $query);
?>