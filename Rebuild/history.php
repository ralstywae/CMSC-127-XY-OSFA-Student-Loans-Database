<?php

	session_start();
	error_reporting(0);

	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'osfa_db';

	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);

	$num = $_GET['num'];
  	$name = $_GET['name'];
  	$type = $_GET['type'];
  	$out_bal = $_GET['out_bal'];
  	$acadyear = $_GET['acadyear'];
?>

<!DOCTYPE html>
<html>
<!-- Head -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<title>Home Page</title>
	</head>

	<!-- Body -->
	<body>
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

		<div class="py-5">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1><em>TRANSACTION HISTORY</em></h1>
						<h3><?php echo $num ?></h3>
						<h3><?php echo $name ?></h3>
						<br>
						<table class="table">
							<thead>
								<tr>
									<th>Loan Year</th>
									<th>Loan Semester</th>
									<th>Loan Type</th>
									<th>Amount Borrowed</th>
									<th>Amount Paid</th>
									<th>Date Paid</th>
									<th>O.R. No.</th>
									<th>Outstanding Balance</th>
									<th>Edit</th>
								</tr>
							</thead>
							<?php
								$MySearchQuery = "SELECT * FROM BAL_HIST WHERE BAL_HIST.STUD_NUM = '$num'";
         	 					$MyValues = $MyConnection -> query($MySearchQuery);

         	 					if (($MyValues -> num_rows) > 0)
         	 					{
         	 						while ($MyResults = $MyValues -> fetch_assoc())
         	 						{
         	 							echo '<tr>';
         	 							echo '<td>'.$MyResults['LOAN_YEAR'].'</td>';
										echo '<td>'.$MyResults['LOAN_SEM'].'</td>';
										echo '<td>'.$MyResults['LOAN_TYPE'].'</td>';
										echo '<td>&#8369;'.$MyResults['AMT_BORROWED'].'</td>';
										echo '<td>&#8369;'.$MyResults['AMT_PAID'].'</td>';
										echo '<td>'.$MyResults['DATE_PAID'].'</td>';
										echo '<td>'.$MyResults['OR_NUM'].'</td>';
										echo '<td>&#8369;'.$MyResults['OUT_BAL'].'</td>';
										echo '<td><a rel="facebox" href="edit_pay_info.php?paid='.$MyResults['AMT_PAID'].'&or_num='.$MyResults['OR_NUM'].'&bal='.$MyResults['OUT_BAL'].'&num='.$num.'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&loan_year='.$MyResults['LOAN_YEAR'].'&dpaid='.$MyResults['DATE_PAID'].'">Edit</a></td></tr>';
         	 						}
         	 					}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
        <div class = "text-md-center">
			<p>
				<a href="<?php echo 'list.php?type='.$type.''?>" title = "Let's go back!">&#8617; Go Back to the List</a>
			</p>
		</div>

		<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>