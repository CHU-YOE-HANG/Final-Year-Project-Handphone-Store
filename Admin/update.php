<?php include("dataconnect.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANAGE PRODUCTAL</title>
    <style>
        /* Internal CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(114, 114, 137);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            text-align: center; /* 居中对齐 */
            padding-top: 50px;
        }

        #productContainer img {
            max-width: 200px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #branding h1 {
            margin: 0;
            text-transform: uppercase;
        }

        .productdetail {
            width: 100%;
            max-width: 900px; /* Increase the max-width to widen the section */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px auto;
        }

        .product {
            margin: 20px 0;
            text-align: center;
        }

        .product img {
            max-width: 50%;
            height: auto;
        }

        .product-description {
            margin: 20px 0;
            text-align: center;
        }

        .product-description h3 span {
            color: red; /* Change dollar sign color to red */
        }

        .product-description h4 {
            text-decoration: underline;
            color: blue;
        }

        .product-description h5 {
            color: green;
        }

        .product-description h5 span {
            font-weight: bold;
            font-style: italic;
            color: black;
        }

        .buy-now-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #e8491d;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
        }

        .buy-now-button:hover {
            background-color: blue;
        }

        .wireframe {
            background-color:rgb(135, 124, 120);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 900px;
        }

        .wireframe h2 {
            text-align: center;
            color: #333;
        }

        .wireframe form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .wireframe label {
            font-weight: bold;
            color: #333;
        }

        .wireframe input[type="text"], .wireframe input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button-group .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            margin: 5px;
        }

        .button-group button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #e8491d;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
        }

        .button-group button:hover {
            background-color: blue;
        }

        .button-group a {
            margin-top: 5px;
            font-size: 14px;
            color: #333;
            text-decoration: underline;
            cursor: pointer;
        }

        .button-group a:hover {
            color: #e8491d;
        }

        @media (max-width: 600px) {
            .item {
                flex-direction: column;
                align-items: flex-start;
            }

            .item img {
                margin-bottom: 10px;
            }
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

    
  
    <div class="wireframe">
        <div id="right">
            <?php
            if(isset($_GET["id"])) {
                $products = $_GET["id"];
                $result = mysqli_query($connect, "SELECT * FROM products WHERE id = $products");
                $row = mysqli_fetch_assoc($result);
            ?>

    
            <?php 
            }
            ?>

            <form action="update.php" method="post">
                <label for="brand">Brand:</label>
                    <select name="brand">
                      <option>Choose the brand</option>
                    <?php 
                
                    $result = mysqli_query($connect, "SELECT * FROM brand");

                        while($rowbrand = mysqli_fetch_assoc($result))
			    	{
						if($rowbrand['id']==$row['brand'])
                        {
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                        echo "<option $selected value='".$rowbrand['id'] ."'>". $rowbrand['brand_name'] ."</option>";
                        
                    }
                ?>
                    </select>
                <label for="model_name">Model Name:</label>
                <input type="text" name="model_name" value="<?php echo $row['model_name']; ?>">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>">
                <label for="price">Price:</label>
                <input type="number" name="price" value="<?php echo $row ['price'];?>">
                <input type="hidden" name="productId" value="<?php echo $row['id'];?>">
            
                <div class="button-group">
                    <div class="button-container">
                        <button type="submit" name="updateP" value="Update Product">Update Product</button>
                        <a href="#" id="product-detail">Product Detail</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
    
</body>
</html>

<?php 
if(isset($_POST["updateP"])) {
    $products = $_POST['productId'];
    $modelname = $_POST['model_name'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $query = "UPDATE products SET model_name='$modelname', brand='$brand', quantity=$quantity, price=$price WHERE id=$products";
    echo "$products";
    if (mysqli_query($connect, $query)) {
        ?>
        <script type="text/javascript">
            alert("<?php echo $modelname . ' updated' ?>");
            window.location.replace("productList.php");
        </script>
        <?php
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}
?>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
