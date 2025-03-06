<?php 
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customer</title>
    <link href="manage_staff.css" type="text/css" rel="stylesheet" />

    <style>
    .btn {
    display: block;
    width: 110px;
    padding: 15px;
    margin: 15px auto;
    text-align: center;
    background-color:rgb(245, 140, 27);
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.firstsiv {
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

h2{
    font-size:35px;
}

</style>

<script>
function confirmation()
{
    ans=confirm("Are you sure you want to put this customer into the recycle bin?");
    return ans;
}

function delete_cfm(){
    ans=confirm("Are you sure you want to delete this record?");
    return ans;
}

function restore_cfm(){
    ans=confirm("Are you sure you want to restore this employee?");
    return ans;
}

function showaddbox(){
    var modal=document.getElementById("customerModal");
                       
    if(modal.style.display==="none"|| modal.style.display===""){
        modal.style.display="block";
    }else{
        modal.style.display="none";
    }
}

function recycle_binlist(){
    var modal=document.getElementById("recycle_box");
    if(modal.style.display==="none" || modal.style.display===""){
        modal.style.display="block";
    }else{
        modal.style.display="none";
    }
}


</script>
</head>
<body>
<div id="navbar"></div>

    <script>
        fetch('A.menu.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar').innerHTML = data;
            });
    </script> 

    <div class="firstsiv">
    <h2>Manage Customer</h2>

    <button onclick="showaddbox()">Add Customer</button>
    <button onclick="recycle_binlist()">Recycle Bin</button>

<table>
    <tr id="nophp" >
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone number</th>
    <th>Gender</th>
    <th colspan="3">Actions</th>
    </tr>

<?php
$result=mysqli_query($connect,"SELECT * FROM user WHERE status='active'");
$count=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result)){
?>

<tr>

<th><?php echo  $row['user_id']?></th>
<th><?php echo  $row['username']?></th>
<th><?php echo  $row['email']?></th>
<th><?php echo  $row['phone_number']?></th>
<th><?php echo  $row['gender']?></th>
<th><a class="btn viewbtn" href="customer_detail.php?id=<?php echo $row['user_id']?>"> VIEW</a></th>
<th><a class="btn editbtn" href="edit_customer.php?id=<?php echo $row['user_id']?>">EDIT</a></th>
<th><a class="btn removebtn" onclick="return confirmation()" href="A.manageUser.php?statusid=<?php echo $row['user_id']?>">REMOVE</a></th>

</tr>

<?php
}
if(isset($_GET["statusid"])){
    $statusid=$_GET["statusid"];
    mysqli_query($connect,"UPDATE user SET status='inactive' WHERE user_id=$statusid");
    echo '<script>alert("Remove successfully!"); window.location.href="A.manageUser.php";</script>';
}
?>
</table>
<p> Number of customer : <?php echo $count; ?></p>   
    </div>
    <!--this is add CUSTOMER window-->
<div id="customerModal" class="modal">

<div class="modal-content">
<span class="close" onclick="showaddbox()">&times;</span>
<h2 id="addcustomer_header">ADD CUSTOMER</h2><br>
<form method="POST" action="">

<label>User name</label>
<input type="text" id="name" name="name" required><br><br>

<label>Email</label>
<input type="text" name="email" required><br><br>

<label>Phone Number</label>
<input type="tel" id="phone" name="phone_number" required><br><br>

<label>Gender</label><br>
<select id="gender" name="gender" required>
<option value="UNKNOW">Prefer not to say</option>
<option value="MALE">MALE</option>
<option value="FEMALE">FEMALE</option>
</select><br><br>

<label>Address</label><br>
<textarea name="address"></textarea><br><br>

<label>Password</label><br>
<input type="password" name="password" required><br><br><br>

<input type="submit" value="Add Customer">

</form>

</div>
</div>



<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $password = $_POST["password"];

    $check_query = "SELECT * FROM user WHERE email = '$email'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo '<script>alert("Email already exists. Please use a different email address!");</script>';
    } else {
        
        $sql = "INSERT INTO user (username, address, phone_number, email, gender, password) 
                VALUES ('$name', '$address', '$phone_number', '$email', '$gender', '$password')";

        if (mysqli_query($connect, $sql)) {
            echo '<script>alert("New customer added successfully!"); window.location.href = "A.manageUser.php";</script>';
        } else {
            echo '<script>alert("Failed to add customer: ' . mysqli_error($connect) . '");</script>';
        }
    }

}
?>


<!--this is RECYCLE BIN list window-->
<div id="recycle_box" class="modal">
    <div class="modal-resigned">
        <span class="close" onclick="recycle_binlist()">&times;</span>
        <h2  id="addstaff_header">Recycle Bin</h2>
       <table>
       <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone number</th>
        <th>Gender</th>
        <th colspan="4">Actions</th>
      </tr> 
<?php
$resigned_result=mysqli_query($connect,"SELECT * FROM user WHERE status='inactive'");

$count=mysqli_num_rows($resigned_result);

while($row=mysqli_fetch_assoc($resigned_result))
{
?>

<tr>
<th><?php echo $row['user_id']?></th>
<th><?php echo $row['username']?></th>
<th><?php echo $row['email']?></th>
<th><?php echo $row['phone_number']?></th>
<th><?php echo $row['gender']?></th>

<th><a class="btn viewbtn" href="customer_detail.php?id=<?php echo $row['user_id']?>">VIEW</a></th>    
<th><a class="btn editbtn" href="edit_customer.php?id=<?php echo $row['user_id']?>">EDIT</a></th>  
<th><a class="btn restorebtn" onclick="return restore_cfm()" href="A.manageUser.php?reinstateid=<?php echo $row['user_id']?>">RESTORE</a></th>
<th><a class="btn removebtn" onclick="return delete_cfm()" href="A.manageUser.php?deleteid=<?php echo $row['user_id']?>">DELETE RECORD</a></th>

</tr>
<?php
 }
if (isset($_GET["reinstateid"])) {
    $reinstateid = $_GET["reinstateid"];
    mysqli_query($connect, "UPDATE user SET status='active' WHERE user_id='$reinstateid'");
    echo '<script>alert("Restore successfully!"); window.location.href="A.manageUser.php";</script>';
}

if (isset($_GET["deleteid"])) {
    $deleteid = $_GET["deleteid"];
    mysqli_query($connect, "DELETE FROM user WHERE user_id=$deleteid");
    echo '<script>alert("Customer record deleted successfully!"); window.location.href="A.manageUser.php";</script>';
}
?>
</table>

<p id="num_resignedstaff"> Number of customer : <?php echo $count; ?></p>    

    </div>
</div>

</body>
</html>
