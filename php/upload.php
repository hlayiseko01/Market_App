<?php
session_start();
include 'config.php';
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $category = sanitize_input($_POST['category']);
    $price = floatval($_POST['price']);
    $user_id = $_SESSION['user_id'];

    $target_dir = "../images/uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = "images/uploads/" . basename($_FILES["image"]["name"]);

        $sql = "INSERT INTO listings (user_id, title, description, category, price, image_path) VALUES ('$user_id', '$title', '$description', '$category', '$price', '$image_path')";

        if (mysqli_query($conn, $sql)) {
            $success = "Listing created successfully";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Sorry, there was an error uploading your file.";
    }
}
