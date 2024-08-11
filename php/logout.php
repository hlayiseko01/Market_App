<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the home page or login page
    header("Location: ../index.php");
    exit();
} else {
    // If not a POST request, redirect to the dashboard
    header("Location: ../advertiser_dashboard.php");
    exit();
}
?>
