<?php 
include("dataconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order</title>
    <link href="manage_staff.css" type="text/css" rel="stylesheet" />

    <style>
    .btn {
    display: block;
    width: 110px;
    padding: 15px;
    margin: 15px auto;
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
    width: 110px;
    padding: 15px;
    margin: 15px auto;
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

    <div class="firstsiv">
    <h2>Manage Order</h2>


<table>
    <tr id="nophp" >
    <th>Order ID</th>
    <th>Name</th>
    <th>Order item</th>
    <th>Total Price</th>
    <th colspan="3">Actions</th>
    </tr>


    <?php
    mysqli_select_db($connect, "phone_shop");
    $result = mysqli_query($connect,"select * from payment");
    $count=mysqli_num_rows($result);
    while($row=mysqli_fetch_assoc($result)){
    ?>

    <tr>

    <th><?php echo  $row['ID']?></th>
    <th><?php echo  $row['UName']?></th>
    <th><?php echo  $row['Cphone']?></th>
    <th><?php echo  $row['TPrice']?></th>
    <th><a class="btn viewbtn" href="M.OrderDetail.php?id=<?php echo $row['ID']?>"> VIEW</a></th>
    

    </tr>

    <?php
    }
    ?>
</table>
    <p> Number of customer : <?php echo $count; ?></p>   
    </div>

    <footer>
        <p>&copy; 2025 Mobile Website. All rights reserved.</p>
    </footer>
</body>
</html>
