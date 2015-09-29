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
if (!(is_numeric($student_id))) {
	echo "No student selected. Please go to the <a href='list.php'>display page</a> to select a product to update</p>";
	exit;
}
// retrieve the product data from the database
$result = mysqli_query($dbConn, "delete from student where student_id=".$_REQUEST['student_id']);
if ($result) {
	// transfer to the list.php page
	header("Location:list.php?msg=delete&student_id=$student_id");
	//clean out the buffer
	ob_end_clean();
	exit();
	} else {
		// If the query is not successful display the error.
		echo "<p class='error'>Unable to delet from database. ".mysql_error(). " </p>";
	}							
