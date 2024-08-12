<?php
session_start();
include 'config.php';
include 'functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the listing ID from the URL
$listing_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the listing details from the database
$sql = "SELECT * FROM listings WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $listing_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$listing = mysqli_fetch_assoc($result);

if (!$listing) {
    // If the listing is not found or does not belong to the user, redirect
    header("Location: ../advertiser_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title']);
    $category = sanitize_input($_POST['category']);
    $price = sanitize_input($_POST['price']);
    $description = sanitize_input($_POST['description']);

    // Update the listing in the database
    $sql = "UPDATE listings SET title = ?, category = ?, price = ?, description = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $title, $category, $price, $description, $listing_id, $_SESSION['user_id']);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../advertiser_dashboard.php");
        exit();
    } else {
        $error = "Failed to update the listing. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main>
    <h2>Edit Listing</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($listing['title']); ?>" required>

        <label for="category">Category:</label>
        <select name="category" required>
            <option value="products" <?php echo $listing['category'] == 'products' ? 'selected' : ''; ?>>Products</option>
            <option value="services" <?php echo $listing['category'] == 'services' ? 'selected' : ''; ?>>Services</option>
            <option value="rentals" <?php echo $listing['category'] == 'rentals' ? 'selected' : ''; ?>>Rentals</option>
        </select>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($listing['price']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($listing['description']); ?></textarea>

        <button type="submit">Update Listing</button>
    </form>
    <a href="../advertiser_dashboard.php">Back to Dashboard</a>
</main>
</body>
</html>


