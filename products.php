<?php
include 'php/config.php';
include 'php/functions.php';

$listings = get_listings('products');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Your Marketplace App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>

    <nav>

            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="services.php">Services</a>
            <a href="rentals.php">Rentals</a>
            <a href="advertiser_dashboard.php">Advertiser </a>

    </nav>
</header>

<main>
    <h2>Product Listings</h2>
    <?php if (empty($listings)): ?>
        <p>No product listings found.</p>
    <?php else: ?>
        <div class="listings-grid">
            <?php foreach ($listings as $listing): ?>
                <div class="listing-card">
                    <img src="<?php echo htmlspecialchars($listing['image_path']); ?>" alt="<?php echo htmlspecialchars($listing['title']); ?>">
                    <h3><?php echo htmlspecialchars($listing['title']); ?></h3>
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

<script src="js/main.js"></script>
</body>
</html>
