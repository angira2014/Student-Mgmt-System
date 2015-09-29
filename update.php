<html>

<?php
// start buffering
ob_start();

// include config file
require_once "config.php";
require_once('views.php');
require_once('models.php');
// call dbConnect model to connect to database
$dbConn = dbConnect();

$student_id = $_GET['student_id'];
// checks to see if the form has been submitted to do validation
if (isset($_POST['submit'])) {
			
	// Create a flag to determine if the data is valid. Assume it is valid to start
	$valid = true;

	// Create a flag to determine if the data will be validated (ie. user entry)
	$validate = true;
		
	// retrieve the data from the form and trim any whitespace
	//$childName = trim($_REQUEST['childName']);
	$childName = htmlentities(trim($_REQUEST['childName']),ENT_QUOTES);	
	$gender = trim($_REQUEST['gender']);
	$birthday = trim($_REQUEST['birthday']);
	$city = trim($_REQUEST['city']);
	$zipcode = trim($_REQUEST['zipcode']);
	$contactNo = trim($_REQUEST['contactNo']);
	
	
} else {
	$student_id = $_GET['student_id'];
	if (!(is_numeric($student_id))) {
		echo "No student selected. Please go to the <a href='list.php'>display page</a> to select a product to update</p>";
		exit;
	}
	// retrieve the product data from the database
	$result = mysqli_query($dbConn, "select * from student where student_id=".$_REQUEST['student_id']);
	if ($result) {
      $row = mysqli_fetch_array($result,MYSQLI_BOTH);
      $childName = $row['student_name'];
      $gender = $row['gender'];
      $birthday =$row['birthday'];
      $city = $row['student_city'];
      $zipcode = $row['zipcode'];
      $contactNo =$row['contact'];
      //set valid flag to false so form will display
      $valid = false;
      // set flag to ignore validation
      $validate = false;
   } else {
      echo "Student not found. Please go to the <a href='list.php'>display page</a> to select another product to update</p>";
      exit;
   }
}


?>

