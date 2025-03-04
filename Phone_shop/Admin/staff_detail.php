<?php
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF DETAIL</title>
    <link href="view,edit_page.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div class="container">
    <h2>STAFF DETAIL</h2>
    <a class="btn backbtn" href="manage_staff.php">Back </a>
   
    <?php
		 if(isset($_GET['id']))//the button id
		{
			$staffdetail = $_GET["id"];
			$result=mysqli_query($connect,"SELECT *FROM staff WHERE employee_id=$staffdetail ");
			$row = mysqli_fetch_assoc($result);
		echo ' <a class="btn viewbtn" href="edit_staff.php?id='. $row['employee_id']. '">Edit Information</a>';
		echo "<p><b>ID</b> </p>";
      
		echo $row["employee_id"]; 
		echo "<p><b>STAFF NAME</b></p>";
	    echo $row["name"]; 

		echo "<p><b>EMAIL</b></p>";
		echo $row["email"]; 
		echo "<p><b>ROLE</b></p>";
		echo $row["role"]; 
		echo "<p><b>GENDER</b></p>";
		echo $row["gender"]; 

        echo "<p><b>Date of Joining</b></p>";
		echo $row["entry_time"]; 
        echo "<p><b>ADDRESS</b></p>";
		echo $row["address"]; 
        echo "<p><b>PHONE NUMBER</b></p>";
		echo $row["phone_number"]; 
        echo "<p><b>Employment Status</b></p>";
		if ($row["status"] == 'active') {
            echo '<p>ACTIVE</p>';
        } else {
            echo '<td>RESIGNED</td>';
        }
		 }
		?>





    </div>
</body>
</html>
