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

  $query = mysql_query("SELECT * FROM STUDENT natural join BAL_HIST where STUD_NUM = '$num' and LOAN_TYPE = '$type'");
  while($result = mysql_fetch_object($query)){
    $sname = $result->STUD_NAME;
    $snum = $result->STUD_NUM;
    $sex = $result->STUD_SEX;
    $address = $result->STUD_ADDRESS;
    $college = $result->STUD_COLLEGE;
    $year = $result->STUD_YEAR;
    $course = $result->STUD_COURSE;
    $contact = $result->STUD_CONTACT;
    $email = $result->STUD_EMAIL;
    $type = $result->LOAN_TYPE;
    $year = $result->LOAN_YEAR;
    $sem = $result->LOAN_SEM;
    $amt_borrowed = $result->LOAN_AMOUNT;
    $reason = $result->REASON;
  }
	if($_POST['save']){
        $namt_paid = $_POST['amt_paid'];
        $ndate_paid = $_POST['date_paid'];
        $nor_num = $_POST['or_num'];
        $nreason = $_POST['reason'];

        if(!empty($namt_paid)){
        	$out_bal = $amt_borrowed - $namt_paid;
          $amt_borrowed = $out_bal;
        }

		mysql_query("UPDATE STUDENT SET LOAN_YEAR = '$nacadyr', LOAN_SEM = '$nsem', LOAN_AMOUNT = $namt_borrowed, REASON = '$nreason' WHERE STUD_NUM = '$num' and LOAN_TYPE = '$type'");

    mysql_query("UPDATE BAL_HIST SET OUT_BAL = $out_bal WHERE STUD_NUM = '$num' and LOAN_TYPE = '$type'");

		mysql_query("INSERT INTO BAL_HIST (LOAN_TYPE, AMT_BORROWED, AMT_PAID, DATE_PAID, OR_NUM, OUT_BAL, STUD_NUM)
		VALUES ('$type', $amt_borrowed, $namt_paid, '$ndate_paid', $nor_num, $out_bal, '$snum')");

		echo "<script>alert('Added Successfully!');
		location = 'history.php?num=$snum&name=$sname&out_bal=$out_bal';</script>";
	}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="style.css" type="text/css"> </head>

<body>
  <div class="gradient-overlay text-center bg-secondary p-1">
    <div class="container-fluid p-1">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2">
              <img class="img-fluid d-block rounded-circle" src="uplogo.png" width="200" height="250
200"> </div>
            <div class="col-md-10">
              <h2 class="text-white display-4">
                <font color="#292b2c" class="text-white">Office of Student Financial Assistance</font>
              </h2>
              <h3 class="text-white">
                <font color="#292b2c" class="text-white"><i>Office of the Director for Student Affairs<br></i></font>
              </h3>
              <h4> <i class="text-center text-white">University of the Philippines - Baguio<br></i> </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="home.php"><b>Home</b></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="search.php">Search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="list.php">List of Loans &amp; Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php"><i class="fa d-inline fa-lg fa-user-circle-o"></i>&nbsp;Add Student loan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
           <?php echo '<h1>Payment for '.$num.'</h1><br>'; ?>
        </div>
      </div>
 <form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
      <div class="row"> <label for="example-search-input" class="col-2 col-form-label">Year of Application</label>
        <div class="col-4 col-md-2">
          <input class="form-control" name="acadyr" value="<?php echo $year ?>" disabled></div>
        <div class="col-md-4">
        <label for="example-search-input" class="col-4 col-form-label">Semester</label>
          <div class="btn-group">

            <select name="sem">
      				<option value="1st">1st Semester</option>
      				<option value="2nd">2nd Semester</option>
      				<option value="sum">Summer/Midyear</option>
      			</select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row"> </div>
        </div>
      </div>
      <div class="row"> </div>
    </div>

    <div class="form-group row"> </div>
    <div class="container">
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Student Name</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="sname" value = "<?php echo $sname ?>" disabled> </div><label for="example-number-input" class="col-2 col-form-label">Student Number</label>
        <div class="col-10 col-md-2">
          <input class="form-control" id="snumber-input" name="snum" value="<?php echo $snum ?>" disabled> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Course</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="course" value="<?php echo $course ?>" disabled> </div>
          <label for="example-number-input" class="col-2 col-form-label">Year</label>
        <div class="col-10 col-md-2">
          <select name="year">
              <option value=1>1st Year</option>
              <option value=2>2nd Year</option>
              <option value=3>3rd Year</option>
              <option value=4>4th Year</option>
            </select></div>
      </div>

       <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Permanent Address</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="address" value="<?php echo $address ?>" disabled> </div>
          <label for="example-number-input" class="col-2 col-form-label">Sex</label>
        <div class="col-10 col-md-2">
          <select name="sex">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select></div>
      </div>

      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">E-mail Address</label>
        <div class="col-10 col-md-10">
          <input class="form-control" type="email" id="email-input" name="email" value ="<?php echo $email?>" disabled> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Telephone/Cellphone Number</label>
        <div class="col-10 col-md-10">
          <input class="form-control" id="telnum-input" name="contact" value="<?php echo $contact ?>" disabled> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Amount Borrowed</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="amt_borrowed" value="<?php echo $amt_borrowed?>" disabled> </div><label for="example-number-input" class="col-2 col-form-label">Amount Paid</label>
        <div class="col-10 col-md-2">
          <input class="form-control" id="snumber-input" name="amt_paid"> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Date Paid</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="date_paid"> </div><label for="example-number-input" class="col-2 col-form-label">O.R. No.</label>
        <div class="col-10 col-md-2">
          <input class="form-control" id="snumber-input" name="or_num"> </div>
      </div>




      <div class="form-group row"> <label for="example-number-input" class="col-2 col-form-label">Reason/s</label>
        <div class="col-10"> <textarea class="form-control" id="exampleTextarea" rows="3" name="reason" value="<?php echo $reason?>" disabled=""></textarea> </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
      </div>




      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="row">
              <div class="col-md-12 center">
              	<button class="btn" type="submit" name="save" value="save" id="button1" style="background-color: #C0C0C0; width: 150px; height: 60px; padding: 5px"><span>Save</span></button>
              	</form>
                <!--<a href="#" class="btn btn-outline-primary btn-lg text-center text-capitalize gradient-overlay" name="Submit" value="save" data-toggle="">Save</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

</html>