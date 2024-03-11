<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include("navbar.php");
    include("user-category.php");
    require 'config.php';

    

    if(isset($_POST['view'])){
        $_SESSION['id']  = $_POST['view'];
        $show = true;
    }

    if(isset($_POST['close'])){
        $show = false;
    }

    if(isset($_POST['directAdd'])){
        if (empty($_SESSION["user_id"])) {
            echo "<script>alert('Please Login First'); window.location.href='login.php'</script>"; 
        }

        
        $sqlT = mysqli_query($conn, "SELECT * FROM addproduct WHERE id =  $_SESSION[id] ");

        $sqlCart = mysqli_query($conn, "SELECT * FROM cart WHERE ProductID =  $_SESSION[id] AND userID = '$_SESSION[user_id]' ");

        if (mysqli_num_rows($sqlCart) > 0) {
            mysqli_query($conn, "UPDATE cart SET Quantity = Quantity + $_POST[quantity] WHERE ProductID =  $_SESSION[id] AND userID = '$_SESSION[user_id]' ");
            echo "<script>alert('Added to cart'); window.location.href='product-category.php?category=Eyeglasses'</script>"; 
        }else{
            while ($row = mysqli_fetch_assoc($sqlT)){
            mysqli_query($conn, "INSERT INTO cart (ProductID , ProductName, Price, Image, Quantity, userID) VALUES ($_SESSION[id], '$row[name]', '$row[price]', '$row[image]', $_POST[quantity], '$_SESSION[user_id]' )");
            echo "<script>alert('Added to cart'); window.location.href='product-category.php?category=Eyeglasses'</script>"; 
            }
        }       
        unset($_SESSION['id']); 
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .daily-discover-content{
            margin-left: 800px;
            width: 100px;
            margin-top: 10px;
        }

        .items{
            display: inline-block;
            margin-left: 20px;
            background-color: white;
            font-size: smaller;
            text-align: center;
            padding: 10px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5); 

        }

        

        .grid-items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            justify-content: space-around;
}

        .items-img{
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);

        }

        .adc-text{
            background-color: #f89819;
            color: white;
            height: 25px;
            border:none;
        }

        .discover-description{
            margin-top: 5px;
        }

        .pagination-link{
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500    
        }

        a{
            text-decoration: none;
        }

        .items-btn{
            border:none;
            background-color: transparent ;
        }
        
        .product-container{
            position: absolute;
            background-color: white;
            margin-left: 660px;
            margin-top: -550px;
            height: 400px;
            width: 430px;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);

        }

        .popup-image{
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
            margin-top: 20px;
            margin-left: 20px;
        }

        .popup-name{
            position: absolute;
            margin-left: 170px;
            margin-top:-120px;
        }

        .popup-price{
            position: absolute;
            margin-left: 170px;
            margin-top:-70px;
            font-size: larger;
        }

        #adc-btn{
            position: absolute;
            margin-top: 300px;
            margin-left: 200px;
        }

        .counter{
            position: absolute;
            margin-top: 300px;
            color: #40596b;
        }

        .popup-description{
            position: absolute;
            margin-left: 20px;
            margin-top: 30px;
            text-align: justify;
            font-size: small;
            width: 350px;
            text-indent: 50;
        }

        .adc-quantity-container{
            position: relative;
            margin-left: 50px;
            width: 300px;
            margin-top: -110px;
        }
        .showProduct{
            visibility: hidden;
        }

        .close-btn{
            position: absolute;
            border-radius: 50%;
            border: none;
            margin-left: 450px;
            margin-top: -30px;
            background-color: #f89819;
            color: white;
            font-weight: 500;
            box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
        }

        .page a{
            border: 2px solid #40596b;
            padding: 5px;
        }

        <?php 
            if(isset($show) && $show){
                echo ".showProduct{visibility: visible;}";
            }
            else{
                echo ".showProduct{visibility: hidden;}";
            }
        ?>
    </style>
