<?php
// EDITME: change this to fit your database
// the three arguments are: computer, user, password
$db = mysqli_connect("localhost", "aDey","2862884","adey_workshop") or die(mysql_error());
// this is the database name to use
mysql_select_db("justliving",$db) or die(mysql_error());
?>