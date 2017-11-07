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

	$MySearchQuery = "SELECT * FROM STUDENT where (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$year' AND STUDENT.LOAN_SEM = '$sem')";
	
	$MyValues = $MyConnection -> query($MySearchQuery);

	if (($MyValues -> num_rows) > 0)
	{
		while ($MyResults = $MyValues -> fetch_assoc())
		{
			$sname = $MyResults['STUD_NAME'];
			$snum = $MyResults['STUD_NUM'];
			$sex =  $MyResults['STUD_SEX'];
			$address = $MyResults['STUD_ADDRESS'];
			$college =$MyResults['STUD_COLLEGE'];
			$syear = $MyResults['STUD_YEAR'];
			$course = $MyResults['STUD_COURSE'];
			$contact = $MyResults['STUD_CONTACT'];
			$email = $MyResults['STUD_EMAIL'];
			//$type = $MyResults['LOAN_TYPE'];
			$acadyear = $MyResults['LOAN_YEAR'];
			//$sem =  $MyResults['LOAN_SEM'];
			$amt_borrowed =  $MyResults['LOAN_AMOUNT'];
			$reason = $MyResults['REASON'];
			$out_bal = $MyResults['OUT_BAL'];
		}
	}

	if($_POST['save'])
	{
		$namt_paid = $_POST['amt_paid'];
		$ndate_paid = $_POST['date_paid'];
		$nor_num = $_POST['or_num'];
		$nreason = $_POST['reason'];

		if(!empty($namt_paid))
		{
			//$namt_paid = $namt_paid + $namt_paid;
			$out_bal = $out_bal - $namt_paid;
		}

		mysqli_query($MyConnection, "UPDATE STUDENT SET OUT_BAL = $out_bal where (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$year' AND STUDENT.LOAN_SEM = '$sem')");

		//mysql_query("UPDATE BAL_HIST SET OUT_BAL = 0 WHERE STUD_NUM = '$num' and LOAN_TYPE = '$type'");

		mysqli_query($MyConnection, "INSERT INTO BAL_HIST (LOAN_TYPE, AMT_BORROWED, AMT_PAID, DATE_PAID, OR_NUM, OUT_BAL, STUD_NUM, LOAN_YEAR, LOAN_SEM)
		VALUES ('$type', $amt_borrowed, $namt_paid, '$ndate_paid', $nor_num, $out_bal, '$snum', '$acadyear', '$sem')");

		echo "<script>alert('Paid Successfully!');
		location = 'history.php?num=$num&name=$sname&out_bal=$out_bal&type=$type';</script>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<title>Payment</title>
	</head>

	<body>
		<!-- Header -->
		<div class="gradient-overlay text-center bg-secondary p-1">
	    	<div class="container-fluid p-1">
	    		<div class="row">
	    			<div class="col-md-12">
	    				<div class="row">
	    					<div class="col-md-2">
	    						<img class="img-fluid d-block rounded-circle" src="uplogo.png" width="200" height="200">
	    					</div>

	    					<div class="col-md-10">
								<h1 class="text-white">
				                	<font color="#292b2c" class="text-white">
				                		<i>Office of the Student Financial Assistance<br></i>
				                	</font>
				              	</h1>

	          					<h3 class="text-white">
	            					<font color="#292b2c" class="text-white">
	            						<i>Office of the Director for Student Affairs<br></i>
	            					</font>
	          					</h3>

	          					<h4>
	          						<i class="text-center text-white">University of the Philippines - Baguio<br></i>
	          					</h4>
	          					<h4>
	          						<u class="text-center text-white">Student Loans<br></u>
	          					</h4>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>

		<!-- Navigation Bar -->
	    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
	    	<div class="container">

	    		<!-- Logo -->
	    		<a class="navbar-brand" href="index.php">
	    			<b>Home</b>
	    		</a>
	    		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    			<span class="navbar-toggler-icon"></span>
	    		</button>

	    		<!-- Links -->
	    		<div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
	    			<ul class="navbar-nav">
	    				<li class="nav-item">
	    					<a class="nav-link" href="search.php"><i class="fa d-inline fa-lg fa-search"></i>Search</a>
			          	</li>
	          		</ul>
	       		</div>
	      	</div>
		</nav>
		<!-- Payment Form-->
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Payment</em></h1>
		<div class="container">
			<div class="dropdown-divider"></div>
			<div class="dropdown-divider"></div>
		</div>
		<h5 class="text-center py-2">Loan Information</h5>
		<div class="container">
			<table class="table-hover table">
				<thead class="text-center">
					<tr>
						<th>Student Number</th>
						<th width="300 px">Student Name</th>
						<th>Year Level</th>
						<th width="300 px">Loan Type</th>
						<th>Academic Year</th>
						<th>Semester</th>
						<th>Loan Amount</th>
						<th>Outstanding Balance</th>
					</tr>
				</thead>
				<tr class="text-center">
					<td><?php echo $num; ?></td>
					<td><?php echo $sname; ?></td>
					<td><?php echo $syear; ?></td>
					<td><?php echo $type; ?></td>
					<td><?php echo $year; ?></td>
					<td><?php echo $sem; ?></td>
					<td>&#8369;<?php echo $amt_borrowed; ?></td>
					<td>&#8369;<?php echo $out_bal; ?></td>
				</tr>
			</table>
		</div>

		<div class="container">
			<div class="dropdown-divider"></div>
			<div class="dropdown-divider"></div>
		</div>
		<!-- Payment Form -->
		<h5 class="text-center py-2">Payment Information</h5>
		<form class="form-signin py-3" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
			<div class="container">
				<div class="form-group row">
					<div class="form-group col-xs-4 col-md-4 text-center">
						<label for="example-number-input" class="control-label">Amount Paid</label>
						<input class="form-control" name="amt_paid" required placeholder="Max Amount: &#8369;<?php echo $out_bal; ?>">
					</div>
					<div class="form-group col-xs-4 col-md-4 text-center">
						<label for="date" class="control-label text-center">Date of Payment</label><br>
						<div class="form-inline">
							<input class="form-control col-10" id = "date" name="date_paid" required placeholder="YYYY-MM-DD" type="text">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div> 
						</div>
					</div>
					<div class="form-group col-xs-4 col-md-4 text-center">
						<label for="example-number-input" class="control-label text-center">O.R. No.</label>
						<input class="form-control" name="or_num" required placeholder="7-Digit Number"> 
					</div>
				</div>
			</div>
			<div class="row py-2">
				<div class="col-md-12">
					<div class="container">
						<div class="row">
							<div class="col-md-12 center">
								<center>
									<button class="btn" type="submit" name="save" value="save" id="button1" style="background-color: #C0C0C0; width: 150px; height: 60px; padding: 5px">
										<span>Save</span>
									</button>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!-- Footer -->
		<div class = "text-md-center">
			<p>
				<a href = "<?php 
					echo 'list.php?type='.$type.''
				?>"
				title = "Let's go back!">&#8617; Go Back to the List</a>
			</p>
		</div>

		<!-- Scripts and Additional Styles-->
		<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="scripts/bootstrap-datepicker.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap-datepicker3.css"/>
		<script>
			$(document).ready(function()
			{
				var date_input=$('input[name="date_paid"]'); //our date input has the name "date"
				var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
				date_input.datepicker({
					format: 'yyyy-mm-dd',
					container: container,
					todayHighlight: true,
					autoclose: true,
				})
			})
		</script>
		<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script type="text/javascript" src="scripts/formden.js"></script>
		<link rel="stylesheet" href="css/bootstrap-iso.css" />
		<style>
			.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form
			{
				font-family: Arial, Helvetica, sans-serif;
				color: black;
			}

			.bootstrap-iso form button, .bootstrap-iso form button:hover
			{
				color: white !important;
			}

			.asteriskField
			{
				color: red;
			}
		</style>
	</body>
</html>