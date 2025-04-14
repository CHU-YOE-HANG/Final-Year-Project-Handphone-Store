<?php include("dataconnect.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body{
            font-style: italic;
            font-size: 18px;
        }
        .admin-panel {
            padding: 30px;
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

        p{
            font-size:25px;
        }

        ul{
            font-size:20px;
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
    <section class="admin-panel container">
        <h2>Admin Manage</h2>
        <p>Only accessible by admin users.</p>
        <ul>
            <li>Manage users</li>
            <li>View reports</li>
            <li>System settings</li>
        </ul>
        <div class="table-container">
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Register Time</th>
                </tr>
                <?php
                    mysqli_select_db($connect, "phone_shop");
                    $result = mysqli_query($connect,"select * from user");
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row["username"];?></td>
                    <td><?php echo $row["address"];?></td>
                    <td><?php echo $row["phone_number"];?></td>
                    <td><?php echo $row["gender"];?></td>
                    <td><?php echo $row["email"];?></td>
                    <td><?php echo $row["registration_time"];?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
