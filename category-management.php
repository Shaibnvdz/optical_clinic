<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
include("admin-sidebar.php");

$fileUploadedSuccessfully = false;

if (isset($_POST["submit"])) {
    $name = $_POST["name"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($imageExtension, $validImageExtension) && $fileSize <= 1000000) {
            $newImageName = uniqid() . '.' . $imageExtension;
            $res = move_uploaded_file($tmpName, 'uploadedphoto/' . $newImageName);
            if ($res) {
                $query = "INSERT INTO category (category, image) VALUES('$name', '$newImageName')";
                mysqli_query($conn, $query);
                echo "<script>alert('Successfully Added');</script>";
                $fileUploadedSuccessfully = true;
            } else {
                echo "Failed to upload";
            }
        } else {
            echo "<script>alert('Invalid Image Extension or Image Size Is Too Large');</script>";
        }
    } else {
        echo "<script>alert('Image Upload Error');</script>";
    }

} elseif (isset($_POST["edit"])) {
    $editCategoryId = $_POST["edit_id"];
    $editCategoryName = mysqli_real_escape_string($conn, $_POST["edit_name"]);

    // Check if a new image has been uploaded
    if (isset($_FILES["edit_image"]) && $_FILES["edit_image"]["error"] === UPLOAD_ERR_OK) {
        $editFileName = $_FILES["edit_image"]["name"];
        $editFileSize = $_FILES["edit_image"]["size"];
        $editTmpName = $_FILES["edit_image"]["tmp_name"];

        $validEditImageExtension = ['jpg', 'jpeg', 'png'];
        $editImageExtension = strtolower(pathinfo($editFileName, PATHINFO_EXTENSION));

        if (in_array($editImageExtension, $validEditImageExtension) && $editFileSize <= 1000000) {
            $editNewImageName = uniqid() . '.' . $editImageExtension;
            $editRes = move_uploaded_file($editTmpName, 'uploadedphoto/' . $editNewImageName);

            if ($editRes) {
                // Update category with new image name
                $editQuery = "UPDATE category SET category = '$editCategoryName', image = '$editNewImageName' WHERE id = $editCategoryId";
                mysqli_query($conn, $editQuery);
                echo "<script>alert('Category Updated Successfully');</script>";
            } else {
                echo "<script>alert('Failed to upload edited image');</script>";
            }
        } else {
            echo "<script>alert('Invalid Edited Image Extension or Image Size Is Too Large');</script>";
        }
    } else {
        // If no new image is uploaded, update category name only
        $editQuery = "UPDATE category SET category = '$editCategoryName' WHERE id = $editCategoryId";
        mysqli_query($conn, $editQuery);
        echo "<script>alert('Category Name Updated Successfully');</script>";
    }

} 

if (isset($_GET['ids']) && !empty($_GET['ids'])) {
        try {
            // Begin a transaction
            mysqli_begin_transaction($conn);

            $selectedIds = explode(',', $_GET['ids']);

            foreach ($selectedIds as $selectedCategoryId) {
                $deleteProductsQuery = "DELETE FROM addproduct WHERE category_id = $selectedCategoryId";
                mysqli_query($conn, $deleteProductsQuery);

                $deleteCategoryQuery = "DELETE FROM category WHERE id = $selectedCategoryId";
                mysqli_query($conn, $deleteCategoryQuery);
            }

            // Commit the transaction if everything succeeded
            mysqli_commit($conn);

            echo "<script>alert('Selected Categories Deleted Successfully'), window.location.href='category-management.php'</script>";
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            mysqli_rollback($conn);
            echo "<script>alert('Error deleting categories. Please try again.');</script>";
        }
}