<head>
<title>Registration</title>
<link rel = "stylesheet" href = "style.css" type =  "text/css" />	
</head>
<body>
	<div id = "content">
		<header><h1>Kids Workshop</h1></header>
	<hr/>
	
		<h2>Registration for Admission</h2>
	    <form enctype="multipart/form-data" method = "POST" >
			<p><label for = "Child Name"> Child Name : </label> <input type = "text"  placeholder = "Name" name = "childName" value="<?php echo $childName ?>">
			<?php
			if ($validate) {
				// Make sure they entered something in the childname. If not, write error message and set $valid = false
				if (empty($childName)) {
					echo "<span class='error'><sup>*</sup> Child Name is required</span>";
					$valid = false;
				}else{
					$childName = ucfirst($childName);
				}
			}?></p>
			<p><label for ="Gender">Gender :</label>
				<Input type = "Radio" name ="gender"  value= "male" <?php if ($gender == 'male') {echo "checked";} ?> >Male
				<Input type = "Radio" name ="gender" value= "female" <?php if ($gender == 'female'){echo "checked";}?> >Female
				
			<?php
			if ($validate) {
				// Make sure they entered something in the gender. If not, write error message and set $valid = false
				if (empty($gender)) {
					echo "<span class='error'><sup>*</sup> Gender is required</span>";
					$valid = false;
				}
				
			}?></p>
				
			<p><label for = "Birthday">Birthday: </label><input type = "text" placeholder = "YY-MM-DD" name = "birthday" value="<?php echo $birthday ?>">
			<?php
			if ($validate) {
				// Make sure they entered something in the birthday. If not, write error message and set $valid = false
				if (empty($birthday)) {
					echo "<span class='error'><sup>*</sup> Birthday is required</span>";
					$valid = false;
				}else{
					$dateArray = preg_split('/-/',$birthday);
					 
					// Check for year between 2004 and 2012
					if (intval($dateArray[0]) < 04 || intval($dateArray[0]) > 12){
						echo "<span class='error'> Year must be between 04 and 12</span>";
						$valid =false;
						}
			
					//Check the month for 1-12
					if (intval($dateArray[1]) < 1 || intval($dateArray[1]) > 12){
						echo "<span class='error'><sup>*</sup> Month must be between 0 and 12</span>";
						$valid= false;
					}
						
					// check for day 1-31
					if (intval($dateArray[2]) < 1 || intval($dateArray [2]) >31){
						echo "<span class='error'><sup>*</sup> Day must be between 1 and 31</span>";
						$valid = false;
					}
					// Check whether the birthday is in YY-MM-DD format
					if (!preg_match ("/[0-9]{2}-[0-9]{2}-[0-9]{2}/",$birthday)){
						echo "<span class='error'><sup>*</sup> Please enter the Birthday in YY-MM-DD format</span>";
						$valid = false;
					}   
				}	              
			}?></p>
			<p><label for = "City">City : </label><input type = "text" placeholder = "City" name = "city" value="<?php echo $city ?>">
			<?php
			if($validate){
				//Check to see if something is entered in city.
				if (empty($city)){ 
					echo "<span class='error'><sup>*</sup> Please enter the name of the City</span>";
					$valid  = false;	
				}
				
				
			}?></p>
			<p><label for = "Zipcode">Zipcode : </label><input type = "text" placeholder = "Zipcode" name = "zipcode" value="<?php echo $zipcode ?>">
			<?php
			if($validate){
				//Check to see if something is entered in zipcode.
				if (empty($zipcode)){
					echo "<span class='error'><sup>*</sup> Please enter the Zipcode</span>";
					$valid = false;
				}
			
				// Check to see if Zipcode is 5 digits
				elseif (!preg_match("/[0-9]{5}/",$zipcode)){
					echo "<span class='error'><sup>*</sup> Zipcode should be 5 digit long</span>";
					$valid= false;
				}
			}?></p>
			<p><label for = "Contact No">Contact No : </label><input type = "text" placeholder= "Mobile No" name = "contactNo" value="<?php echo $contactNo ?>">
			<?php
			if($validate){
				// Check to see if the Mobile No is not empty.
				if (empty ($contactNo)){
					echo "<span class='error'><sup>*</sup> Mobile number is required</span>";
					$valid = false;
				}		
				// Check to see if the Mobile No is numeric.
				elseif (!is_numeric($contactNo)){
					echo "<span class='error'><sup>*</sup> Mobile No. must be numeric only</span>";
					$valid= false;
				}				
				// Check to see if Mobile No is 10 digits
				elseif (!preg_match ("/[0-9]{10}/",$contactNo)){
					echo "<span class='error'><sup>*</sup> Mobile Number must contain 10 digits</span>";
					$valid= false;
				}				
			}?></p>

			
			<p><input type = "submit" value = "Update" name = "submit" id = "register"></p>
		</form>	

		
		<?php
		// If the $valid flag is still true, then no errors were found so we want to update the database
		if ($valid) { 

			//$dbConn = mysqli_connect("localhost","aDey","2862884","adey_workshop"); // connect to the database server	
			if (mysqli_connect_errno()) {
				// Check for a connection error
				if (DEBUG_MODE){
					echo "Mysql database is not connected ".mysqli_connect_error();
				} else {
					// if not in debug mode, transfer to the user error page using the SITE_ROOT constant
					header("Location:".SITE_ROOT."show_error.html");
				}
				
			} else {
				if (DEBUG_MODE){
					echo "Database is connected!";
				}
			} 					
			mysqli_select_db($dbConn,"adey_workshop") or die(mysqli_error());
			// Check whether same student exists
			//$query = "select * from student where student_name = '$childName' and birthday = '$birthday' and contact = '$contactNo';";
			//$result = mysqli_query($dbConn, $query);
			//if (mysqli_num_rows($result)>0) {
			//	echo "<p>Student already exists. Please enter valid new student details </p>";
			//} else 			
			//Create the insert query and execute it
			$query = "Update student set student_name='$childName', gender='$gender', birthday='$birthday', student_city='$city', zipcode='$zipcode', contact=$contactNo where student_id = $student_id";
			$result = mysqli_query($dbConn, $query);
			//If the query is successful print out a Database Updated message
				
			if ($result) {
			// transfer to the list.php page
			header("Location:list.php?msg=update&student_id=$student_id");
			//clean out the buffer
			ob_end_clean();
			exit();
			} else {
			// If the query is not successful display the error.
					echo "<p class='error'>Unable to update database. ".mysql_error(). " </p>";
			}							
        } 
		// Otherwise, send the html form page to the browser from the buffer
		ob_end_flush();	
		?>
			
	</div>
</body>
</html>