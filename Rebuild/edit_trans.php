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

	$num = $_GET['num'];
	$type = $_GET['type'];
	$semSaved = $_GET['sem'];
	$acadyear = $_GET['year'];

	$MySearchQuery = "SELECT * FROM STUDENT WHERE (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$acadyear' AND STUDENT.LOAN_SEM = '$semSaved');";
	$MyValues = $MyConnection -> query($MySearchQuery);

	if (($MyValues -> num_rows) > 0)
	{
		while ($MyResults = $MyValues -> fetch_assoc())
		{
			$sname = $MyResults['STUD_NAME'];
			$snum = $MyResults['STUD_NUM'];
			$sex = $MyResults['STUD_SEX'];
			$address = $MyResults['STUD_ADDRESS'];
			$college = $MyResults['STUD_COLLEGE'];
			$year = $MyResults['STUD_YEAR'];
			$course = $MyResults['STUD_COURSE'];
			$contact = $MyResults['STUD_CONTACT'];
			$email = $MyResults['STUD_EMAIL'];
			$type = $MyResults['LOAN_TYPE'];
			$acadyear = $MyResults['LOAN_YEAR'];
			$sem = $MyResults['LOAN_SEM'];
			$amt_borrowed = $MyResults['LOAN_AMOUNT'];
			$out_bal = $MyResults['OUT_BAL'];
			$reason = $MyResults['REASON'];
		}
	}
	
    if($_POST['save'])
    {
	 	$nsname = $_POST['sname'];
        $nsnum = $_POST['snum'];
        $naddress = $_POST['address'];
        $ncourse = $_POST['course'];
        $ncontact = $_POST['contact'];
        $nemail = $_POST['email'];
        $nacadyear = $_POST['acadyear'];
        $namt_borrowed = $_POST['amt_borrowed'];
        $nreason = $_POST['reason'];

        if(empty($nsname))
        {
        	$nsname = $sname;
        }

        if(empty($nsnum))
        {
        	$nsnum = $snum;
        }

        if(empty($naddress))
        {
        	$naddress = $address;
        }

        if(empty($ncourse))
        {
        	$ncourse = $course;
        }

        if(empty($ncontact))
        {
        	$ncontact = $contact;
        }

        if(empty($nemail))
        {
        	$nemail = $email;
        }

        if(empty($nacadyear))
        {
        	$nacadyear = $acadyear;
        }

        if(empty($namt_borrowed))
        {
        	$namt_borrowed = $amt_borrowed;
        }

        if(empty($nreason))
        {
        	$nreason = $reason;
        }

        $nsex = $_POST['sex'];
        $ncollege = $_POST['college'];
        $nyear = $_POST['year'];
        $nsem = $_POST['sem'];

        if ($amt_borrowed == $namt_borrowed)
        {
	    	$MyQuery = "UPDATE STUDENT SET STUD_NAME = '$nsname', STUD_NUM = '$nsnum', STUD_SEX = '$nsex', STUD_ADDRESS = '$naddress', STUD_COLLEGE = '$ncollege', STUD_YEAR = '$nyear', STUD_COURSE = '$ncourse', STUD_CONTACT = '$ncontact', STUD_EMAIL = '$nemail', LOAN_TYPE = '$type', LOAN_YEAR = '$nacadyear', LOAN_SEM = '$nsem', REASON = '$nreason' WHERE (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$acadyear' AND STUDENT.LOAN_SEM = '$semSaved');";

	    	mysqli_query($MyConnection, $MyQuery);
		        
	        $MyBalQuery = "UPDATE BAL_HIST SET STUD_NUM = '$nsnum', LOAN_YEAR = '$nacadyear', LOAN_SEM = '$nsem' WHERE (BAL_HIST.STUD_NUM = '$num' AND BAL_HIST.LOAN_TYPE = '$type' AND BAL_HIST.LOAN_YEAR = '$acadyear' AND BAL_HIST.LOAN_SEM = '$semSaved');";

	        mysqli_query($MyConnection, $MyBalQuery);
		}

		else
		{
			$NewOutBal = $namt_borrowed - ($amt_borrowed - $out_bal);

			$MyQuery = "UPDATE STUDENT SET STUD_NAME = '$nsname', STUD_NUM = '$nsnum', STUD_SEX = '$nsex', STUD_ADDRESS = '$naddress', STUD_COLLEGE = '$ncollege', STUD_YEAR = '$nyear', STUD_COURSE = '$ncourse', STUD_CONTACT = '$ncontact', STUD_EMAIL = '$nemail', LOAN_TYPE = '$type', LOAN_YEAR = '$nacadyear', LOAN_SEM = '$nsem', REASON = '$nreason', OUT_BAL = $NewOutBal, LOAN_AMOUNT = $namt_borrowed WHERE (STUDENT.STUD_NUM = '$num' AND STUDENT.LOAN_TYPE = '$type' AND STUDENT.LOAN_YEAR = '$acadyear' AND STUDENT.LOAN_SEM = '$semSaved');";

	    	mysqli_query($MyConnection, $MyQuery);

	    	$MySearchQuery = "SELECT * FROM BAL_HIST WHERE (BAL_HIST.STUD_NUM = '$num' AND BAL_HIST.LOAN_TYPE = '$type' AND BAL_HIST.LOAN_YEAR = '$acadyear' AND BAL_HIST.LOAN_SEM = '$semSaved');";

			$MyValues = $MyConnection -> query($MySearchQuery);

			if (($MyValues -> num_rows) > 0)
			{
				$SavedOutBal = $namt_borrowed;

				while ($MyResults = $MyValues -> fetch_assoc())
				{
					$AMT_PAID = $MyResults['AMT_PAID'];
					$NewCurrBal = $SavedOutBal - $AMT_PAID;

					$MyBalQuery = "UPDATE BAL_HIST SET STUD_NUM = '$nsnum', LOAN_YEAR = '$nacadyear', LOAN_SEM = '$nsem', AMT_BORROWED = $namt_borrowed, OUT_BAL = $NewCurrBal WHERE (BAL_HIST.STUD_NUM = '$num' AND BAL_HIST.LOAN_TYPE = '$type' AND BAL_HIST.LOAN_YEAR = '$acadyear' AND BAL_HIST.LOAN_SEM = '$semSaved' AND BAL_HIST.AMT_PAID = $AMT_PAID);";

	        		mysqli_query($MyConnection, $MyBalQuery);

	        		$SavedOutBal = $NewCurrBal;
				}
			}
		}
        

		echo "<script>alert('Saved Successfully!');
			location = 'list.php?type=$type&acadyear=$acadyear';</script>";
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
		<title>Edit Student Information</title>
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
        				<h1>Edit Student Transaction</h1><br>
      				</div>
    			</div>
   				<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
  					<h5 class="text-center py-2">Year of Application</h5>
      				<div class="container">
      					<div class="row">
      						<label for="example-search-input" class="col-2 col-form-label">Academic Year</label>
      						<div class="col">
								<input class="form-control" name="acadyear" placeholder="<?php echo $acadyear; ?>" pattern="\d{4}[-]\d{4}">
							</div>
							<label for="example-number-input" class="py-2 form-label">Semester</label>
							<div class="col">
								<select name="sem" class = "form-control">
									<option <?php  if ($sem == "1ST") echo 'selected' ?> value="1ST">1st Semester</option>
									<option <?php  if ($sem == "2ND") echo 'selected' ?> value="2ND">2nd Semester</option>
									<option <?php  if ($sem == "MID") echo 'selected' ?> value="MID">Summer/Midyear</option>
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
								<input class="form-control" id="snumber-input" name="sname" placeholder ="<?php echo $sname; ?>" pattern="^.{1,100}$">
							</div>

							<label for="example-number-input" class="py-2 form-label">Student Number</label>
							<div class="col">
								<input class="form-control" id="snumber-input" name="snum" pattern ="\d{4}[-]\d{5}" placeholder="<?php echo $snum; ?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Course</label>
							<div class="col-10 col-md-6">
								<input class="form-control" id="snumber-input" name="course" placeholder="<?php echo $course; ?>" pattern="^.{1,35}$">
							</div>
							<label for="example-number-input" class="py-2 col-form-label">College</label>
							<div class="col">
								<select name="college" class = "form-control">
									<option <?php  if ($college == "CAC") echo 'selected'; ?> value="CAC">CAC</option>
									<option <?php  if ($college == "CS") echo 'selected'; ?> value="CS">CS</option>
									<option <?php  if ($college == "CSS") echo 'selected'; ?> value="CSS">CSS</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Mailing/Provincial Address</label>
							<div class="col-10 col-md-6">
								<input class="form-control" name="address" placeholder="<?php echo $address; ?>" pattern="^.{1,100}$">
							</div>
							<label for="example-search-input" class="form-label py-2">Sex</label>
							<div class="px-2">
								<select name="sex" class="form-control">
									<option <?php if ($sex == "Male") echo 'selected' ; ?> value="Male">Male</option>
									<option <?php if ($sex == "Female") echo 'selected' ; ?> value="Female">Female</option>
								</select>
							</div>
							<label for="example-number-input" class="form-label py-2">Year</label>
							<div class="px-2">
								<select name="year" class = "form-control">
									<option <?php if ($year == "1ST") echo 'selected' ; ?> value = "1ST">1st Year</option>
									<option <?php if ($year == "2ND") echo 'selected' ; ?> value = "2ND">2nd Year</option>
									<option <?php if ($year == "3RD") echo 'selected' ; ?> value = "3RD">3rd Year</option>
									<option <?php if ($year == "4TH") echo 'selected' ; ?> value = "4TH">4th Year</option>
									<option <?php if ($year == "OTHERS") echo 'selected' ; ?> value = "OTHERS">Others</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
						<label for="example-number-input" class="col-2 col-form-label">E-mail Address</label>
						<div class="col-10 col-md-10">
							<input class="form-control" type="email" id="email-input" name="email" placeholder="<?php echo $email; ?>"> </div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Telephone/Cellphone Number</label>
							<div class="col-10 col-md-10">
								<input class="form-control" id="telnum-input" name="contact" pattern="^(0\d{10})$|^(\d{7})$" placeholder="<?php echo $contact; ?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Amount Borrowed</label>
							<div class="col-10 col-md-10">
								<?php
									if($type == "IM Student Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-8][0-9]{3}|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9]|1[0-9]{4}|20000)$" placeholder="Previous Amount Saved: &#8369;'.$amt_borrowed.' (Max Amount: &#8369;20000)">';
									}

									else if ($type == "Radwill Loan" || $type == "Safe Cash Loan" || $type == "UPAASV Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-4][0-9]{3}|5000)$" placeholder="Previous Amount Saved: &#8369;'.$amt_borrowed.' (Max Amount: &#8369;5000)">';
									}


									else if ($type == "Short Term Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|1[0-4][0-9]{2}|1500)$" placeholder=""Previous Amount Saved: &#8369;'.$amt_borrowed.' (Max Amount: &#8369;1500)">';
									}

									else if ($type == "Tuition Fee Loan")
									{
										echo '<input class="form-control" id="snumber-input" name="amt_borrowed" pattern = "^([1-9]|[1-8][0-9]|9[0-9]|[1-8][0-9]{2}|9[0-8][0-9]|99[0-9]|[1-8][0-9]{3}|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9]|10000)$" placeholder="Previous Amount Saved: &#8369;'.$amt_borrowed.' (Max Amount: &#8369;10000)">';
									}
								?>
							</div>

						</div>
						<div class="form-group row">
							<label for="example-number-input" class="col-2 col-form-label">Reason/s</label>
        					<div class="col-10">
        						<textarea class="form-control" id="exampleTextarea" rows="3" name="reason" pattern = "^.{1,200}$" placeholder='Previous Reason Saved: "<?php echo $reason ?>"'></textarea>
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
				title = "Let's go back!">&#8617; Go Back to the List</a>
			</p>
		</div>

		<!-- Scripts -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>x
    </body>
</html>