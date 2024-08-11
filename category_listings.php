<?php
// Include your database connection file
include('php/config.php');

// Get the category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Prepare the SQL query based on the category
if (!empty($category)) {
    $query = "SELECT * FROM listings WHERE category = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $category);
} else {
    $query = "SELECT * FROM listings";
    $stmt = $conn->prepare($query);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch the listings into an array
$listings = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Listings</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav>
        <a href="index.php">Home</a>
        <a href="category_listings.php?category=products">Products</a>
        <a href="category_listings.php?category=services">Services</a>
        <a href="category_listings.php?category=rentals">Rentals</a>
    </nav>
</header>

<main>
    <h2><?php echo ucfirst($category); ?> Listings</h2>

    <form action="category_listings.php" method="GET">
        <input type="text" name="query" placeholder="Search...">
        <select name="category">
            <option value="products" <?php echo $category == 'products' ? 'selected' : ''; ?>>Products</option>
            <option value="services" <?php echo $category == 'services' ? 'selected' : ''; ?>>Services</option>
            <option value="rentals" <?php echo $category == 'rentals' ? 'selected' : ''; ?>>Rentals</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <?php if (empty($listings)): ?>
        <p>No results found.</p>
    <?php else: ?>
        <div class="listings-grid">
            <?php foreach ($listings as $listing): ?>
                <div class="listing-card">
                    <img src="../<?php echo htmlspecialchars($listing['image_path']); ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>">
                    <h2><?php echo htmlspecialchars($listing['title']); ?></h2>
                    <p><?php echo htmlspecialchars(substr($listing['description'], 0, 100)) . '...'; ?></p>
                    <p class="price">R<?php echo number_format($listing['price'], 2); ?></p>
                    <a href="php/listing_details.php?id=<?php echo $listing['id']; ?>">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2024 Your Marketplace App</p>
</footer>

</body>
</html>

