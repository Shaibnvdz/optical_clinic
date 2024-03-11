<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
include("admin-sidebar.php");

// Process the form submission
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $price = isset($_POST['price']) ? $_POST['price'] : 0;
    $category = $_POST['category'];
    $desc = $_POST['desc'];
    $quantity = $_POST['quantity'];

    try {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } else if ($fileSize > 5000000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            $res = move_uploaded_file($tmpName, 'uploadedphoto/' . $newImageName);

            if ($res) {
                // Make sure that the column names match the database schema
                $insertQuery = "INSERT INTO addproduct (name, image, category, price, `desc`, quantity, category_id) 
                VALUES ('$name', '$newImageName', '$category', $price, '$desc', $quantity, (SELECT id FROM category WHERE category = '$category' LIMIT 1))";
                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    echo "<script> alert('Product added successfully'); </script>";
                } else {
                    echo "<script> alert('Error inserting product into the database'); </script>";
                }
            } else {
                echo "<script> alert('Error uploading image'); </script>";
            }
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Add Products</title>
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
            margin-top:200px;
            margin-left: 320px;
         }

        .text1{
            margin-top: 0px;
            margin-left: 590px;
            position: absolute;
            color: #f89819;
            background-color: white;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            padding: 10px;
            border-bottom-right-radius: 30px;                
            border-bottom-left-radius: 30px;
            font-size: 60px;
        }

        .text4, tr, th, td, input{
                color: #40596b;
            }

        input[type="text"]{
            border-radius: 8px;
            background: rgba(58, 70, 96, 0.2);
            height: 30px;
            outline: #40596b;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 40px;
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

        .btnSubmit{
            margin-left: 100px;
            width: 150px !important;
        }

        .editbtn{
            border-radius: 5px;
            border: none;
            color: white !important;
            background-color: #f89819;
            font-weight: 600;
            height:30px ;
            width: 80px;
            text-transform: uppercase;
        }

        .deletebtn{
            position: sticky;
            bottom: 0;
            width: 50px !important;
            height: 50px; /* Set the height and width to create a circular shape */
            padding: 22px;
            border-radius: 50%; /* Make it a circle */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f89819;
            border: none;
            cursor: pointer;           
        }

        .buttonProduct{ 
            width: 130px !important;
        }
            
        table{
            text-align: justify;
        }

        .delete-Form{
            position: sticky;
            bottom: 0;
            margin-left: 1085px;
            height: 5rem;
        }

        #product{
                background-color: #f4f4f4;
                font-weight: 600;
            }
    </style>
</head>
<body>
    <h1 class="text1">MANAGE PRODUCTS</h1>
    <div class="all">
    <!-- Add Product Section -->
    
    <div class="add">       
        <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                <label for="name">Product Name: </label>
                <input type="text" name="name" id="name" required autocomplete="name" placeholder="Enter product name" value=""> <br> <br>
                <label for="image">Product Image: </label>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .webp, .avif" 
                autocomplete="file" onchange="previewImage(this);" value=""> <br> <br>


            <label for="category">Category: </label>
            <select name="category" id="category" required>
            <?php
            $categoryQuery = mysqli_query($conn, "SELECT DISTINCT category FROM category");
            while ($categoryRow = mysqli_fetch_assoc($categoryQuery)) {
                echo "<option value='" . $categoryRow['category'] . "'>" . $categoryRow['category'] . "</option>";
            }
            ?>
            </select> <br> <br>

            <label for="price"> Price: </label>
            <input type="text" name="price" id="price" placeholder="Enter product price" required> <br> <br>

            <label for="quantity"> Quantity: </label>
            <input type="text" name="quantity" id="quantity" placeholder="Enter Quantity" required> <br> <br>

            <label for="desc"> Description: </label>
            <input type="text" name="desc" id="desc" placeholder="description" required>

            <button type="submit" name="submit" class="buttonProduct">ADD PRODUCT</button>
        </form>
    </div> <!-- add -->

<!-- Image Product Upload -->
<div class="imageProd">
    <img src="no-image.webp" id="imagePreview" alt="Image Preview">
</div>

