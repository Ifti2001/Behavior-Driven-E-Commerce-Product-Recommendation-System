<?php
session_start();
$cnx = mysqli_connect("localhost", "root", "", "productdb");

if (!$cnx) die("DB Connection failed");

if (isset($_SESSION['username']) && isset($_POST['product_id']) && isset($_POST['duration'])) {
    $username = $_SESSION['username'];
    $product_id = $_POST['product_id'];
    $duration = intval($_POST['duration']);

    // user id বের করা
    $q = "SELECT id_user FROM users WHERE username='$username'";
    $r = mysqli_query($cnx, $q);
    $user = mysqli_fetch_assoc($r);
    $user_id = $user['id_user'];

    // চেক করা: ইউজার অলরেডি ৩ বা তার কম রেটিং দিয়ে রেখেছে কি না
    $ratingCheck = mysqli_query($cnx, "SELECT rate FROM review WHERE user_id = '$user_id' AND prod_id = '$product_id'");
    $ratingRow = mysqli_fetch_assoc($ratingCheck);

    // শর্ত: রেটিং যদি ৪ বা তার বেশি হয় (অথবা রেটিং না থাকে), তবেই আপডেট হবে
    if (!$ratingRow || $ratingRow['rate'] >= 4) {
        $check = mysqli_query($cnx, "SELECT * FROM view_time WHERE user_id='$user_id' AND product_id='$product_id'");
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($cnx, "UPDATE view_time SET view_duration = view_duration + $duration WHERE user_id='$user_id' AND product_id='$product_id'");
        } else {
            mysqli_query($cnx, "INSERT INTO view_time (user_id, product_id, view_duration) VALUES ('$user_id', '$product_id', '$duration')");
        }
    }
}
?>