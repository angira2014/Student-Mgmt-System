

<?php
// start buffering
ob_start();
// include views and models
require_once('views.php');
require_once('models.php');
// call dbConnect model to connect to database
dbConnect();

// checks to see if the form has been submitted to do validation
if (isset($_POST['submit'])) {
   //Create a flag to determine if the data is valid. Assume it is valid to start
   $valid = true;
   // Create a flag to determine if the data will be validated (ie. user entry)
   $validate = true;
   // retrieve the data from the form and trim any whitespace
   $catId = trim($_REQUEST['catId']);
   $productCode = trim($_REQUEST['prodCode']);
   $productName = trim($_REQUEST['prodName']);
   $desc = trim($_REQUEST['desc']);
   $listPrice = trim($_REQUEST['listPrice']);
   $discPercent = trim($_REQUEST['discPercent']);
   $prodId = $_REQUEST['prodId'];

   // check currDate checkbox to see if checked, if so, set $date to current date else get date from form field.
   if (isset($_REQUEST['currDate'])) {
      $currDate = $_REQUEST['currDate'];
      $date = date('Y-m-d');
   } else {
      $date = trim($_REQUEST['date']);
      $currDate = 'n';
   }
} else {
   // if first time user comes to page (i.e. form not submitted), get product id from querystring
   $prodId = $_GET['prodId'];
   if (!(is_numeric($prodId))) {
      echo "No product selected. Please go to the <a href='list.php'>display page</a> to select a product to update</p>";
      exit;
   }
   // retrieve the product data from the database
   $result = mysql_query("select * from products where product_id=".$_REQUEST['prodId']);
   if ($result) {
      $row = mysql_fetch_array($result);
      $catId = $row['category_id'];
      $productCode = $row['product_code'];
      $productName =$row['product_name'];
      $desc = $row['description'];
      $listPrice = $row['list_price'];
      $discPercent =$row['discount_percent'];
      $date = $row['date_added'];
      $currDate ="n";
      //set valid flag to false so form will display
      $valid = false;
      // set flag to ignore validation
      $validate = false;
   } else {
      echo "Product not found. Please go to the <a href='list.php'>display page</a> to select another product to update</p>";
      exit;
   }
}

// call the view to display the form
$valid = product_form_display('Update',$prodId,$catId,$productCode,$productName,$desc,$listPrice,$discPercent,$date,$validate,$valid,$currDate);

// if everything is valid, update database
if ($valid) {
   // Call the update model function
   $desc = htmlentities($desc,ENT_QUOTES);
   $result = update_products($studentid, $studentname, $gender,$birthday,$contact,$dbConn);

   // If the query is successful 
   if ($result) {
      // transfer to the list.php page
      header("Location:list.php?msg=update&prodCode=$productCode");
      //clean out the buffer
      ob_end_clean();
      exit();
   } else {
      // If the query is not successful display the error.
      echo "<p class='error'>Unable to update database. ".mysql_error(). " </p>";
   }
}

// if not valid or first time through, send the html form page to the browser from the buffer
ob_end_flush();

?>
