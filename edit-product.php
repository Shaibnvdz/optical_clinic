<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
//include("admin-sidebar.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve product details using prepared statements
    $selectProductQuery = "SELECT * FROM addproduct WHERE id = ?";
    $stmtProduct = mysqli_prepare($conn, $selectProductQuery);
    mysqli_stmt_bind_param($stmtProduct, 'i', $id);
    if (mysqli_stmt_execute($stmtProduct)) {
        $result = mysqli_stmt_get_result($stmtProduct);
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching product details: " . mysqli_stmt_error($stmtProduct);
    }
    mysqli_stmt_close($stmtProduct);

    // Check if a product with the specified ID exists
    if ($product) {
        if (isset($_POST['submit'])) {
            // Handle the form submission
            $newName = mysqli_real_escape_string($conn, $_POST['name']);
            $newCategory = mysqli_real_escape_string($conn, $_POST['category']);
            $newPrice = isset($_POST['price']) ? floatval($_POST['price']) : null;
            $newDesc = mysqli_real_escape_string($conn, $_POST['desc']);
            $newQuantity = intval($_POST['quantity']);
            

            // Check if a new image is being uploaded
            if (!empty($_FILES['image']['name'])) {
                $newImage = $_FILES['image']['name'];

                // Specify the directory where you want to save the uploaded image
                $uploadDir = 'uploadedphoto/';

                // Get the temporary file name
                $tempName = $_FILES['image']['tmp_name'];

                // Create a unique name for the image
                $newImageName = time() . '_' . $newImage;

                // Move the uploaded image to the destination directory
                if (move_uploaded_file($tempName, $uploadDir . $newImageName)) {
                    // Update the product details, including the new image path
                    $updateProductQuery = "UPDATE addproduct SET name = ?, category = ?, price = ?, `desc` = ?, quantity = ?, image = ? WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $updateProductQuery);
                    mysqli_stmt_bind_param($stmt, 'ssdsii', $newName, $newCategory, $newPrice, $newDesc, $newQuantity , $newImageName, $id);
                    mysqli_stmt_execute($stmt);
                }
            } else {
                // No new image uploaded, update product details without changing the image
                $updateProductQuery = "UPDATE addproduct SET name = ?, category = ?, price = ?, `desc` = ?, quantity = ?  WHERE id = ?";
                $stmt = mysqli_prepare($conn, $updateProductQuery);
                mysqli_stmt_bind_param($stmt, 'ssdsii', $newName, $newCategory, $newPrice, $newDesc, $newQuantity , $id);
                mysqli_stmt_execute($stmt);
            }

            // Display success message
            echo "<script>alert('Product Details Updated Successfully'); document.location.href = 'add-product.php';</script>";
        }
    } else {
        echo '<script>alert("Product not found with ID: ' . $id . '");</script>';
    }
} else {
    echo '<script>alert("Product ID not provided");</script>';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>EDIT PRODUCT</title>

    <style>
        body{
                margin: 0px;
                background-color: white;
            }

            *{
                font-family: poppins;
            }

        .all{
                position: absolute;
                margin-top:180px;
                margin-left: 730px;
            }
        
            .text1{
                margin-top: 0px;
                margin-left: 45%;
                position: absolute;
                padding: 10px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
                font-size: 60px;
                background-color: white;
                box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
                color: #f89819;
            }

            button[type="submit"]{
                border-radius: 5px;
                border: none;
                color: white !important;
                background-color: #f89819;
                font-weight: 600;
                height:30px ;
                width: 80px;
                text-transform: uppercase;
            }

            label{
                font-weight: 500;
                color: #40596b;
            }

            input[type="text"]{
                border-radius: 8px;
                background-color: #dedede;
                height: 30px;
                outline: #40596b;
                padding: 0 10px 0 45px;
                border: none;
                border-radius: 40px;
                color: #40596b;
            }
    </style>
</head>
<body>
    <h1 class="text1"> EDIT PRODUCT</h1>
    <div class="all">
    <form class="" action="" method="post" name="product_form" autocomplete="off" enctype="multipart/form-data">
        <label for="name" class="label">PRODUCT NAME: </label>
        <input type="text" class="input" name="name" id="name" required autocomplete="name" value="<?php echo $product['name']; ?>"> <br> <br>
        
        
        
        <label for="image" class="label">PRODUCT IMAGE: </label>
        <input type="file" class="input" name="image" id="image" accept=".jpg, .jpeg, .png" autocomplete="file" value="">
        <br><br>
        <?php
        // Display the existing image if it exists
        if (!empty($product['image'])) {
            echo '<img class="prod-image" height="200px" src="uploadedphoto/' . $product['image'] . '" title="' . $product['image'] . '"><br>';
        }
        ?>
        <br>

        <label for="category" class="cate" >CATEGORY: </label>
        <select name="category" id="category" required>
            <?php
            $categoryQuery = mysqli_query($conn, "SELECT DISTINCT category FROM category");
            while ($categoryRow = mysqli_fetch_assoc($categoryQuery)) {
                $selected = ($categoryRow['category'] == $product['category']) ? "selected" : "";
                echo "<option value='" . $categoryRow['category'] . "' $selected>" . $categoryRow['category'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="quantity"> Quantity: </label>
        <input type="text" name="quantity" id="quantity" placeholder="Enter Quantity" required value="<?php echo $product['quantity']; ?>"> <br> <br>

        <label for="price" class="label">PRODUCT PRICE: </label>
        <input type="number" class="text" name="price" id="price" required autocomplete="name" value="<?php echo $product['price']; ?>" step="0.01"> <br> <br>
        
        <label for="desc" class="label">PRODUCT DESCRIPTION: </label>
        <input type="text" class="text" name="desc" id="desc" required autocomplete="name" value="<?php echo $product['desc']; ?>"> <br> <br>

        <button class="edit" type="submit" name="submit">UPDATE</button>
    </form> <br>
    </div>
</body>
</html>