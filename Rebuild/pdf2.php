<?php
//error_reporting(0);
require('cellfit.php');
$d=date('d_m_Y');

$header=array('A.Y.', 'Sem', 'Loan Type', 'Stud Num', 'Student Name', 'Year', 'Course', 'Address', 'Contact Number', 'E-mail Address', 'Out Bal');
//Data loading
//*** Load MySQL Data ***//
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$db_database = 'osfa_db';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($db_database,$conn);
	$id = $_GET['id'];

		$query = mysql_query("SELECT LOAN_YEAR, LOAN_SEM, LOAN_TYPE, STUD_NUM, STUD_NAME, STUD_YEAR, STUD_COURSE, STUD_ADDRESS, STUD_CONTACT, STUD_EMAIL, OUT_BAL FROM STUDENT");
		$resultData = array();
		for ($i=0;$i<mysql_num_rows($query);$i++) {
			$result = mysql_fetch_array($query);
			array_push($resultData,$result);
		}
//************************//


$pdf=new FPDF_CellFit();
$pdf->AddPage("L");

	$pdf->SetFont('Helvetica','',14);
	$pdf->Cell(5);
	$pdf->Write(5, $id);
	$pdf->Ln();
	$pdf->Cell(5);
	$pdf->Write(5, 'Master List');
	$pdf->Ln();
	
	$pdf->Cell(5);
	$pdf->SetFontSize(8);
	$result=mysql_query("select date_format(now(), '%W, %M %d, %Y') as date");
	while( $row=mysql_fetch_array($result) )
	{
		$pdf->Write(5,$row['date']);
	}
	$pdf->Ln();

	$pdf->Ln(5);

$pdf->Ln(0);
//$pdf->BasicTable($header,$resultData);
$pdf->SetFillColor(255,255,255);
//$this->SetDrawColor(255, 0, 0);
$w=array(20,10,30,20,45,10,30,45,25,30,15);
	
	//Header
	$pdf->SetFont('Arial','B',9);
	for($i=0;$i<count($header);$i++)
		$pdf->CellFitScale($w[$i],8,$header[$i],1,0,'C',1);
	$pdf->Ln();
	
	//Data
	$pdf->SetFont('Arial','',9);
	foreach ($resultData as $eachResult) 
	{
		$pdf->CellFitScale(20,8,$eachResult["LOAN_YEAR"],1,0,'C',1);
		$pdf->CellFitScale(10,8,$eachResult["LOAN_SEM"],1, 0,'C',1);
		$pdf->CellFitScale(30,8,$eachResult["LOAN_TYPE"],1,0,'C',1);
		$pdf->CellFitScale(20,8,$eachResult["STUD_NUM"],1,0,'C',1);
		$pdf->CellFitScale(45,8,$eachResult["STUD_NAME"],1,0,'C',1);
		$pdf->CellFitScale(10,8,$eachResult["STUD_YEAR"],1,0,'C',1);
		$pdf->CellFitScale(30,8,$eachResult["STUD_COURSE"],1,0,'C',1);
		$pdf->CellFitScale(45,8,$eachResult["STUD_ADDRESS"],1,0,'C',1);
		$pdf->CellFitScale(25,8,$eachResult["STUD_CONTACT"],1,0,'C',1);
		$pdf->CellFitScale(30,8,$eachResult["STUD_EMAIL"],1,0,'C',1);
		$pdf->CellFitScale(15,8,$eachResult["OUT_BAL"],1,0,'C',1);
		$pdf->Ln();
		 	 	 	 	
	}
	ob_end_clean();
	$pdf->Output();
?>