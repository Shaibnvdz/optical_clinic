<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ids'])) {
        $idDelete = implode(',', explode(',', $_POST['ids'])); // Ensure array format
        $sql = "DELETE FROM addproduct WHERE ProductID in(" . $idDelete . ")";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        echo "<script> alert('Deleted Successfully'), window.location.href='addproduct.php' </script>";
    }
}
?>
