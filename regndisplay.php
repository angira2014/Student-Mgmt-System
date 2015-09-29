<html>
<head>
<title>Registration</title>
<link rel = "stylesheet" href = "style.css" type =  "text/css" />	
</head>
<body>
<?php

// include config file
require_once "config.php";

// retrieve the product id from the querystring
$student_no = $_GET['student_id'];

// include config file
require_once "config.php";

if (DEBUG_MODE){
	echo "Inside regndisplay.php";
} 
	

// include the database connection file
// require_once 'dbconn.php';

$dbConn = mysqli_connect("localhost","aDey","2862884","adey_workshop"); // connect to the database server	
if (mysqli_connect_errno()) {
	// Check for a connection error
	if (DEBUG_MODE){
		echo "Mysql database is not connected ".mysqli_connect_error();
	} else {
	// if not in debug mode, transfer to the user error page using the SITE_ROOT constant
	header("Location:".SITE_ROOT."show_error.html");
	}
} 
else {
	if (DEBUG_MODE){
		echo "Database is connected!";
		echo $student_no;
	}		
} 	

// Create the insert query and execute it
$query = "SELECT * from student WHERE student_id='$student_no'";
//echo $query;
$result = mysqli_query($dbConn, $query);

// if query was successful
 if ($result) {

    // get the results from the query (only 1 row)
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $student_id = $row['student_id'];
    $student_name = html_entity_decode($row['student_name']);
	$gender = $row['gender'];
    $birthday = $row['birthday'];
	//$city = $row['city'];
    $contact = $row['contact'];
	
	// get filename from database
	$filename = $row['student_img'];
	
    if (DEBUG_MODE){
		echo "Inside level 1 if loop";
	}

   // Write out the information to the page
    echo "<div id = 'content'>";
    echo "<h3>Student added Successfully !</h3>";
    echo "<table>";
    echo "<tr><th>Student Id:</th><td>$student_id</td></tr>";
    echo "<tr><th>Student Name:</th><td>$student_name</td></tr>";
	echo "<tr><th>Gender:</th><td>$gender</td></tr>";
    echo "<tr><th>Birthday:</th><td>$birthday</td></tr>";
	echo "<tr><th>Contact:</th><td>$contact</td></tr>";
	// display image on page
	echo "<p><img src='uploadedImages/$filename' alt='product image'></p>";
    echo "</table>";
	echo "</div>";
} else {

   // If the query is not successful display the error.
   if (DEBUG_MODE){
		echo "<p>Unable to retrieve inserted record. ".mysql_error(). " </p>";
	} else {
	// if not in debug mode, transfer to the user error page using the SITE_ROOT constant
	header("Location:".SITE_ROOT."show_error.html");
}	
 }
?>
</body>
</html>