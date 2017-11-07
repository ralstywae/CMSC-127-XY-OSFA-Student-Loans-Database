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

	if($_POST['save'])
	{
		$nsname = $_POST['sname'];
		$nadd = $_POST['address'];
		$nsex = $_POST['sex'];
		$ncollege = $_POST['college'];
		$nyear = $_POST['year'];
		$ncourse = $_POST['course'];
		$ncontact = $_POST['contact'];
		$nemail = $_POST['email'];
		$nsnum = $_POST['snum'];

		$ntype = $type;
		$nacadyr = $_POST['acadyr'];
		$nsem = $_POST['sem'];
		$namt_borrowed = $_POST['amt_borrowed'];
		$nreason = $_POST['reason'];

		mysqli_query($MyConnection, "INSERT INTO STUDENT (STUD_NAME, STUD_ADDRESS, STUD_SEX, STUD_COLLEGE, STUD_YEAR, STUD_COURSE, STUD_CONTACT, STUD_EMAIL, STUD_NUM, LOAN_TYPE, LOAN_YEAR, LOAN_SEM, LOAN_AMOUNT, OUT_BAL, REASON) VALUES ('$nsname','$nadd', '$nsex', '$ncollege', '$nyear', '$ncourse', '$ncontact', '$nemail', '$nsnum', '$ntype', '$nacadyr', '$nsem', $namt_borrowed, $namt_borrowed,'$nreason');");

		mysqli_query($MyConnection, "INSERT INTO BAL_HIST (LOAN_TYPE, AMT_BORROWED, OUT_BAL, AMT_PAID, DATE_PAID, OR_NUM, STUD_NUM, LOAN_YEAR, LOAN_SEM) VALUES ('$ntype', $namt_borrowed, $namt_borrowed, 0, NULL, NULL, '$nsnum', '$nacadyr', '$nsem');");

		echo "<script>alert('Added Successfully!');
			location = 'list.php?type=$type';</script>";
	}
?>

<!DOCTYPE html>
<html>
	<!-- Head -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<title>Add Student Information</title>
	</head>

	<!-- Body -->
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

    	<!-- Addition Form -->
    	<div class="py-5">
  			<div class="container">
    			<div class="row">
      				<div class="col-md-12">
        				<?php echo '<h1>'.$type.'</h1>'; ?>
        				<br>
      				</div>
    			</div>
   				<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
   					<h5 class="text-center py-2">Year of Application</h5>
      				<div class="container">
      					<div class="row">
      						<label for="example-search-input" class="col-2 col-form-label">Academic Year</label>
      						<div class="col">
								<input class="form-control" name="acadyr" required placeholder="XXXX-XXXX" pattern="\d{4}[-]\d{4}">
							</div>
							<label for="example-number-input" class="py-2 form-label">Semester</label>
							<div class="col">
								<select name="sem" class = "form-control">
									<option value="1ST">1st Semester</option>
									<option value="2ND">2nd Semester</option>
									<option value="MID">Summer/Midyear</option>
								</select>
							</div>
      					</div>
      				</div>
      				<div class="dropdown-divider"></div>
      				<div class="dropdown-divider"></div>
      				<h5 class="text-center py-2">Student Credentials</h5>
					<div class="container">
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Student Name</label>
							<div class="col-10 col-md-6">
								<input class="form-control" name="sname" required placeholder="Last Name, First Name M.I." pattern="^.{1,100}$">
							</div>

							<label for="example-number-input" class="py-2 form-label">Student Number</label>
							<div class="col">
								<input class="form-control" name="snum" required pattern ="\d{4}[-]\d{5}" placeholder="XXXX-XXXXX">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Course</label>
							<div class="col-10 col-md-6">
								<input class="form-control" name="course" required placeholder="Undergraduate Degree/Graduate Degree" pattern="^.{1,35}$">
							</div>
							<label for="example-number-input" class="py-2 col-form-label">College</label>
							<div class="col">
								<select name="college" class="form-control">
									<option value="CAC">CAC</option>
									<option value="CS">CS</option>
									<option value="CSS">CSS</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Mailing/Provincial Address</label>
							<div class="col-10 col-md-6">
								<input class="form-control" name="address" required placeholder="Complete Address" pattern="^.{1,100}$">
							</div>
							<label for="example-search-input" class="form-label py-2">Sex</label>
							<div class="px-2">
								<select name="sex" class="form-control">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<label for="example-number-input" class="form-label py-2">Year</label>
							<div class="px-2">
								<select name="year" class = "form-control">
									<option value = "1ST">1st Year</option>
									<option value = "2ND">2nd Year</option>
									<option value = "3RD">3rd Year</option>
									<option value = "4TH">4th Year</option>
									<option value = "OTHERS">Others</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
						<label for="example-number-input" class="col-2 col-form-label">E-mail Address</label>
						<div class="col-10 col-md-10">
							<input class="form-control" type="email" id="email-input" name="email" required placeholder="example@somesite.com"> </div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Telephone/Cellphone Number</label>
							<div class="col-10 col-md-10">
								<input class="form-control" name="contact" required pattern = "^(0\d{10})$|^(\d{7})$" placeholder="7-Digit Landline/11-Digit Cellular">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Amount Borrowed</label>
							<div class="col-10 col-md-10">
								<?php
									if($type == "IM Student Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" required pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-8][0-9]{3}|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9]|1[0-9]{4}|20000)$" placeholder="Max Amount: &#8369;20000">';
									}

									else if ($type == "Radwill Loan" || $type == "Safe Cash Loan" || $type == "UPAASV Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" required pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-4][0-9]{3}|5000)$" placeholder="Max Amount: &#8369;5000">';
									}


									else if ($type == "Short Term Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" required pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|1[0-4][0-9]{2}|1500)$" placeholder="Max Amount: &#8369;1500">';
									}

									else if ($type == "Tuition Fee Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" required pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-8][0-9]{3}|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9]|10000)$" placeholder="Max Amount: &#8369;10000">';
									}
								?>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Reason/s</label>
        					<div class="col-10">
        						<textarea class="form-control" id="exampleTextarea" rows="3" name="reason" required pattern = "^.{1,200}$" placeholder="200 Characters Only"></textarea>
        					</div>
        				</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="container">
								<div class="row">
									<div class="col-md-12 center">
										<center>
											<button class="btn" type="submit" name="save" value="save" id="button1" style="background-color: #C0C0C0; width: 150px; height: 60px; padding: 5px"><span>Save</span>
											</button>
										</center>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Footer -->
		<div class = "text-md-center">
			<p>
				<a href = "<?php 
					echo 'list.php?type='.$type.''
				?>"
				title = "Let's go back!">&#8617 Go Back to the List</a>
			</p>
		</div>

		<!-- Scripts -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>
</html>