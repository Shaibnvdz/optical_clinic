<?php 
	 include("config.php");

	$sql = "INSERT INTO addproduct(ProductID, ProductName, Price, Description, Category, productimage) VALUES ('$_GET[ProductID]', '$_GET[name]', '$_GET[price]', '$_GET[Description]', '$_GET[Category]', '$_GET[productimage]')" ;
	mysqli_query($con, $sql);
	mysqli_close($con);
	echo "<script> alert('Added Successfully'), window.location.href='addproduct.php' </script>";
?>