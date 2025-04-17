<?php include("dataconnect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        form.search-sort-form {
            margin-bottom: 30px;
            text-align: center;
        }

        form.search-sort-form input,
        form.search-sort-form select,
        .clear-button {
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
        }

        .clear-button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            text-align: center;
            padding: 14px 20px;
        }

        th {
            background-color: rgb(153, 106, 73);
            color: white;
            font-size: 20px;
        }

        tr {
            border-bottom: 2px solid #ddd;
        }

        tr:hover {
            background-color: rgb(232, 164, 56);
        }

        .product-image {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }

        .buttons button {
            padding: 19px 16px;
            margin-right: 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

       
        .button-update {
            background-color: #333;
            color: white;
        }

        .button-update:hover {
            background-color: rgb(27, 13, 70);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            font-size: 20px;
        }
    </style>
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

<div class="container">
    <h2>Product Listing</h2>

    <?php
    // handle filters
    $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $brand = isset($_GET['brand']) ? intval($_GET['brand']) : '';

    // get brands for dropdown
    $brand_result = mysqli_query($connect, "SELECT * FROM brand");
    $brand_names = [];
    while ($row = mysqli_fetch_assoc($brand_result)) {
        $brand_names[$row['id']] = $row['brand_name'];
    }
    ?>

    <!-- Search & Sort Form -->
    <form method="GET" class="search-sort-form">
        <input type="text" name="search" placeholder="Search phone..." value="<?= htmlspecialchars($search) ?>">

        <select name="brand">
            <option value="">All Brands</option>
            <?php foreach ($brand_names as $id => $name): ?>
                <option value="<?= $id ?>" <?= $brand == $id ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Sort by</option>
            <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
            <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
        </select>

        <button type="submit">Apply</button>
        <a href="productList.php" class="button clear-button">Clear Filters</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Model Name</th>
                <th>Brand</th>
                <th>Price (RM)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT products.*, brand.brand_name FROM products 
                JOIN brand ON products.brand = brand.id";
        $conditions = [];

        if ($search) {
            $conditions[] = "products.model_name LIKE '%$search%'";
        }
        if ($brand) {
            $conditions[] = "products.brand = $brand";
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        if ($sort == "price_asc") {
            $sql .= " ORDER BY products.price ASC";
        } elseif ($sort == "price_desc") {
            $sql .= " ORDER BY products.price DESC";
        }

        $result = mysqli_query($connect, $sql);
        while($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr id="<?php echo $row['id'] ?>">
                <td><img class="product-image" src="image/<?php echo $row['image'] ?>" alt="<?php echo $row['model_name'] ?>"></td>
                <td><?php echo $row['model_name'] ?></td>
                <td><?php echo $row['brand_name'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td class="buttons">
                    <button class="button-update" onclick="updateProduct(<?php echo $row['id'] ?>)">Update Product</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>

    function updateProduct(productId) {
        const productElement = document.getElementById(productId);
        const productImage = productElement.querySelector('.product-image').src;
        localStorage.setItem('productImage', productImage);
        window.location.href = "update.php?id=" + productId;
    }
</script>

<footer>
    <p>&copy; 2025 Mobile Website. All rights reserved.</p>
</footer>

</body>
</html>
