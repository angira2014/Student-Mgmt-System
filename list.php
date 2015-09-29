<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" href="../styles.css">
   <script>
      // Javascript function to display confirmation box for delete
      function delete_student(student_id) {
         // display confirmation box
         if (confirm("Are you sure you want to delete this product?\nThere's really no going back!")) {
            // transfer to delete_product script
            window.location = "delete_product.php?student_id="+ student_id;
        }
      }
   </script>
</head>
<body>
   <header>
      <h1>Display all Students</h1>
   </header>
   <div id="msgDiv">
      <?php
         // check to see if a message was passed via the querystring
         if (filter_has_var(INPUT_GET,"msg")) {
            // based on the msg variable display the appropriate message
            switch ($_REQUEST['msg']) {
               case 'update':
                    echo "<p>Student ".$_REQUEST['student_id']." has been updated.</p>";
                    break;
               case 'delete':
                    echo "<p>Student ".$_REQUEST['student_id']." has been deleted.</p>";
                    break;
               case 'add':
                    echo "<p>Student ".$_REQUEST['student_id']." has been added.</p>";
            }
         }
      ?>
   </div>
   <p><a href="add.php">Add new Student</a></p>
   <table>
      <tr><th>Student Id</th><th>Student Name</th><th>Gender</th><th>Birthday</th><th>City</th><th>Zipcode</th><th>Contact</th></tr>
      <?php
         require_once 'models.php';
         // call the database connection script (modularization)
         $dbConn = dbConnect();
		 // retrieve all products from the database
         $query = "Select * from student";
         $result=mysqli_query($dbConn,$query);
		 //echo $result;
         // $class is used to style the table with alternating background colors
         $class = "even";
         // check to make sure the database retrieval was successful
         if ($result) {
            // loop through the query results
            while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
                // more styling - odd and even rows
                //if ($class == "even") {
                //  $class = "odd";
                //} else {
                //  $class = "even";
                //}
                //echo "<tr class='$class'>";
                // display the category name based on the category id
                /*switch ($row['category_id']) {
                   case 1:
                      $cat = "Guitars";
                      break;
                   case 2:
                      $cat = "Basses";
                      break;
                   case 3:
                      $cat = "Drums";
                      break;
                   case 4:
                      $cat = "Keyboards";
                      break;
                   default:
                      $cat = "";
                }*/
                // display the database data in table cells
                echo "<td>".$row['student_id']."</td><td>".$row['student_name']."</td><td>".$row['gender']."</td><td>".$row['birthday']."</td><td>".$row['student_city']."</td><td>".$row['zipcode']."</td><td>".$row['contact']."</td>";
                // display the update links with the product Id in the querystring
                echo "<td><a href='update.php?student_id=".$row['student_id']."'>Update</a></td>";
                // display the link button that calls the JavaScript link to delete the product
                echo "<td><a href='javascript:delete_student(".$row['student_id'].")'>Delete</a></td>";
                echo "</tr>";
            } // end while
         }
      ?>
      </table>
   <footer>
       <p>Lab I Example: Student Display</p>
   </footer>
</body>
</html>