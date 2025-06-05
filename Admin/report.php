<?php include("dataconnect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body{
            font-style: italic;

        }

        .admin-panel {
            padding: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }

        th, td {
            padding: 30px;
            text-align: left;
            border-bottom: 4px solid #ddd;
        }

        th {
            background-color:rgba(204, 73, 73, 0.76);
            color: white;
        }

        tr:hover {
            background-color:rgb(210, 177, 106);
        }

        .table-container {
            overflow-x: auto;
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
        .admin-panel-container
        {
            max-width: 1300px;
            margin: auto;
            padding: 20px;
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
    <section class="admin-panel-container">
        <h2>Report</h2>
        <div class="table-container">
            <form method="GET" class="search-sort-form">
    <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <select name="sort">
        <option value="">Sort by</option>
        <option value="name_asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
        <option value="name_desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'name_desc' ? 'selected' : '' ?>>Name: Z-A</option>
    </select>
    <button class="buttons" type="submit">Apply</button>
    <a class="button clear-button" href="ManageOrder.php">Clear Filters</a>
    </form>


    <table>
    <tr id="nophp" >
    <th>Date</th>
    <th>Buyers Name</th>
    <th>Order item</th>
    <th>Quantity</th>
    <th>Total Price</th>
    </tr>


    <?php
    mysqli_select_db($connect, "phone_shop");
    $search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $query = "SELECT * FROM payment";
    if (!empty($search)) {
    $query .= " WHERE UName LIKE '%$search%'";
    }
    if ($sort == 'name_asc') {
    $query .= " ORDER BY UName ASC";
    } elseif ($sort == 'name_desc') {
    $query .= " ORDER BY UName DESC";
    }

    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);
    while($row=mysqli_fetch_assoc($result)){
    ?>

    <tr>

    <td><?php echo  $row['Cdate']?></td>
    <td><?php echo  $row['UName']?></td>
    <td><?php echo  $row['Cphone']?></td>
    <td><?php echo  $row['Cquantity']?></td>
    <td><?php echo  $row['TPrice']?></td>
    

    </tr>

    <?php
    }
    ?>
    </table>
   </table>

</table>
<p> Number of customer : <?php echo $count; ?></p>
  

    
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
