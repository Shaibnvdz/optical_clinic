<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body{
                margin: 0px;
                background-color: white;
            }

        *{
                font-family: poppins;
                color: #40596b;
            }

        a{
            text-decoration: none;
            margin-left: 100px;
            font-size: larger;
            background-color: #f89819;
            color: white;
            padding: 10px;
            font-family: poppins;
        }
        .add{
            position: absolute;
        }

        .category{
            position: absolute;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a class ="add" href="add-product.php">Add Product</a> <br>
    <a class ="category" href="category-management.php">Add Category</a>
</body>
</html>