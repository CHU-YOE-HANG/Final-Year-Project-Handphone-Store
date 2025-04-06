<?php include("dataconnect.php");

if(isset($_POST["savebtn"])) {
    $modelname = $_POST['model_name'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    mysqli_query($connect, "INSERT INTO products (model_name, brand, quantity, price) VALUES ('$modelname', '$brand', $quantity, $price)");
    ?>
    <script type="text/javascript">
        alert("<?php echo $modelname . ' saved'; ?>");
        window.location.replace("productlist.php");
    </script>
    <?php
}
?>
