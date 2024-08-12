<?php
include 'config.php';
include 'functions.php';

// Sanitize input
$query = isset($_GET['query']) ? sanitize_input($_GET['query']) : '';
$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';
$city = isset($_GET['city']) ? sanitize_input($_GET['city']) : '';

// Start building the SQL query
$sql = "SELECT l.*, a.city 
        FROM listings l 
        JOIN advertisers a ON l.user_id = a.id 
        WHERE 1=1";

if (!empty($query)) {
    $sql .= " AND (l.title LIKE '%$query%' OR l.description LIKE '%$query%')";
}

if (!empty($category) && in_array($category, ['products', 'services', 'rentals'])) {
    $sql .= " AND l.category = '$category'";
}

if (!empty($city)) {
    $sql .= " AND a.city = '$city'";
}

$sql .= " ORDER BY l.created_at DESC";

$result = mysqli_query($conn, $sql);
$listings = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="../index.php">Home</a>
        <a href="../category_listings.php?category=products">Products</a>
        <a href="../category_listings.php?category=services">Services</a>
        <a href="../category_listings.php?category=rentals">Rentals</a>
    </nav>
</header>

<main>
    <h2>Search Results for: <?php echo htmlspecialchars($query); ?></h2>

    <form action="" method="GET">
        <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search...">
        <select name="category">
            <option value="">All Categories</option>
            <option value="products" <?php echo $category == 'products' ? 'selected' : ''; ?>>Products</option>
            <option value="services" <?php echo $category == 'services' ? 'selected' : ''; ?>>Services</option>
            <option value="rentals" <?php echo $category == 'rentals' ? 'selected' : ''; ?>>Rentals</option>
        </select>
        <select name="city">
            <option value="">All Cities</option>
            <option value="Tzaneen" <?php echo $city == 'Tzaneen' ? 'selected' : ''; ?>>Tzaneen</option>
            <option value="City2" <?php echo $city == 'City2' ? 'selected' : ''; ?>>City2</option>
            <!-- Add more cities as needed -->
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
                    <p class="location">Location: <?php echo htmlspecialchars($listing['city']); ?></p>
                    <a href="./listing_details.php?id=<?php echo $listing['id']; ?>">View Details</a>
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
