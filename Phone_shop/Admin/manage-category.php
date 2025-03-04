<?php include("dataconnect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            font-style: italic;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #555;
        }

        h2{
            text-decoration: underline;
            
        }

        table{
            width: 100%;
            border-collapse: collapse;
            
        }

        th,td{
            border: 3px solid black;
            padding: 8px; 
            text-align: center;

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


    <section class="container">
        <bold><h2>Add New Phone Category</h2></bold>
        <form method="post" action="">
            <label for="category">Phone Category Name</label>
            <input type="text" id="category" name="brand_name" required><br></br>
            <label for="country">Phone Country Origin</label>
            <input type="text" id="country" name="country_origin" required>
            <button name="catergorys" type="submit" class="button">Add Category</button>
        </form>
        <br></br><h2>Phone Categories</h2>
        
        <?php
        
            echo "<table border='1'>";
            echo "<tr><th>Phone Model</th><th>Country</th></tr>";
            //SQL checkiing and take the details in brand information
            $result = mysqli_query($connect, "SELECT * FROM brand");
            //使用while循环遍历查询结果的每一行数据
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['brand_name']."</td>";
                echo "<td>".$row['country_origin']."</td>";
                echo "</tr>";
            }

            echo "</table>";
        ?>
        <?php
            if(isset($_POST["catergorys"])){
                $brand = $_POST['brand_name'];
                $country = $_POST['country_origin'];
                mysqli_query($connect, "INSERT INTO brand (brand_name, country_origin) VALUES ('$brand', '$country')");
                ?>
                
            <!-- This function will display the category saved-->
                <script type="text/javascript">
                    alert("<?php echo $brand; ?> saved");
                    window.location.replace("manage-category.php");
                </script>
                <?php
            }
        ?>
    </section>
</body>
</html>
