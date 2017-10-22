<?php
  $db_database = 'osfa_db';
  $conn = mysql_connect($dbhost, $dbu
  session_start();
  error_reporting(0);
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';ser, $dbpass);

  mysql_select_db($db_database,$conn);
  $type = $_GET['type'];

  //Eto yung nilagay ko pero di ko sure yung WHERE
  $query = mysql_query("SELECT * FROM STUDENT NATURAL JOIN WHERE LOAN_TYPE = '$type' AND STUD_NUM = $snum");
  while($result = mysql_fetch_object($query)){
    $sname = $result->STUD_NAME;
    $address = $result->STUD_ADDRESS;
    $sex = $result->STUD_SEX;
    $college = $result->STUD_COLLEGE;
    $year = $result->STUD_YEAR;
    $course = $result->STUD_COURSE;
    $contact = $result->STUD_CONTACT;
    $email = $result->STUD_EMAIL;
    $snum = $result->STUD_NUM;
    
    $type = $result->LOAN_TYPE;
    $acadyr = $result->LOAN_YEAR;
    $sem = $result->LOAN_SEM;
    $amt_borrowed = $result->LOAN_AMOUNT;

  }

  if($_POST['save']){
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
        $namt_paid = $_POST['amt_paid'];
        $ndate_paid = $_POST['date_paid'];
        $nor_num = $_POST['or_num'];
        $nreason = $_POST['reason'];

        if(empty($namt_paid)){
          $namt_paid = 0;
        }
        if(empty($ndate_paid)){
          $ndate_paid = 0;
        }
        if(empty($nor_num)){
          $nor_num = 0;
        }

    //Di ko rin sure yung WHERE but yeah inadd ko rin tong UPDATE vvv
    mysql_query("UPDATE STUDENT SET STUD_NAME = '$nsname', STUD_ADDRESS = '$nadd', STUD_SEX = '$nsex', STUD_COLLEGE = '$ncollege', STUD_YEAR = '$nyear', STUD_COURSE = '$ncourse', STUD_CONTACT = '$ncontact', STUD_EMAIL = '$nemail', STUD_NUM = '$nsnum', LOAN_TYPE = '$ntype', LOAN_YEAR = '$acadyr', LOAN_SEM = '$nsem', LOAN_AMOUNT = '$namt_borrowed' WHERE LOAN_TYPE = '$type' AND STUD_NUM = $snum");

    mysql_query("INSERT INTO STUDENT (STUD_NAME, STUD_ADDRESS, STUD_SEX, STUD_COLLEGE, STUD_YEAR, STUD_COURSE, STUD_CONTACT, STUD_EMAIL, STUD_NUM, LOAN_TYPE, LOAN_YEAR, LOAN_SEM, LOAN_AMOUNT, REASON)
    VALUES ('$nsname','$nadd', '$nsex', '$ncollege', $nyear, '$ncourse', $ncontact, '$nemail', '$nsnum', '$ntype', '$nacadyr', '$nsem', $namt_borrowed, '$nreason')");

    mysql_query("INSERT INTO BAL_HIST (LOAN_TYPE, AMT_BORROWED, AMT_PAID, DATE_PAID, OR_NUM, STUD_NUM)
    VALUES ('$ntype', $namt_borrowed, $namt_paid, '$ndate_paid', $nor_num, '$nsnum')");

    echo "<script>alert('Added Successfully!');
    location = 'list.php?type=$type';</script>";
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="style.css" type="text/css">
</head>

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
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">Edit student loan information</h1>
        </div>
      </div>
    </div>
    <div class="container">
      <form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="row"> <label for="example-search-input" class="col-2 col-form-label text-right">Year of Application</label>
          <div class="btn-group col-md-2"> <select name="acadyr">
						<option value="2015-2016">2015-2016</option>
						<option value="2016-2017">2016-2017</option>
						<option value="2017-2018">2017-2018</option>
						<option value="2018-2019">2018-2019</option>
						<option value="2019-2020">2019-2020</option>
					</select> </div>
          <div class="col-md-8"> <label for="example-search-input" class="col-2 col-form-label">Semester</label> <label class="radio-inline"><input name="gender" id="input-gender-male" value="Male" type="radio">1st Semester</label> <label class="radio-inline"><input name="gender" id="input-gender-female" value="Female" type="radio">2nd Semester</label>            <label class="radio-inline col-4"><input name="gender" id="input-gender-male" value="Male" type="radio">Summer/Midyear</label> </div>
        </div>
        <div class="row"> </div>
      </form>
    </div>
    <div class="form-group row"> </div>
    <div class="container">
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Student Name</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="sname"> </div><label for="example-number-input" class="col-2 col-form-label">Student Number</label>
        <div class="col-10 col-md-2">
          <input class="form-control" id="snumber-input" name="snum"> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Course</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="course"> </div><label for="example-number-input" class="col-2 col-form-label">Year</label>
        <div class="col-10 col-md-2"> <select name="year" class="form-control-sm w-100">
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
            </select> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Mailing/Provincial Address</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="address"> </div> <label for="example-search-input" class="col-1 col-form-label">Sex</label> <label class="radio-inline col-1"><input name="gender" id="input-gender-male" value="Male" type="radio">Male</label> <label class="radio-inline"><input name="gender" id="input-gender-female" value="Female" type="radio">Female</label>        </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">E-mail Address</label>
        <div class="col-10 col-md-10">
          <input class="form-control" type="email" id="email-input" name="email"> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Telephone/Cellphone Number</label>
        <div class="col-10 col-md-10">
          <input class="form-control" id="telnum-input" name="contact"> </div>
      </div>
      <div class="form-group row"><label for="example-number-input" class="col-2 col-form-label">Amount Borrowed</label>
        <div class="col-10 col-md-6">
          <input class="form-control" id="snumber-input" name="amt_borrowed"> </div>
      </div>
      <div class="form-group row"> <label for="example-number-input" class="col-2 col-form-label">Reason/s</label>
        <div class="col-10"> <textarea class="form-control" id="exampleTextarea" rows="3" name="reason"></textarea> </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="row">
              <div class="col-md-6 center-block"> </div>
              <div class="col-md-6 center-block">
                <!--<a href="#" class="btn btn-outline-primary btn-lg text-center text-capitalize gradient-overlay" name="Submit" value="save" data-toggle="">Save</a>-->
                <button class="btn w-25 btn-lg" type="submit" name="save" value="save" id="button1" style="background-color: rgb(192, 192, 192); width: 150px; height: 60px; padding: 5px;"><span>Save</span></button>
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