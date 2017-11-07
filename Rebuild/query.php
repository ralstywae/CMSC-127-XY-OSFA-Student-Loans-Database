<?php
	session_start();
	error_reporting(0);
	
	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'osfa_db';

	//Create Connection
	$MyConnection = mysqli_connect($MyServerName, $MyUserName, $MyPassword, $MyDBName);

	//Check Connection Status
	if ($MyConnection -> connect_error)
	{
		die("Connection Failed: ". $MyConnection -> connect_error);
	}

	$num = $_GET['num'];
	$name = $_GET['name'];
  	$type = $_GET['type'];	
?>

<!DOCTYPE html>

<html>
	<!-- Page Contents -->

	<!-- Head -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
		<title>Search Results</title>
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
    						<div class = "col-md-10">						
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

    	<h1 class="jumbotron-fluid text-center py-4"><em>Search Results</em></h1>
		<?php
			$SearchFilter = $_REQUEST['search_Filter'];
 			$MySearchRequest = $_REQUEST['search_Query'];

 			if (isset($SearchFilter))
 			{	
 				if($SearchFilter == 0 && $MySearchRequest != "")
 				{
 					$MySearchQuery = "SELECT * FROM STUDENT WHERE STUDENT.STUD_NUM LIKE '%$MySearchRequest%';";
 					$MyValues = $MyConnection -> query($MySearchQuery);

 					if (($MyValues -> num_rows) > 0)
 					{
 						echo "<div class=py-3> <div class=container> <div class=row>";
 						$TableClass = "table";
		                echo "<table class =".$TableClass.">";
		                echo
		                "
		              	 <thead>
			                <tr class = text-center>
			                	<th>Loan Type</th>
				                <th>Student Number</th>
								<th>Student Name</th>
								<th>Year</th>
								<th>Course</th>
								<th>Address</th>
								<th>Contact Number</th>
								<th>E-mail Address</th>
			                    <th>Pay</th>
								<th>Edit</th>
								<th>Delete</th>
			                </tr>
		                </thead>
		    			";
		                while ($MyResults = $MyValues -> fetch_assoc())
		                {
							echo '<tr>';
							echo '<td> '.$MyResults['LOAN_TYPE'].' </td>';
							echo '<td><a rel="facebox" href="history.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">'.$MyResults['STUD_NUM'].'</a></td>';
							echo '<td> '.$MyResults['STUD_NAME'].' </td>';
							echo '<td> '.$MyResults['STUD_YEAR'].' </td>';
							echo '<td> '.$MyResults['STUD_COURSE'].' </td>';
							echo '<td> '.$MyResults['STUD_ADDRESS'].' </td>';
							echo '<td> '.$MyResults['STUD_CONTACT'].' </td>';
							echo '<td> '.$MyResults['STUD_EMAIL'].' </td>';
							echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Pay</a></td>';
							echo '<td><a rel="facebox" href="edit_trans.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Edit</a></td>';
							echo '<td><a rel="facebox" href="delete.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'" onClick="return deleteconfig()">Delete</a></td></tr>';
		                }
	                	echo "</table>";
	                	echo "</div> </div> </div>";
 					}

 					else
 					{
 						$EmptySearchResults = "Your search returned no matches.";
						$DivClass = "text-center py-5 jumbotron";
						echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
 					}
 				}

 				else if($SearchFilter == 1 && $MySearchRequest != "")
 				{
 					$MySearchQuery = "SELECT * FROM STUDENT WHERE STUDENT.STUD_NAME LIKE '%$MySearchRequest%';";

 					$MyValues = $MyConnection -> query($MySearchQuery);

 					if (($MyValues -> num_rows) > 0)
 					{
 						echo "<div class=py-3> <div class=container> <div class=row>";
 						$TableClass = "table";
 						echo "<table class =".$TableClass.">";
		                echo
		                "
		              	 <thead>
			                <tr class = text-center>
			                	<th>Loan Type</th>
				                <th>Student Number</th>
								<th>Student Name</th>
								<th>Year</th>
								<th>Course</th>
								<th>Address</th>
								<th>Contact Number</th>
								<th>E-mail Address</th>
			                    <th>Pay</th>
								<th>Edit</th>
								<th>Delete</th>
			                </tr>
		                </thead>
		    			";

		                while ($MyResults = $MyValues -> fetch_assoc())
		                {
		                	echo '<tr>';
		                	echo '<td> '.$MyResults['LOAN_TYPE'].' </td>';
							echo '<td><a rel="facebox" href="history.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">'.$MyResults['STUD_NUM'].'</a></td>';
							echo '<td> '.$MyResults['STUD_NAME'].' </td>';
							echo '<td> '.$MyResults['STUD_YEAR'].' </td>';
							echo '<td> '.$MyResults['STUD_COURSE'].' </td>';
							echo '<td> '.$MyResults['STUD_ADDRESS'].' </td>';
							echo '<td> '.$MyResults['STUD_CONTACT'].' </td>';
							echo '<td> '.$MyResults['STUD_EMAIL'].' </td>';
							echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">Pay</a></td>';
							echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Pay</a></td>';
							echo '<td><a rel="facebox" href="edit_trans.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Edit</a></td>';
							echo '<td><a rel="facebox" href="delete.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'" onClick="return deleteconfig()">Delete</a></td></tr>';
		                }

	                	echo "</table>";
	                	echo "</div> </div> </div>";
 					}

 					else
 					{
 						$EmptySearchResults = "Your search returned no matches.";
						$DivClass = "text-center py-5 jumbotron";
						echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
 					}
 				}

 				else if($SearchFilter == 2)
 				{
 					$SexFilter = $_REQUEST['sex_Filter'];

 					if (isset($SexFilter))
 					{
 						if ($SexFilter == 0)
 						{

 							$MySearchQuery = "SELECT * FROM STUDENT WHERE STUDENT.STUD_SEX = 'Male';";
	 	 					$MyValues = $MyConnection -> query($MySearchQuery);

	 	 					if (($MyValues -> num_rows) > 0)
	 	 					{
	 	 						echo "<div class=py-3> <div class=container> <div class=row>";
		 						$TableClass = "table";
				                echo "<table class =".$TableClass.">";
				                echo
				                "
				              	 <thead>
					                <tr class = text-center>
					                	<th>Loan Type</th>
						                <th>Student Number</th>
										<th>Student Name</th>
										<th>Year</th>
										<th>Course</th>
										<th>Address</th>
										<th>Contact Number</th>
										<th>E-mail Address</th>
					                    <th>Pay</th>
										<th>Edit</th>
										<th>Delete</th>
					                </tr>
				                </thead>
				    			";
								while ($MyResults = $MyValues -> fetch_assoc())
				                {
				                	echo '<tr>';
				                	echo '<td> '.$MyResults['LOAN_TYPE'].' </td>';
									echo '<td><a rel="facebox" href="history.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">'.$MyResults['STUD_NUM'].'</a></td>';
									echo '<td> '.$MyResults['STUD_NAME'].' </td>';
									echo '<td> '.$MyResults['STUD_YEAR'].' </td>';
									echo '<td> '.$MyResults['STUD_COURSE'].' </td>';
									echo '<td> '.$MyResults['STUD_ADDRESS'].' </td>';
									echo '<td> '.$MyResults['STUD_CONTACT'].' </td>';
									echo '<td> '.$MyResults['STUD_EMAIL'].' </td>';
									echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Pay</a></td>';
									echo '<td><a rel="facebox" href="edit_trans.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Edit</a></td>';
									echo '<td><a rel="facebox" href="delete.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'" onClick="return deleteconfig()">Delete</a></td></tr>';
				                }

				                echo "</table>";
			                 	echo "</div> </div> </div>";
			             	}

			             	else
			             	{
			             		$EmptySearchResults = "Your search returned no matches.";
								$DivClass = "text-center py-5 jumbotron";
								echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
			             	}
 						}

 						else if ($SexFilter == 1)
 						{
 							$MySearchQuery = "SELECT * FROM STUDENT WHERE STUDENT.STUD_SEX = 'Female';";
 	 						$MyValues = $MyConnection -> query($MySearchQuery);

	 	 					if (($MyValues -> num_rows) > 0)
	 	 					{
	 	 						echo "<div class=py-3> <div class=container> <div class=row>";
		 						$TableClass = "table";

				                echo "<table class =".$TableClass.">";
				                echo
				                "
				              	 <thead>
									<tr class = text-center>
										<th>Loan Type</th>
						                <th>Student Number</th>
										<th>Student Name</th>
										<th>Year</th>
										<th>Course</th>
										<th>Address</th>
										<th>Contact Number</th>
										<th>E-mail Address</th>
					                    <th>Pay</th>
										<th>Edit</th>
										<th>Delete</th>
					                </tr>
				                </thead>
				    			";
				                while ($MyResults = $MyValues -> fetch_assoc())
				                {
				                	echo '<tr>';
				                	echo '<td> '.$MyResults['LOAN_TYPE'].' </td>';
									echo '<td><a rel="facebox" href="history.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">'.$MyResults['STUD_NUM'].'</a></td>';
									echo '<td> '.$MyResults['STUD_NAME'].' </td>';
									echo '<td> '.$MyResults['STUD_YEAR'].' </td>';
									echo '<td> &#8369;'.$MyResults['LOAN_AMOUNT'].' </td>';
									echo '<td> '.$MyResults['LOAN_YEAR'].' </td>';
									echo '<td> '.$MyResults['LOAN_SEM'].' </td>';
									echo '<td> '.$MyResults['REASON'].' </td>';
									echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Pay</a></td>';
									echo '<td><a rel="facebox" href="edit_trans.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Edit</a></td>';
									echo '<td><a rel="facebox" href="delete.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'" onClick="return deleteconfig()">Delete</a></td></tr>';
				                }

				                echo "</table>";
				                echo "</div> </div> </div>";
			             	}

			             	else
			             	{
			             		$EmptySearchResults = "Your search returned no matches.";
								$DivClass = "text-center py-5 jumbotron";
								echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
			             	}
 						}
 					}
 				}

 				else if ($SearchFilter == 3 && $MySearchRequest != "")
 				{
 					$MySearchQuery = "SELECT * FROM STUDENT WHERE STUDENT.LOAN_TYPE LIKE '%$MySearchRequest%';";

 					$MyValues = $MyConnection -> query($MySearchQuery);

 					if (($MyValues -> num_rows) > 0)
 					{
 						echo "<div class=py-3> <div class=container> <div class=row>";
 						$TableClass = "table";
		                echo "<table class =".$TableClass.">";
		                echo
		                "
		              	 <thead>
			                <tr class = text-center>
			               		<th>Loan Type</th>
				                <th>Student Number</th>
								<th>Student Name</th>
								<th>Loan Amount</th>
								<th>Loan Year</th>
								<th>Loan Semester</th>
								<th>Reason</th>
			                    <th>Pay</th>
								<th>Edit</th>
								<th>Delete</th>
			                </tr>
		                </thead>
	        			";

		                while ($MyResults = $MyValues -> fetch_assoc())
		                {
	                		echo '<tr>';
	                		echo '<td> '.$MyResults['LOAN_TYPE'].' </td>';
							echo '<td><a rel="facebox" href="history.php?num='.$MyResults['STUD_NUM'].'&name='.$MyResults['STUD_NAME'].'&type='.$MyResults['LOAN_TYPE'].'">'.$MyResults['STUD_NUM'].'</a></td>';
							echo '<td> '.$MyResults['STUD_NAME'].' </td>';
							echo '<td> '.$MyResults['STUD_COURSE'].' </td>';
							echo '<td> '.$MyResults['STUD_YEAR'].' </td>';
							echo '<td> '.$MyResults['STUD_ADDRESS'].' </td>';
							echo '<td> '.$MyResults['STUD_CONTACT'].' </td>';
							echo '<td> '.$MyResults['STUD_EMAIL'].' </td>';
							echo '<td> &#8369;'.$MyResults['LOAN_AMOUNT'].' </td>';
							echo '<td> '.$MyResults['REASON'].' </td>';
							echo '<td><a rel="facebox" href="payment.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Pay</a></td>';
							echo '<td><a rel="facebox" href="edit_trans.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'">Edit</a></td>';
							echo '<td><a rel="facebox" href="delete.php?num='.$MyResults['STUD_NUM'].'&type='.$MyResults['LOAN_TYPE'].'&sem='.$MyResults['LOAN_SEM'].'&year='.$MyResults['LOAN_YEAR'].'" onClick="return deleteconfig()">Delete</a></td></tr>';
		                }

		                echo "</table>";
		               	echo "</div> </div> </div>";
 					}

 					else
 					{
 						$EmptySearchResults = "Your search returned no matches.";
						$DivClass = "text-center py-5 jumbotron";
						echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
 					}
 				}

 				else
 				{
 					$EmptySearchResults = "Your search returned no matches.";
					$DivClass = "text-center py-5 jumbotron";
					echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3></div></div>";
 				}
 			}
		?>
		<script type="text/javascript">
			function deleteconfig()
			{
				var del = confirm('Are you sure you want to delete this?');
				if(del == true)
				{
					alert ("Successfully Deleted!");
				}

				return del;
			}
	    </script>
    	 <!-- Footer -->
        <div class = "text-md-center">
			<p>
				<a href = "search.php" title = "Let's go back!">&#8617; Go Back to the Search Page</a>
			</p>
		</div>

		<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    </body>

    <!-- Close Database Connection -->
    <?php
    	mysqli_close($MyConnection);
    ?>
</html>