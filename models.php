<?php

// dbConnect connects to MySQl and selects the database.
function dbConnect() {
   $dbConn = mysqli_connect("localhost", "aDey","2862884","adey_workshop") or die(mysql_error());
   //mysql_select_db("adey_workshop") or die(mysql_error());
   return $dbConn;
}

// update_products model updates the products table using input from the calling program.
function update_products($studentid, $studentname, $gender,$birthday,$contact,$dbConn) {
	
    $result = mysqli_query($dbConn, $query);
    return $result;
}

// delete_product model deletes a product from the products table
function delete_product($prodId) {
    $query = "Delete from products where product_id =$prodId";
    $result=mysql_query($query);
    // if one row was deleted, return true to let the calling script know it was successful. Else return false
    if (mysql_affected_rows() == 1) {
       return true;
    } else {
       return false;
    }
}

?>
