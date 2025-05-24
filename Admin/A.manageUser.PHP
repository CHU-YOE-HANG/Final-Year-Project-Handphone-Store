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
        width: 100px;
        padding: 10px;
        margin: 10px auto;
        text-align: center;
        background-color:rgb(245, 140, 27);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        }

    .button
    {
        background-color:rgb(245, 140, 27);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        width: 200px;
        padding: 10px;
        margin: 10px auto;
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

    footer {
        text-align: center;
        padding: 20px;
        background-color: #333;
        color: #fff;
        font-size: 20px;
    }

    form.search-sort-form {
        margin-bottom: 30px;
        text-align: center;
    }

    form.search-sort-form input,
    form.search-sort-form select
    {
        padding: 10px 14px;
        margin: 6px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
            
    }

    form.search-sort-form button
    {
        background-color:rgb(179, 155, 84);
        padding: 10px 14px;
        margin: 6px;
    }

    .clear-button {
        text-decoration: none;
        background-color: #888;
        color: white;
        padding: 10px 14px;
        margin: 6px;
        border-radius: 8px;
        
    }

    .clear-button:hover {
        background-color: #555;
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
<div id="menu"></div>

    <script>
        fetch('A.menu.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('menu').innerHTML = data;
            });
    </script> 

    <div class="firstsiv">
    <h2>Manage Customer</h2>
    <form method="GET" class="search-sort-form">
    <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <select name="sort">
        <option value="">Sort by</option>
        <option value="name_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
        <option value="name_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : '' ?>>Name: Z-A</option>
    </select>
    <button class="buttons" type="submit">Apply</button>
    <a class="button clear-button" href="A.manageUser.php">Clear Filters</a>
    </form>
   
    <button class="button" onclick="recycle_binlist()">Recycle Bin</button>

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
$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$query = "SELECT * FROM register where status='active'";
if (!empty($search)) {
$query .= " AND Regis_Username LIKE '%$search%'";
}
if ($sort == 'name_asc') {
$query .= " ORDER BY Regis_Username ASC";
} elseif ($sort == 'name_desc') {
$query .= " ORDER BY Regis_Username DESC";
}
$result = mysqli_query($connect, $query);
$count=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result)){
?>

<tr>

<th><?php echo  $row['Regis_ID']?></th>
<th><?php echo  $row['Regis_Username']?></th>
<th><?php echo  $row['Regis_Email']?></th>
<th><?php echo  $row['Regis_ContactNumber']?></th>
<th><?php echo  $row['Regis_Gender']?></th>
<th><a class="btn viewbtn" href="customer_detail.php?id=<?php echo $row['Regis_ID']?>"> VIEW</a></th>
<th><a class="btn removebtn" onclick="return confirmation()" href="A.manageUser.php?statusid=<?php echo $row['Regis_ID']?>">REMOVE</a></th>

</tr>

<?php
}
if(isset($_GET["statusid"])){
    $statusid=$_GET["statusid"];
    mysqli_query($connect,"UPDATE register SET status='inactive' WHERE Regis_ID=$statusid");
    echo '<script>alert("Remove successfully!"); window.location.href="A.manageUser.php";</script>';
}
?>
</table>
<p> Number of customer : <?php echo $count; ?></p>   
    </div>
    

<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    

    $check_query = "SELECT * FROM register WHERE Regis_Email = '$email'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo '<script>alert("Email already exists. Please use a different email address!");</script>';
    } else {
        
        $sql = "INSERT INTO user (Regis_Username, Regis_AddressLine1, Regis_ContactNumber, Regis_Email, Regis_Gender) 
                VALUES ('$name', '$address', '$phone_number', '$email', '$gender')";

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
$resigned_result=mysqli_query($connect,"SELECT * FROM register WHERE status='inactive'");

$count=mysqli_num_rows($resigned_result);

while($row=mysqli_fetch_assoc($resigned_result))
{
?>

<tr>
<th><?php echo $row['Regis_ID']?></th>
<th><?php echo $row['Regis_Username']?></th>
<th><?php echo $row['Regis_Email']?></th>
<th><?php echo $row['Regis_ContactNumber']?></th>
<th><?php echo $row['Regis_Gender']?></th>

<th><a class="btn viewbtn" href="customer_detail.php?id=<?php echo $row['Regis_ID']?>">VIEW</a></th>     
<th><a class="btn restorebtn" onclick="return restore_cfm()" href="A.manageUser.php?reinstateid=<?php echo $row['Regis_ID']?>">RESTORE</a></th>
<th><a class="btn removebtn" onclick="return delete_cfm()" href="A.manageUser.php?deleteid=<?php echo $row['Regis_ID']?>">DELETE RECORD</a></th>

</tr>
<?php
 }
if (isset($_GET["reinstateid"])) {
    $reinstateid = $_GET["reinstateid"];
    mysqli_query($connect, "UPDATE register SET status='active' WHERE Regis_ID='$reinstateid'");
    echo '<script>alert("Restore successfully!"); window.location.href="A.manageUser.php";</script>';
}

if (isset($_GET["deleteid"])) {
    $deleteid = $_GET["deleteid"];
    mysqli_query($connect, "DELETE FROM register WHERE Regis_ID=$deleteid");
    echo '<script>alert("Customer record deleted successfully!"); window.location.href="A.manageUser.php";</script>';
}
?>
</table>

<p id="num_resignedstaff"> Number of customer : <?php echo $count; ?></p>    

    </div>
</div>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
