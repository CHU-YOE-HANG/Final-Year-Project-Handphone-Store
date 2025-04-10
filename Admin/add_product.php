<?php include("dataconnect.php");

if(isset($_POST["savebtn"])) {
    $modelname = $_POST['model_name'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageFolder = 'image/' . basename($imageName);

    //checking the file if not will be auto created
    if (!file_exists('image')) {
        mkdir('image', 0777, true);
    }

    //move the image to sever
    if (move_uploaded_file($imageTmp, $imageFolder)) {
    mysqli_query($connect, "INSERT INTO products (model_name, brand, quantity, price, image) VALUES ('$modelname', '$brand', $quantity, $price, '$imageName')");
    ?>
    <script type="text/javascript">
        alert("<?php echo $modelname . ' saved'; ?>");
        window.location.replace("productlist.php");
    </script>
    <?php
    } else {
        echo "<script>alert('Failed to upload image');</script>";
    }
    
}
?>

<script>
function manageProduct(productId) {
    const productElement = document.getElementById(productId);
    const productImage = productElement.querySelector('.product-image').src;
    localStorage.setItem('productImage', productImage);
    window.location.href = 'manage_product.php';
}
</script>