<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the listing ID from the URL
$listing_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the listing from the database
$sql = "DELETE FROM listings WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $listing_id, $_SESSION['user_id']);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../advertiser_dashboard.php");
    exit();
} else {
    // Handle error if deletion fails
    header("Location: ../advertiser_dashboard.php?error=Failed to delete listing.");
    exit();
}
?>
