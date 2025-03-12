<?php include("dataconnect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        /* Internal CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
            margin: 0;
            padding: 0;
            font-style: italic;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        
 
        .product-listing {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product {
            background: #4bd3bc;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            width: 45%;
            margin: 20px 2%;
            padding: 20px;
            box-sizing: border-box;
        }
        .product img {
            max-width: 150px;
            border-radius: 5px;
        }
        .product-info {
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
        }
        .product-info h3 {
            margin: 0 0 10px 0;
        }
        .buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .button-buy {
            background: blue;
            color: #fff;
        }
        .button-buy:hover {
            background: darkblue;
        }
        .button-cart {
            background: #410418; /* Orange color */
            color: white;
        }
        .button-cart:hover {
            background: #064054; /* Darker shade of orange on hover */
        }
    </style>
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

    <div class="container">
        <section class="product-listing">

        <?php
                
$result = mysqli_query($connect, "SELECT products.*, brand.brand_name FROM products, brand WHERE products.brand = brand.id");

    while($row = mysqli_fetch_assoc($result))
{
        

?>

            <div id="<?php echo $row['id'] ?>" class="product">
                <img class="product-image" src="image/<?php echo $row['image'] ?>" alt="Huawei Mate 50 Pro">
                <div class="product-info">
                    <h3><?php echo $row['model_name'] ?></h3>
                    <p class="price">RM <?php echo $row['price'] ?></p>
                    <div class="buttons">
                    <button class="button button-cart" onclick="manageProduct(<?php echo $row['id'] ?>)">Add Product</button>
                    <button class="button button-cart" onclick="updateProduct(<?php echo $row['id'] ?>)">Update Product</button>
                    </div>
                </div>
            </div>
    
            <?php

        }
        ?>

        </section>
    </div>

    <script>
        function manageProduct(productId) {
            // 获取产品图像的 URL
            const productElement = document.getElementById(productId);
            const productImage = productElement.querySelector('.product-image').src;
            
            // 将图像 URL 保存到本地存储
            localStorage.setItem('productImage', productImage);
            
            // 跳转到 manage product.html
            window.location.href = 'manage_product.php';
        }
        function updateProduct(productId) {
            // 获取产品图像的 URL
            const productElement = document.getElementById(productId);
            const productImage = productElement.querySelector('.product-image').src;
            
            // 将图像 URL 保存到本地存储
            localStorage.setItem('productImage', productImage);
            
            // 跳转到 manage product.html
            window.location.href = "update.php?id=" + productId;
        }
    </script>
</body>
</html>
