<?php
global $conn;
session_start();
include 'php/config.php';
include 'php/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user's listings
$sql = "SELECT * FROM listings WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$listings = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertiser Dashboard - Your Marketplace App</title>
    <link rel="stylesheet" href="css/styledashboard.css">
</head>
<body>
<header>
    <h1>Advertiser Dashboard</h1>
    <nav>

            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="services.php">Services</a>
            <a href="rentals.php">Rentals</a>

                <form action="php/logout.php" method="POST">
                    <button type="submit">Logout</button>
                </form>


    </nav>
</header>

<main>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

    <section>
        <h3>Your Listings</h3>
        <?php if (empty($listings)): ?>
            <p>You haven't created any listings yet.</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($listings as $listing): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($listing['title']); ?></td>
                        <td><?php echo htmlspecialchars($listing['category']); ?></td>
                        <td>R<?php echo number_format($listing['price'], 2); ?></td>
                        <td>
                            <a href="php/edit_listing.php?id=<?php echo $listing['id']; ?>">Edit</a>
                            <a href="php/delete_listing.php?id=<?php echo $listing['id']; ?>" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section>
        <h3>Create New Listing</h3>
        <a href="php/create_listing.php" class="button">Create New Listing</a>
    </section>
</main>

<footer>
    <p>&copy; 2024 SOS-MarketPlace</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>