<!-- Product List Section -->
<div class="view">
    <h1 class="text4">PRODUCT LIST</h1>
    
    <!-- Search Product -->
    <form action="" method="post">
        <label for="search" class="text5">Search Product:</label>
        <input type="text" name="search" id="search" placeholder="Enter product name" required>
        <button type="submit" name="search_submit" class="btnSearch">Search</button>
    </form> <br>

    <table border="1" cellspacing="0" cellpadding="10"  class="viewTable">
        <tr class="thView">
            <th>ID</th>
            <th style="width: 100px;">Name</th>
            <th>Image</th>
            <th>Category</th>
            <th>Price</th>
            <th style="width: 300px;"> Description</th>
            <th>Stocks</th>
            <th>Action</th>
            <th>Delete</th>
        </tr>

        <?php
        $i = 1;

        // Check if search is submitted
        if (isset($_POST["search_submit"])) {
            $searchTerm = mysqli_real_escape_string($conn, $_POST["search"]);
            $searchQuery = "SELECT * FROM addproduct WHERE name LIKE '%$searchTerm%' OR category LIKE '%$searchTerm%'";
            $rows = mysqli_query($conn, $searchQuery);

            // Check if $rows is not empty
            if ($rows && mysqli_num_rows($rows) > 0) {
                foreach ($rows as $row) {
                    // Output product row
                    echo '<tr>';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . $row["name"] . '</td>';
                    echo '<td> <img src="uploadedphoto/' . $row["image"] . '" width="200" title="' . $row['image'] . '"> </td>';
                    echo '<td>' . $row["category"] . '</td>';
                    echo '<td>' . $row["price"] . '</td>';
                    echo '<td>' . $row["desc"] . '</td>';
                    echo '<td>' . $row["quantity"] . '</td>';
                    echo '<td>';
                    echo '<button class="editbtn" onclick="editProduct(' . $row['id'] . ');"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i> <span> Edit </span></button> '; // Edit button
                    echo '</td>';
                    echo '<td><input type="checkbox" name="delete[]" value="' . $row['id'] . '"></td>'; // Checkbox for deletion
                    echo '</tr>';
                }
            } else {
                // No products found
                echo '<tr><td colspan="9">No products found.</td></tr>';
            }
        } else {
            // Display all products if search is not submitted
            $rows = mysqli_query($conn, "SELECT * FROM addproduct");

            if ($rows && mysqli_num_rows($rows) > 0) {
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . $row["name"] . '</td>';
                    echo '<td> <img src="uploadedphoto/' . $row["image"] . '" width="200" title="' . $row['image'] . '"> </td>';
                    echo '<td>' . $row["category"] . '</td>';
                    echo '<td>' . $row["price"] . '</td>';
                    echo '<td>' . $row["desc"] . '</td>';
                    echo '<td>' . $row["quantity"] . '</td>';
                    echo '<td>';
                    echo '<button class="editbtn" onclick="editProduct(' . $row['id'] . ');"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i> <span> Edit </span></button> '; // Edit button
                    echo '</td>';
                    echo '<td><input type="checkbox" name="delete[]" value="' . $row['id'] . '"></td>'; // Checkbox for deletion
                    echo '</tr>';
                }
            } else {
                // No products found
                echo '<tr><td colspan="9">No products found.</td></tr>';
            }
        }
        ?>
        </table>
        <div class="delete-Form" >
            <!-- Delete button -->
            <form  action="" method="post" id="deleteForm">
                <button type="submit" class="deletebtn" onclick="deleteProducts();"> 
                    <img src=".\\imagesfinal\trash-can.png" alt="" height="20px">
                </button>
            </form>
        </div>
    </div> <!-- view -->
        
</div> <!-- all div -->

        


<script>

    function editProduct(productId) {
        window.open('edit-product.php?id=' + productId, '_self');
    }

    function deleteProducts() {
        var selectedProducts = document.querySelectorAll('input[name="delete[]"]:checked');
        var selectedIds = Array.from(selectedProducts).map(function (product) {
            return product.value;
        });

        if (selectedIds.length > 0) {
            var confirmation = confirm("Are you sure you want to delete these products? Items you delete can't be restored");

            if (confirmation) {
                document.getElementById('deleteForm').action = 'delete-product.php?ids=' + selectedIds.join(',');
                document.getElementById('deleteForm').submit(); 
            } else {
                return false;
            }
        } else {
            alert("Please select at least one product to delete.");
            return false;
        }
    }


    function previewImage(input) {
    var preview = document.getElementById('imagePreview');
    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        preview.src = e.target.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "no-image.webp";
    }
}
</script>
</body>
</html>