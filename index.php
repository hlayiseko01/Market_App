<?php
include 'php/config.php';
include 'php/functions.php';
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
        <input type="text" name="query" placeholder="Search...">
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
