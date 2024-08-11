<?php
include 'config.php';
include 'functions.php';

$query = isset($_GET['query']) ? sanitize_input($_GET['query']) : '';
$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';

$sql = "SELECT * FROM listings WHERE 1=1";

if (!empty($query)) {
    $sql .= " AND (title LIKE '%$query%' OR description LIKE '%$query%')";
}

if (!empty($category) && in_array($category, ['products', 'services', 'rentals'])) {
    $sql .= " AND category = '$category'";
}

$sql .= " ORDER BY created_at DESC";

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
