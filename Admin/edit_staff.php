<?php
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT STAFF INFORMATIONS</title>
    <link href="view,edit_page.css" type="text/css" rel="stylesheet" />


</head>
<body>
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

<div class="container">
   <?php
if(isset($_GET["id"])){
$edit_id=$_GET["id"];
$result=mysqli_query($connect,"SELECT *FROM staff WHERE employee_id=$edit_id");
$row=mysqli_fetch_assoc($result);
?> 

<form name=thefrm method="post" action="">
<h2>EDIT STAFF INFORMATIONS</h2>


<p>Staff Name:<input type="text" name="name"  value="<?php echo $row['name'];?>"> </p>

<p>Email:<input type="text" name="email"  value="<?php echo $row['email'];?>"> </p>
<p>Role:<input type="text" name="role"  value="<?php echo $row['role'];?>"> </p>

<!-- Gender selection -->
<p>Gender:
    <select name="gender">
        <option value="MALE" <?php if($row['gender'] == 'MALE') echo 'selected'; ?>>MALE</option>
        <option value="FEMALE" <?php if($row['gender'] == 'FEMALE') echo 'selected'; ?>>FEMALE</option>
    </select>
</p>

<p>Date of Joining:<input type="date" name="entry_time"  value="<?php echo $row['entry_time'];?>"> </p>
<p>Address:<br><textarea  name="address"  ><?php echo $row['address'];?></textarea> </p>
<p>Phone Number:<input type="text" name="phone_number"  value="<?php echo $row['phone_number'];?>"> </p>

<!-- Employee status selection -->
<p>Employee Status:
    <select name="status">
        <option value="active" <?php if($row['status'] == 'active') echo 'selected'; ?>>Active</option>
        <option value="inactive" <?php if($row['status'] == 'inactive') echo 'selected'; ?>>Resigned</option>
    </select>
</p>

<p><input type="submit" name="savebtn" value="UPDATE"></p>
<p><input type="reset" name="resetbtn" value="RESET" /></p>

    <a class="btn backbtn" href="manage_staff.php">Back</a>
    <a class="btn viewbtn" href="staff_detail.php?id=<?php echo $row['employee_id']?>">View Information</a>
</form>

<?php
}
?>
</div>
<?php
if(isset($_POST['savebtn'])){
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $gender = $_POST["gender"];
    $entry_time = $_POST["entry_time"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $status = $_POST["status"];
mysqli_query($connect,"UPDATE staff SET name='$name', email='$email', role='$role', gender='$gender', entry_time='$entry_time', address='$address', phone_number='$phone_number', status='$status' WHERE employee_id='$edit_id'");
?>
		<script >
			alert("Successfully updated the staff's information.");
            window.location.href = "staff_detail.php?id=<?php echo $row['employee_id']?>";</script>
                                    <!--change to the staff_detaill page-->
<?php

}
?>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>