</head>
<body>
        
    <!-- Daily discover content -->
    <div class="daily-discover-content" id="product">
            <!-- Items container -->
            <div class="daily-discover-container">
                <!-- Grid items -->
                <div class="grid-items">
                    <?php
                    // Default value for itemsPerPage
                    $itemsPerPage = 6;

                    // Fetch filterType if it's set
                    $filterType = isset($_GET['filter']) ? $_GET['filter'] : 'all';

                    // Fetch products from the database based on the filter type
                    switch ($filterType) {
                        case 'all':
                            // Show all products from the selected category with pagination
                            $category = isset($_GET['category']) ? urldecode($_GET['category']) : '';
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($page - 1) * $itemsPerPage;
                            $query = "SELECT * FROM addproduct WHERE category = '$category' LIMIT $offset, $itemsPerPage";
                            break;

                        default:
                            // Default case for handling invalid filter types
                            $category = '';
                            $query = '';
                            break;
                    }

                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                    die("Error in SQL query: " . mysqli_error($conn));
                    }

                    // Display products
                    while ($product = mysqli_fetch_assoc($result)) {
                        // echo "<a href='product-details.php?id={$product['id']}'>";
                        echo "<form method='POST'>";
                        echo "<div class='items-container'>";
                        echo    "<div class='items'>";
                        echo        "<img class='items-img' src='uploadedphoto/{$product['image']}' alt='{$product['name']}' height='130' width='130' />";
                        echo        "<div class='discover-description'>";
                        echo            "<span>{$product['name']}</span>";
                        echo        "</div>";

                        echo        "<div class='discover-price'>";
                        echo            "<p>₱{$product['price']}.00</p>";                        
                        echo        "</div>";

                        echo        "<div class='adc-text-container'>";
                        echo            "<button name='view' value='{$product['id']}'class='adc-text' > View Details </button>";                        
                        echo        "</div>";
                        echo    "</div>";
                        echo "</div>";
                        echo "</form>";
                    }

                    ?>
                </div>
            </div>
                <?php
                    // Pagination links for "ALL" filter
                    if ($filterType == 'all') {
                        echo "<br> <div class='page'>";
                        $totalProductsQuery = "SELECT COUNT(*) AS total FROM addproduct WHERE category = '$category'";
                        $totalResult = mysqli_query($conn, $totalProductsQuery);
                    
                        if (!$totalResult) {
                            die("Error in SQL query: " . mysqli_error($conn));
                        }
                    
                        $totalProducts = mysqli_fetch_assoc($totalResult)['total'];
                        $totalPages = ceil($totalProducts / $itemsPerPage);
                    
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "<a href='?filter=$filterType&category=$category&page=$i' class='pagination-link'>$i</a>";
                        }
                    
                        echo "</div>";
                    }

                    
                ?>
        </div>

        <div class="showProduct">
            <form method="POST">
                    <?php 
                    $sqlT = mysqli_query($conn, "SELECT * FROM addproduct WHERE id =  $_SESSION[id] ");
                    mysqli_data_seek($sqlT, 0);
                        while ($row = mysqli_fetch_assoc($sqlT)){
                            echo "<div class='product-container'>";
                            echo "      <div class='item-container'>";
                            echo "          <button class='close-btn' name='close'>X</button>";
                            echo "          <img class='popup-image' src='uploadedphoto/".$row['image']."' height='130' width='130' />";
                            echo "          <h1 class='popup-name'>".$row['name']."</h1>";
                            echo "          <h1 class='popup-price'>₱".$row['price'].".00</h1>";
                            echo "          <p class='popup-description'>".$row['desc']."</p>";
                            echo "          <div class='adc-quantity-container'>";
                            echo "              <input class='counter' type='number' name='quantity' min='1' value= '1' >";
                            echo "              <button id='adc-btn' name='directAdd' value='{$row['id']}'class='adc-text' > Add to cart </button>";
                            echo "          </div>";
                            echo "      </div>";
                            echo "</div>";
                        }
                        // Close the database connection
                        mysqli_close($conn);
                    ?>
            </form>
        </div>
</body>
</html>