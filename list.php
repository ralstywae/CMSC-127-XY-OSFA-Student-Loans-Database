<?php
  session_start();
  error_reporting(0);
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';
  $db_database = 'osfa_db';
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  mysql_select_db($db_database,$conn);

  $id = $_GET['id'];
?>

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
            <a class="nav-link" href="<?php echo 'add.php?id='.$id.''?>"><i class="fa d-inline fa-lg fa-user-circle-o"></i>&nbsp;Add Student loan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php echo '<h1>'.$id.'</h1>'; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="py-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <tr>
              <th>Student Number</th>
              <th>Student Name</th>
              <th>Course</th>
              <th>Year</th>
              <th>Address</th>
              <th>Contact Number</th>
              <th>E-mail Address</th>
              <th>Loan Amount</th>
              <th>Delete</th>
            </tr>
            <?php
              $query = mysql_query("SELECT * FROM STUDENT WHERE LOAN_TYPE = '$id'");
              while($result = mysql_fetch_object($query)){
                echo '<tr><td><a rel="facebox" href="history.php?id='.$result->STUD_NUM.'&name='.$result->STUD_NAME.'&type='.$result->LOAN_TYPE.'">'.$result->STUD_NUM.'</a></td>';
                echo '<td>'.$result->STUD_NAME.'</td>';
                echo '<td>'.$result->STUD_COURSE.'</td>';
                echo '<td>'.$result->STUD_YEAR.'</td>';
                 echo '<td>'.$result->STUD_ADDRESS.'</td>';
                  echo '<td>'.$result->STUD_CONTACT.'</td>';
                echo '<td>'.$result->STUD_EMAIL.'</td>';
                echo '<td>'.$result->LOAN_AMOUNT.'</td>';
                echo '<td><a rel="facebox" href="delete.php?id='.$result->STUD_NUM.'&type='.$result->LOAN_TYPE.'" onClick="return deleteconfig()">Delete</a></td></tr>';
              }
            ?>
            <script>
              function deleteconfig(){
              var del = confirm('Are you sure you want to delete this?');
              if(del==true)
                alert ("Successfully Deleted!");
              return del;
            }
            </script>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

</html>