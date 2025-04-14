<?php
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER DETAIL</title>
    
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
    
<div id="menu"></div>

<script>
    fetch('A.menu.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu').innerHTML = data;
        });
</script> 



    <div class="container">
    <h2>CUSTOMER DETAIL</h2>

    <?php
    if(isset($_GET['id'])) {
        $customer_id = $_GET['id'];
        $result = mysqli_query($connect, "SELECT * FROM user WHERE user_id = $customer_id");
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            echo "<p><b>ID</b> </p>";
            echo $row["user_id"];
            echo "<p><b>CUSTOMER NAME</b></p>";
            echo $row["username"];
            echo "<p><b>EMAIL</b></p>";
            echo $row["email"];
            echo "<p><b>PHONE NUMBER</b></p>";
            echo $row["phone_number"];

            echo "<p><b>GENDER</b></p>";
            echo $row["gender"];

            echo "<p><b>ADDRESS</b></p>";
            echo $row["address"];
            echo "<p><b>Registration Time</b></p>";
            echo $row["registration_time"]; 
            
        }
        
    }
    
    ?>
    <a class="btn backbtn" href="A.manageUser.php">Back </a>
   
    </div>

    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
