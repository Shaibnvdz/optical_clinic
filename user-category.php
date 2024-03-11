<?php
    
    require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .content-categories{
            position: relative; 
            top: 20%;
            left: 25%;
        }

        .text-categories{
            font-weight:600;
        }

    </style>    
</head>
<body>
<div class="content-categories">
            <div>
                <div class="categories-title">
                    <p class="text-categories">CATEGORIES</p>
                </div>

                <div class="containers-category">
                    <?php

                    // Fetch categories from the database
                    $query = "SELECT * FROM category";
                    $result = mysqli_query($conn, $query);

                    // Check if the query was successful
                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($conn));
                    }

                    // Loop through the categories and display them
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Create a link for each category that points to a different file
                        $categoryLink = "product-category.php?category=" . urlencode($row['category']);
                        echo "<a class='categorylink' href='$categoryLink'>";
                        echo "<div class='categories'>";
                        echo "<div class='category-img'>";
                        $imagePath = "uploadedphoto/" . $row['image'];
                    
                        echo "</div>";
                        echo "<div class='category-title'>";
                        echo "<span>{$row['category']}</span>";
                        echo "</div>";
                        echo "</div>";
                        echo "</a>";
                    }
                    ?>            
                </div>
            </div>
        </div>
</body>
</html>