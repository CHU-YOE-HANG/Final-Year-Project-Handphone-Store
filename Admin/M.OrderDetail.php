<?php
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMER ORDER DETAILS</title>
    
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 从本地存储中获取产品图像 URL
        const productImage = localStorage.getItem('productImage');
        
        if (productImage) {
            // 创建图像元素并添加到页面
            const imgElement = document.createElement('img');
            imgElement.src = productImage;
            imgElement.alt = 'Product Image';
            imgElement.style.maxWidth = '200px';
            
            // 将图像元素添加到 productContainer
            document.getElementById('productContainer').appendChild(imgElement);
        }
    });
</script>

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
    <h2>CUSTOMER ORDER DETAILS</h2>

    <?php
    if(isset($_GET['id'])) {
        $customer_id = $_GET['id'];
        $result = mysqli_query($connect, "SELECT * FROM payment WHERE ID = $customer_id");
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            echo "<p><b>ID</b> </p>";
            echo $row["ID"];
            echo "<p><b>CUSTOMER NAME</b></p>";
            echo $row["UName"];
            echo "<p><b>Order Item</b></p>";
            echo $row["Cphone"];
            echo "<p><b>Price</b></p>";
            echo $row["Cprice"];
            echo "<p><b>Order Date</b></p>";
            echo $row["Cdate"];
            echo "<p><b>billing Address</b></p>";
            echo $row["billing_address"];
            echo "<p><b>Total Price</b></p>";
            echo $row["TPrice"];

        }
        
    }
    
    ?>
    <a class="btn backbtn" href="ManageOrder.php">Back </a>
   
    </div>

    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
