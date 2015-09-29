

<?php

// view for products form display

function product_form_display($type,$prodId,$catId,$productCode,$productName,$desc,$listPrice,$discPercent,$date,$validate,$valid,$currDate) {

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
</head>
<body>
<header>
   <h1>Update Product</h1>
</header>
<div>
<form method="post" action="<?php
   // $type is add or update passed from the calling script
   echo $type; ?>.php">
<p><label>Category ID: <select name="catId">
   <option value="1" <?php  if ($catId == 1) {echo "selected";} ?>>Guitars</option>
   <option value="2" <?php  if ($catId == 2) {echo "selected";} ?>>Basses</option>
   <option value="3" <?php  if ($catId == 3) {echo "selected";} ?>>Drums</option>
   <option value="4" <?php  if ($catId == 4) {echo "selected";} ?>>Keyboards</option>   
</select></label>

<?php

if ($validate) {
   // Check to see if the category ID is numeric. If not, write an error message and set the $valid flag to false
   if (!is_numeric($catId)) {
      echo "<span class='error'>Category Id must be numeric</span>";
      $valid = false;
   }
}

?>
</p>
<p><label>Product Code: <input type="text" name="prodCode" value="<?php echo $productCode ?>"></label>
   <?php if ($validate) {

      // Make sure they entered something in the product code. If not, write error message and set $valid = false
      if (empty($productCode)) {
         echo "<span class='error'>Product Code is required</span>";
         $valid = false;
      }
      // Make sure the product code is not too long for the database
      if (strlen($productCode) > 10) {
         echo "<span class='error'>Product Code has a maximum length of 10</span>";
         $valid = false;
      }
 } ?></p>
<p><label>Product Name: <input type="text" name="prodName" value="<?php echo $productName ?>"></label>
      <?php if ($validate) {

         // Make sure they entered something in the product name. If not, write error message and set $valid = false
         if (empty($productName)) {
            echo "<span class='error'>Product Name is required</span>";
            $valid = false;
         }
      // Make sure the product Name is not too long for the database
      if (strlen($productName) > 255) {
         echo "<span class='error'>Product Name has a maximum length of 255</span>";
         $valid = false;
      }
   } ?></p>
<p><label>Description: <textarea name="desc" cols="60"><?php echo $desc ?></textarea></label>
   <?php if ($validate) {

      // Make sure they entered something in the description. If not, write error message and set $valid = false
      if (empty($desc)) {
         echo "<span class='error'>Description is required</span>";
         $valid = false;
      }
   } ?></p>
<p><label>List Price <input type="text" name="listPrice"  value="<?php echo $listPrice ?>"></label>
   <?php if ($validate) {

      // Check list price for numeric and maximum value
      if (!is_numeric($listPrice)) {
         echo "<span class='error'>List price must be numeric</span>";
         $valid = false;
      }
      if ($listPrice > 99999999.99) {
         echo "<span class='error'>List price exceeds maximum allowed</span>";
         $valid = false;
      }
   } ?> </p>
<p><label>Discount Percent: <input type="text" name="discPercent"  value="<?php echo $discPercent ?>"></label>
   <?php if ($validate) {
         // Check discount percent for numeric. If not, set to 0
         if (!is_numeric($discPercent)) {
            $discPercent = 0.00;
         }
         //Check discount percent for maximum value
         if ($discPercent > 100.00) {
            echo "<span class='error'>Discount percent cannot exceed 100%</span>";
            $valid = false;
         }
      } ?> </p>
<p><label>Date: <input type="text" name="date" placeholder="YYYY-MM-DD"  value="<?php echo $date; ?>"></label> 
or Use current date <input type="checkbox" name="currDate" value="y" 
<?php if ($validate) {
   if ($currDate == 'y') {
      echo "checked";
   } ?> ></label><?php

   // call the date validation function
   $dateValid = valid_date($date);
   if (!$dateValid) {
      $valid=false;
   }
} ?> </p>
<p><input type="hidden" name="prodId" value="<?php echo $prodId ?>">
<input type="submit" name="submit" value="<?php echo $type; ?> Product"></p>
</form>
</div>
<footer>
   <p>Unit I Example</p>
</footer>
</body>
</html>

<?php
   // return valid flag back to calling script
   return $valid;
}

// date validation

function valid_date($date) {

   $valid = true;
   if (!preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $date)) {
      echo "<span class='error'>Date must be in the format YYYY-MM-DD</span>";
      $valid = false;
   } else {
      // Split date into array based on the -
      $dateArray = preg_split('/-/', $date);
      // Get the year and test for 1950-2050
      if ($dateArray[0] < 1950 || $dateArray[0] > 2050) {
         echo "<span class='error'>Year must be between 1950 and 2050</span>";
         $valid = false;
      }
      // Check the month for 1 - 12
      if ($dateArray[1] < 1 || $dateArray[1] > 12) {
         echo "<span class='error'>Month must be between 01 and 12</span>";
         $valid = false;
      }
      // Check the day for 1 - 31
      if ($dateArray[2] < 1 || $dateArray[2] > 31) {
         echo "<span class='error'>Day must be between 01 and 31</span>";
         $valid = false;
      }
   }
   return $valid;
}

?>
