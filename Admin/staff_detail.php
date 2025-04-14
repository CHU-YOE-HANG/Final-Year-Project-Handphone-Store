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

<style>

			

body {
    background-color: rgb(233, 236, 239);
    padding: 30px;
}

.container {
    max-width: 800px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
	font-size:35px;
}

p {
    margin: 10px 0;
    font-size: 18px;

}

.btn {
    display: block;
    width: 100px;
    padding: 20px;
    margin: 10px auto;
    text-align: center;
    background-color: #0a0a56;
    color: white;
    text-decoration: none;
    border-radius: 5px;
	
}

.btn:hover {
    opacity: 0.8;
}

b {
    display: block;
    margin: 10px 0;
}

footer {
        text-align: center;
        padding: 20px;
        background-color: #333;
        color: #fff;
        font-size: 20px;
    }

</style>

<body>
    <div class="container">
    <h2>STAFF DETAIL</h2>
    
   
    <?php
		 if(isset($_GET['id']))//the button id
		{
			$staffdetail = $_GET["id"];
			$result=mysqli_query($connect,"SELECT *FROM staff WHERE employee_id=$staffdetail ");
			$row = mysqli_fetch_assoc($result);
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

		 echo ' <a class="btn viewbtn" href="edit_staff.php?id='. $row['employee_id']. '">Edit Information</a>';
		?>

		<a class="btn backbtn" href="manage_staff.php">Back </a>


    </div>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
