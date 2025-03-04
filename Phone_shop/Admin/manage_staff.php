<?php
include("dataconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANAGE STAFF</title>
    <link href="manage_staff.css" type="text/css" rel="stylesheet" />

<style>
    .btn {
    display: block;
    width: 100px;
    padding: 10px;
    margin: 10px auto;
    text-align: center;
    background-color:hsl(194, 82.30%, 15.50%);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    }
    .firstdiv {
    max-width: 1300px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .btn:hover {
    opacity: 0.8;
    }
    </style>

<div id="navbar"></div>


<script>
 fetch('A.menu.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('navbar').innerHTML = data;
        });

function confirmation()
{
	ans=confirm("Are you sure you want to put this employee into the resigned list?");
	return ans;
}
function delete_cfm(){
    ans=confirm("Are you sure you want to delete this employee record?");
	return ans;
}
function reinstate_cfm(){
    ans=confirm("Are you sure you want to reinstate this employee?");
	return ans;
}

function showaddbox(){
    var modal=document.getElementById("staffModal");
    if(modal.style.display==="none" || modal.style.display===""){
        modal.style.display="block";
    }else{
        modal.style.display="none";
    }
}
window.onclick = function(event) {
            var modal = document.getElementById("staffModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
function resignedlist(){
    var modal=document.getElementById("resigned_box");
    if(modal.style.display==="none" || modal.style.display===""){
        modal.style.display="block";
    }else{
        modal.style.display="none";
    }
}

</script>

</head>
<body>
   
<div class=firstdiv>
    <h2>Manage Staff</h2>
        <button class="addstaffbtn" onclick="showaddbox()">ADD STAFF</button >
        <button class="addstaffbtn" onclick="resignedlist()">Resigned employees</button >
        <table id="staff_table">
        <tr id="nophp">
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th colspan="3">Actions</th>
        </tr>
 <?php

 $result=mysqli_query($connect,"SELECT *FROM staff WHERE status='active'");
 $count=mysqli_num_rows($result);


 while($row=mysqli_fetch_assoc($result)){
?>

<tr  >
<th><?php echo $row["employee_id"]?></th>
<th><?php echo $row["name"]?></th>
<th><?php echo $row["email"]?></th>
<th><?php echo $row["role"]?></th>
<th><a class="btn viewbtn"href="staff_detail.php?id=<?php echo $row['employee_id']?>">VIEW</a></th>    
<th><a  class="btn editbtn"href="edit_staff.php?id=<?php echo $row['employee_id']?>">EDIT</a></th>  
<th><a class="btn removebtn"onclick="return confirmation()"; href="manage_staff.php?statusid=<?php echo $row['employee_id']?>">Remove</a></th>

    
</tr>
<?php
 }
if (isset($_GET["statusid"])) {
    include("dataconnect.php");
    echo '<script>alert("Remove successfully!");
             window.location.href = "manage_staff.php";</script>';
    $statusid = $_GET["statusid"];
    mysqli_query($connect, "UPDATE staff SET status='inactive' WHERE employee_id='$statusid'");

  
?>

<?php
 }
 ?>


</table>

<p id="numstaff"> Number of staff : <?php echo $count; ?></p>    

</div> 
<!--this is add staff window-->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="showaddbox()">&times;</span>
        <h2  id="addstaff_header">Add Staff</h2>
        <form method="POST" action="">
            <label >Name:</label><br>
            <input type="text" id="name" name="name" required><br>

            <label >Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label >Role:</label><br>
            <input type="text" id="role" name="role" required><br>

            <label >Gender:</label><br>
            <select  id="gender" name="gender" required>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
            </select><br>

            <label >Entry Time:</label><br>
            <input type="date" id="entry_time" name="entry_time" required><br>
           
            <label >Address:</label><br>
            <textarea  id="address" name="address" required></textarea><br>

            <label >Phone Number:</label><br>
            <input type="tel" id="phone_number" name="phone_number" required><br><br>

            <input type="submit" value="Add Staff">
        </form>
    </div>
</div>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $gender = $_POST["gender"];
    $entry_time = $_POST["entry_time"];
    $address = $_POST["address"];
    $phone = $_POST["phone_number"];
 $sql = "INSERT INTO staff (name, email, role, gender, entry_time, address, phone_number, status) 
                VALUES ('$name', '$email', '$role', '$gender', '$entry_time', '$address', '$phone', 'active')";
    // Check if email already exists

    $check_query = "SELECT * FROM staff WHERE email = '$email'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0 && !isset($_POST['confirm_add'])) {
        // Email already exists, generate JavaScript to confirm with user
        echo '<script>
                if (confirm("The email \'' . $email . '\' already exists. Are you sure you want to add it?")) {
                    var form = document.createElement("form");
                    form.method = "POST";
                    form.action = "manage_staff.php";

                    var inputs = [
                        {name: "name", value: "' . $name . '"},
                        {name: "email", value: "' . $email . '"},
                        {name: "role", value: "' . $role . '"},
                        {name: "gender", value: "' . $gender . '"},
                        {name: "entry_time", value: "' . $entry_time . '"},
                        {name: "address", value: "' . $address . '"},
                        {name: "phone_number", value: "' . $phone . '"},
                        {name: "confirm_add", value: "1"}
                    ];

                    inputs.forEach(function(inputData) {
                        var input = document.createElement("input");
                        input.type = "hidden";
                        input.name = inputData.name;
                        input.value = inputData.value;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert("Add canceled.");
                }
              </script>';
              
    } else {
        // Insert new staff if email does not exist or user confirmed adding duplicate
        $sql = "INSERT INTO staff (name, email, role, gender, entry_time, address, phone_number, status) 
                VALUES ('$name', '$email', '$role', '$gender', '$entry_time', '$address', '$phone', 'active')";

        if (mysqli_query($connect, $sql)) {
            echo '<script>alert("New staff added successfully!");
             window.location.href = "manage_staff.php";</script>';
            

        } else {
            echo '<script>alert("Failed to add staff: ' . mysqli_error($connect) . '");</script>';
        }
    }
    mysqli_close($connect);
}
?>


</div> 
<!--this is resigned list window-->
<div id="resigned_box" class="modal">
    <div class="modal-resigned">
        <span class="close" onclick="resignedlist()">&times;</span>
        <h2  id="addstaff_header">List of Resigned Employees </h2>
       <table>
       <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th colspan=4>Action</th>
      </tr> 
<?php
$resigned_result=mysqli_query($connect,"SELECT * FROM staff WHERE status='inactive'");

$count=mysqli_num_rows($resigned_result);

while($row=mysqli_fetch_assoc($resigned_result))
{
?>

<tr  >
<th><?php echo $row["employee_id"]?></th>
<th><?php echo $row["name"]?></th>
<th><?php echo $row["email"]?></th>
<th><?php echo $row["role"]?></th>

<th><a class="btn viewbtn"href="staff_detail.php?id=<?php echo $row['employee_id']?>">VIEW</a></th>    
<th><a class="btn editbtn"href="edit_staff.php?id=<?php echo $row['employee_id']?>">EDIT</a></th>  
 <th><a class="btn reinstatementbtn"onclick="return reinstate_cfm()" href="manage_staff.php?reinstateid=<?php echo $row['employee_id'] ?>">REINSTATE</a></th>
<th><a class="btn removebtn"onclick="return delete_cfm()"; href="manage_staff.php?deleteid=<?php echo $row['employee_id']?>">DELETE RECORD</a></th>


</tr>
<?php
 }
if (isset($_GET["reinstateid"])) {
   // include("connectstaff.php");

    $reinstateid = $_GET["reinstateid"];
    mysqli_query($connect, "UPDATE staff SET status='active' WHERE employee_id='$reinstateid' ");
   echo' <script>alert("Employee reinstated successfully!");
            window.location.href = "manage_staff.php";</script>';
?>

<?php
 }
 ?>

<?php
 
if (isset($_GET["deleteid"])) {
   // include("connectstaff.php");

    $deleteid = $_GET["deleteid"];
    mysqli_query($connect, "DELETE FROM staff WHERE employee_id=$deleteid");
   echo' <script>alert("Employee record deleted successfully!");
            window.location.href = "manage_staff.php";</script>';
?>

<?php
 }
 ?>
</table>

<p id="num_resignedstaff"> Number of staff : <?php echo $count; ?></p>    

    </div>
</div>

</body>
</html>