<?php
include 'config.php';
session_start();

if (isset($_POST['product_id']) && isset($_POST['duration'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO product_views (user_id, product_id, view_time) 
            VALUES ('$user_id', '$product_id', '$duration')";
    mysqli_query($conn, $sql);
}
?>
