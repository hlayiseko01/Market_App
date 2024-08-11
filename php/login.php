<?php

session_start();
include 'config.php';
include 'functions.php';

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = '';
$success = '';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM advertisers WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../advertiser_dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = sanitize_input($_POST['new_username']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        $check_sql = "SELECT * FROM advertisers WHERE username = ? OR email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username or email already exists";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO advertisers (username, email, password) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);

            if (mysqli_stmt_execute($insert_stmt)) {
                $success = "Registration successful. You can now log in.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertiser Login/Register</title>
    <link rel="stylesheet" href="../css/loginStyle.css">
</head>
<br>
<h1>Advertiser <br>Login/Register </h1>
<?php
if (!empty($error)) echo "<p class='error'>$error</p>";
if (!empty($success)) echo "<p class='success'>$success</p>";
?>

<div class="form-container">
    <button id="toggleForm">Switch to Register</button>
    <div id="loginForm" class="form">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <div id="registerForm" class="form" style="display: none;">
        <h2>Register</h2>
        <form action="" method="POST">
            <input type="text" name="new_username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="new_password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</div>
<script src="../js/script.js" defer></script>
</body>
</html>