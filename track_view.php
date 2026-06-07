<?php
include('config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']) && isset($_GET['product_id'])) {
    $username = $_SESSION['username'];
    $product_id = $_GET['product_id'];

    // ইউজার আইডি বের করা
    $userQuery = mysqli_query($conn, "SELECT id_user FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($userQuery);
    $user_id = $user['id_user'];

    // চেক করা: ইউজার এই প্রোডাক্টে ৩ বা তার কম রেটিং দিয়েছে কি না
    $ratingCheck = mysqli_query($conn, "SELECT rate FROM review WHERE user_id = '$user_id' AND prod_id = '$product_id'");
    $ratingRow = mysqli_fetch_assoc($ratingCheck);

    // যদি রেটিং না থাকে অথবা ৪-এর বেশি হয়, তবেই কেবল ভিউ টাইম বাড়বে
    if (!$ratingRow || $ratingRow['rate'] >= 4) {
        mysqli_query($conn, "
            INSERT INTO view_time (user_id, product_id, view_duration)
            VALUES ($user_id, $product_id, 5)
            ON DUPLICATE KEY UPDATE view_duration = view_duration + 5, last_view = NOW()
        ");
    }
}
?>