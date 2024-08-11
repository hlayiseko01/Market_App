<?php
global $conn;
session_start();
include 'config.php';
include 'functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $category = sanitize_input($_POST['category']);
    $price = floatval($_POST['price']);
    $user_id = $_SESSION['user_id'];

    // File upload handling
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array(strtolower($filetype), $allowed)) {
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            $newname = uniqid() . "." . $filetype;
            $upload_dir = "../images/uploads/";
            $upload_file = $upload_dir . $newname;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                $image_path = "images/uploads/" . $newname;
            } else {
                $error = "Failed to upload image.";
            }
        }
    } else {
        $error = "No image uploaded or upload error occurred.";
    }

    if (empty($error)) {
        $sql = "INSERT INTO listings (user_id, title, description, category, price, image_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isssds", $user_id, $title, $description, $category, $price, $image_path);

        if (mysqli_stmt_execute($stmt)) {
            $success = "Listing created successfully!";
        } else {
            $error = "Error creating listing: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>Create New Listing</h1>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../advertiser_dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php
    if (!empty($error)) {
        echo "<p class='error'>$error</p>";
    }
    if (!empty($success)) {
        echo "<p class='success'>$success</p>";
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="products">Products</option>
            <option value="services">Services</option>
            <option value="rentals">Rentals</option>
        </select>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Create Listing</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Your Marketplace App</p>
</footer>

<script src="../js/main.js"></script>
</body>
</html>
