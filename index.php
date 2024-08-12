<?php
include 'php/config.php';
include 'php/functions.php';
?>
<?php
// Initialize variables to avoid undefined variable errors
$query = isset($_GET['query']) ? sanitize_input($_GET['query']) : '';
$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';
$city = isset($_GET['city']) ? sanitize_input($_GET['city']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Marketplace App</title>
    <link rel="stylesheet" href="css/indexstyle.css">
</head>
<body>
<header>

    <nav>

            <a href="products.php">Products</a>
            <a href="services.php">Services</a>
            <a href="rentals.php">Rentals</a>
            <a href="advertiser_dashboard.php">Advertiser</a>

    </nav>
</header>

<main>
    <form action="php/search.php" method="GET">
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

    <section id="featured">
        <h2>Featured Listings</h2>
        <!-- PHP code to fetch and display featured listings -->
    </section>
</main>

<footer>
    <p>&copy; 2024 Your Marketplace App</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>
