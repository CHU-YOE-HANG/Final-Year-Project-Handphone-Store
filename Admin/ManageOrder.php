<?php include("dataconnect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="A.ManageOrder.css">
</head>

<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        margin: 0;
        padding: 0;
        background-color: #f7f7f7;
        
    }

    main {
        max-width: 1000px;
        margin: 70px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: whitesmoke;
        background-color: #2d0865;
        border-top: 10px solid black;
        border-bottom: 10px solid black
    }

    form {
        margin-bottom: 120px;
    }

    form label {
        display: block;
        margin-bottom: 10px;
    }

    form input[type="text"], form input[type="number"] {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 5px solid #ccc;
    }

    form button {
        padding: 20px 30px;
        border: none;
        background-color: hwb(164 15% 44%);
        color: #fff;
        border-radius: 20px;
        cursor: pointer;
        margin: 30px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }   

    ul li {
        margin-bottom: 15px;
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
    
    <div id="menu"></div> <!-- 添加空的 div 来放置加载的菜单 -->
      
    <script>
        fetch('A.menu.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('menu').innerHTML = data;
            });
    </script>
    
    
    <main>
        <section id="view">
            <h2>View Orders</h2>
            <form method="post" action="A.ManageOrder.php#view">
                <label for="customer-id">Customer ID:</label>
                <input type="number" id="customer-id" name="customer-id" required>
                <label for="customer-name">Customer Name:</label>
                <input type="text" id="customer-name" name="customer-name" required>
                <button type="submit" name="view-orders">View Orders</button>
            </form>

            <?php
            if (isset($_POST['view-orders'])) {
                $customer_id = mysqli_real_escape_string($connect, $_POST['customer-id']);
                $customer_name = mysqli_real_escape_string($connect, $_POST['customer-name']);

                // SQL query to fetch orders based on customer ID and name
                $query = "SELECT * FROM payment WHERE ID = '$customer_id' AND Cname = '$customer_name'";
                $result = mysqli_query($connect, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<ul>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "{$row['Cphone']} - Quantity: {$row['Cquantity']}";
                        }
                        echo "</ul>";
                    } else {
                        echo "No orders found for the given customer ID and name.";
                    }
                } else {
                    echo "Error: " . mysqli_error($connect);
                }
            }
            ?>
        </section>
        <section id="delete">
            <h2>Delete Order</h2>
            <form method="post" action="A.ManageOrder.php">
                <label for="delete-order-id">Order ID:</label>
                <input type="number" id="delete-order-id" name="delete-order-id" required>
                <button type="submit" name="delete">Delete</button>
            </form>

            <?php
            if (isset($_POST['delete'])) {
                $order_id = mysqli_real_escape_string($connect, $_POST['delete-order-id']);

                // SQL query to delete the order
                $query = "DELETE FROM payment WHERE ID = '$order_id'";

                if (mysqli_query($connect, $query)) {
                    echo "Order deleted successfully.";
                } else {
                    echo "Error deleting order: " . mysqli_error($connect);
                }
            }
            ?>
        </section>
        <section id="update">
            <h2>Update Order</h2>
            <form method="post" action="A.ManageOrder.php">
                <label for="update-order-id">Customer ID:</label>
                <input type="number" id="update-order-id" name="update-order-id" required>
                <label for="product-id">Product ID:</label>
                <input type="number" id="product-id" name="product-id" required>
                <label for="product-quantity">Quantity:</label>
                <input type="number" id="product-quantity" name="product-quantity" required>
                <button type="submit" name="update">Update</button>
            </form>

            <?php
            if (isset($_POST['update'])) {
                $order_id = mysqli_real_escape_string($connect, $_POST['update-order-id']);
                $product_id = mysqli_real_escape_string($connect, $_POST['product-id']);
                $product_quantity = mysqli_real_escape_string($connect, $_POST['product-quantity']);

                // SQL query to fetch product details based on product ID
                $product_query = "SELECT quantity, model_name FROM products WHERE id = '$product_id'";
                $product_result = mysqli_query($connect, $product_query);

                if ($product_result && mysqli_num_rows($product_result) > 0) {
                    $product_row = mysqli_fetch_assoc($product_result);
                    $new_quantity = $product_quantity; // Use the user-provided quantity
                    $new_phone = $product_row['model_name'];

                    // SQL query to update the order
                    $update_query = "UPDATE payment SET Cquantity = '$new_quantity', Cphone = '$new_phone' WHERE ID = '$order_id'";

                    if (mysqli_query($connect, $update_query)) {
                        echo "Order updated successfully.";
                    } else {
                        echo "Error updating order: " . mysqli_error($connect);
                    }
                } else {
                    echo "Error fetching product details: " . mysqli_error($connect);
                }
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
