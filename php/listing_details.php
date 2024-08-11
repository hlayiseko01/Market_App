<?php
session_start();
include 'config.php';
include 'functions.php';


//  display success or error messages
if (isset($_SESSION['success'])) {
    echo "<p class='success'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}


// Check if an ID was provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$listing_id = intval($_GET['id']);

// Fetch the listing details
$sql = "SELECT l.*, a.username as advertiser_name 
        FROM listings l 
        JOIN advertisers a ON l.user_id = a.id 
        WHERE l.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $listing_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($listing = mysqli_fetch_assoc($result)) {
    // Listing found
} else {
    // Listing not found
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($listing['title']); ?> - Listing Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>

    <nav>

            <a href="../index.php">Home</a>
            <a href="../products.php">Products</a>
            <a href="../services.php">Services</a>
            <a href="../rentals.php">Rentals</a>

    </nav>
</header>

<main class="listing-details">
    <h2><?php echo htmlspecialchars($listing['title']); ?></h2>
    <img src="../<?php echo htmlspecialchars($listing['image_path']); ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>">
    <p class="price">Price: $<?php echo number_format($listing['price'], 2); ?></p>
    <p class="category">Category: <?php echo htmlspecialchars(ucfirst($listing['category'])); ?></p>
    <p class="advertiser">Posted by: <?php echo htmlspecialchars($listing['advertiser_name']); ?></p>
    <p class="description"><?php echo nl2br(htmlspecialchars($listing['description'])); ?></p>
    <p class="date">Posted on: <?php echo date('F j, Y', strtotime($listing['created_at'])); ?></p>

    <!-- Add contact form or contact information here -->
    <h3>Contact the Advertiser</h3>
    <p>If you're interested in this listing, please use the contact form below:</p>
    <form action="send_message.php" method="POST">
        <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Your Marketplace App</p>
</footer>

<script src="../js/main.js"></script>
</body>
</html>