$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$searchQuery = "SELECT * FROM category WHERE category LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $searchQuery);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>CATEGORY</title>
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
                margin-left: 380px;
            }

            .text1{
                margin-top: 0px;
                margin-left: 585px;
                position: absolute;
                padding: 10px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
                font-size: 60px;
                background-color: white;
                box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
                color: #f89819;
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
            
            .delete-Form{
            position: sticky;
            bottom: 0;
            margin-left: 950px;
            height: 5rem;
        }

            .editbtn{
                color: white !important; 
            }
            
            table{
                border-color: #40596b;
            }

            #category{
                background-color: #f4f4f4;
                font-weight: 600;
            }
    </style>
</head>
<body>
    <h1 class="text1" >MANAGE CATEGORY</h1>
    <div class="all">
        <div class="add">
            
            <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                <label for="name">Category Name: </label>
                <input type="text" name="name" id="name" required value="" placeholder="Enter category name"> <br> <br>
                <label for="image">Product Image: </label>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .webp, .avif" 
                autocomplete="file" onchange="previewImage(this);" value=""> <br> <br>
                <button type="submit" name="submit" class="btnSubmit">Submit</button>
            </form>
        </div> <!-- add -->

        <!-- Image Product Upload -->
        <div class="imageProd">
            <img src="no-image.webp" id="imagePreview" alt="Image Preview" height="150px">
        </div>

        <div class="view">
            <h1 class="text4"> CATEGORY LIST </h1>

            <!-- Search Form -->
            <form action="" method="get">
                <label for="search" class="text5">Search Category:</label>
                <input type="text" name="search" class="searchtxt" id="search" placeholder="Enter category name">
                <button type="submit" class="btnSearch">Search</button>
            </form> <br>

            <form action="" method="POST">
                <table border="1" cellspacing="0" cellpadding="10" class="viewTable">
                    <tr class="thView">
                        <th> ID</th>
                        <th> Name</th>
                        <th>Image</th>
                        <th>Update </th>
                        <th>Delete</th>
                    </tr>
                    <?php
                        // Modify the query based on the search input
                        $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                        $searchQuery = "SELECT * FROM category WHERE category LIKE '%$searchTerm%'";
                        $searchResult = mysqli_query($conn, $searchQuery);

                        while ($row = mysqli_fetch_assoc($searchResult)) :
                    ?>

                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><img src="uploadedphoto/<?php echo $row['image']; ?>" alt="Category Image" height="100"></td>
                        <td>
                            <!-- Edit Form -->
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <label for="edit_name">Category Name:</label>
                            <input type="text" name="edit_name" class="categorytxt" value="<?php echo $row['category']; ?>" required><br><br>
                            <label for="edit_image">Category Image: </label>
                            <input type="file" name="edit_image" accept=".jpg, .jpeg, .png">
                            <button type="submit" name="edit" class="editbtn"> <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i> <span> Edit </span></button>
                        </form>
                        </td>
                        <td>
                            <input type="checkbox" name="delete_selected[]" value="<?php echo $row['id']; ?>">
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                
            </form>
            <div class="delete-Form" >
                <!-- Delete button -->
                <form  action="" method="post" id="deleteForm">
                    <button type="submit" class="deletebtn" onclick="deleteProducts();"> 
                        <img src=".\\imagesfinal\trash-can.png" alt="" height="20px">
                    </button>
                </form>
            </div>
        </div> <!-- view -->
    </div> <!-- all -->

    <script>
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
        function deleteProducts() {
        var selectedProducts = document.querySelectorAll('input[name="delete_selected[]"]:checked');
        var selectedIds = Array.from(selectedProducts).map(function (product) {
            return product.value;
        });

        if (selectedIds.length > 0) {
            var confirmation = confirm("Are you sure you want to delete these category? Items you delete can't be restored");

            if (confirmation) {
                document.getElementById('deleteForm').action = '?ids=' + selectedIds.join(',');
                document.getElementById('deleteForm').submit(); 
            } else {
                return false;
            }
        } else {
            alert("Please select at least one category to delete.");
            return false;
        }
    }        
    </script>
</body>
</html>