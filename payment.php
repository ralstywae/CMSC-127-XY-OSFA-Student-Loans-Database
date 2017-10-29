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
			$year = $MyResults['STUD_YEAR'];
			$course = $MyResults['STUD_COURSE'];
			$contact = $MyResults['STUD_CONTACT'];
			$email = $MyResults['STUD_EMAIL'];
			$type = $MyResults['LOAN_TYPE'];
			$year = $MyResults['LOAN_YEAR'];
			$sem =  $MyResults['LOAN_SEM'];
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
		VALUES ('$type', $amt_borrowed, $namt_paid, '$ndate_paid', $nor_num, $out_bal, '$snum', '$year', '$sem')");

		echo "<script>alert('Added Successfully!');
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


						<li class="nav-item">
							<a class="nav-link" href="<?php echo 'add.php?num='.$num.''?>"><i class="fa d-inline fa-lg fa-user-circle-o"></i>
								&nbsp;Add Student Loan
							</a>
						</li>
	          		</ul>
	       		</div>
	      	</div>
    	</nav>


<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">

<div class="container">
	<center><?php echo '<h1 style = "font-size: 60px"> <br>PAYMENT </h1><br>'; ?></center>
	<table style = "margin-left: 50px; " class="table-hover table-bordered text-center">
		<tr>
			<td width = 100><?php echo $num.'<br>'; ?></td>
			<td width = 300><?php echo $sname. '<br>';?></td>
			<td width = 150><?php echo $year.'<br>';?></td>
			<td width = 250><?php echo $course.'<br>';?></td>
			<td width = 100><?php echo $contact.'<br>';?></td>
			<td width = 250><?php echo $email.'<br>';?></td>
		</tr>
	</table>
	</br>
</div>

</br>

<div style="width: 95%; height: 200px;" id="1">
</br>
<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">

<center>
<div class="form-group row">
	<label for="example-number-input" class="col-2 col-form-label">Amount Paid</label>
		<div class="col-10 col-md-2">
			<input class="form-control" id="snumber-input" name="amt_paid" required>
		</div>

      <label class="col-form-label col-2" for="date">Date Paid</label>
       <div class="input-group col-10 col-md-2">
        <div class="input-group-addon">
         <i class="fa fa-calendar">
         </i>
        </div>
        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text">
       </div>


<!-- Extra JavaScript/CSS added manually in "Settings" tab -->
<!-- Include jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>

	<label for="example-number-input" class="col-2 col-form-label">O.R. No.</label>
		<div class="col-10 col-md-2">
			<input class="form-control" id="snumber-input" name="or_num" required> 
		</div>
</div>
	<br>
	<button class="btn" type="submit" name="save" value="save" id="button1" style="background-color: #C0C0C0; width: 150px; height: 60px; padding: 5px">
		<span>Save</span>
	</button>
</center>

	<!-- Scripts -->
	<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	 <!--formden.js communicates with FormDen server to validate fields and submit via AJAX -->
<script type="text/javascript" src="https://formden.com/static/cdn/formden.js"></script>

<!-- Special version of Bootstrap that is isolated to content wrapped in .bootstrap-iso -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!--Font Awesome (added because you use icons in your prepend/append)-->
<link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />

<!-- Inline CSS based on choices in "Settings" tab -->
<style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>


</body>
</html>