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
            margin-bottom: 5px;
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
        <h2>Add New Category</h2>
        <form method="post" action="">
            <label for="category">Category Name</label>
            <input type="text" id="category" name="brand_name" required>
            <label for="country">Country Origin</label>
            <input type="text" id="country" name="country_origin" required>
            <button name="catergorys" type="submit" class="button">Add Category</button>
        </form>
        <h2>Existing Categories</h2>
        <?php
            $result = mysqli_query($connect, "SELECT * FROM brand");
            while($row = mysqli_fetch_assoc($result)) {
                echo "<ul><li><p>".$row['brand_name']."<br>".$row['country_origin']."</p></li></ul>";
            }
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
