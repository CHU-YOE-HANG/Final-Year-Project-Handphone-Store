<?php
include("dataconnect.php");

// 启用错误报告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Information</title>
    
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
</style>


<body>
<div id="navbar"></div>

    <script>
        fetch('A.menu.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navbar').innerHTML = data;
            });
    </script> 
    
<div class="container">
    <?php
    if(isset($_GET["id"])){
        $edit_id = $_GET["id"];
        $result = mysqli_query($connect, "SELECT * FROM user WHERE user_id = $edit_id");
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?> 

    <form name="editForm" method="post" action="">
        <h2>Edit Customer Information</h2><br><br>
        

        <p>User Name: <input type="text" name="name" value="<?php echo $row['username']; ?>" required></p><br>
        <p>Email: <input type="text" name="email" value="<?php echo $row['email']; ?>" required></p><br>
        <p>Phone Number: <input type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>"></p><br>
        <p>Gender:
            <select name="gender" required>
                <option value="UNKNOW" <?php if($row['gender'] == 'UNKNOW') echo 'selected'; ?>>Prefer not to say</option>
                <option value="MALE" <?php if($row['gender'] == 'MALE') echo 'selected'; ?>>MALE</option>
                <option value="FEMALE" <?php if($row['gender'] == 'FEMALE') echo 'selected'; ?>>FEMALE</option>
            </select>
        </p><br>
        <p>Address: <textarea name="address"><?php echo $row['address']; ?></textarea></p><br>
        <p>Password: <input type="text" name="password" value="<?php echo $row['password']; ?>"></p><br><br>

        <input type="submit" name="savebtn" value="UPDATE">
        <input type="reset" name="resetbtn" value="RESET"><br>
        
        <a class="btn backbtn" href="A.manageUser.php">Back</a>
        <a class="btn viewbtn" href="customer_detail.php?id=<?php echo $row['user_id']; ?>">View Information</a>
    </form>

    <?php
        }
    }
    ?>

    <?php
    if(isset($_POST['savebtn'])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone_number = $_POST["phone_number"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];
        $password = $_POST["password"];

        $update_query = "UPDATE user SET username='$name', email='$email', phone_number='$phone_number', gender='$gender', address='$address', password='$password' WHERE user_id='$edit_id'";

        if(mysqli_query($connect, $update_query)){
            echo '<script>alert("Customer information updated successfully!"); window.location.href = "customer_detail.php?id=' . $edit_id . '";</script>';
        } else {
            echo '<script>alert("Failed to update customer information: ' . mysqli_error($connect) . '");</script>';
        }
    }
    ?>

</div>

</body>
</html>
