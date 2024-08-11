<?php
session_start();
include 'config.php';
include 'functions.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $listing_id = isset($_POST['listing_id']) ? intval($_POST['listing_id']) : 0;
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: listing_details.php?id=$listing_id");
        exit();
    }

    // Fetch the advertiser's email
    $sql = "SELECT a.email as advertiser_email, l.title
            FROM listings l
            JOIN advertisers a ON l.user_id = a.id
            WHERE l.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $listing_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $advertiser_email = $row['advertiser_email'];
        $listing_title = $row['title'];

        // Prepare email content
        $to = $advertiser_email;
        $subject = "New message about your listing: " . $listing_title;
        $email_content = "
        You have received a new message about your listing '$listing_title':

        From: $name
        Email: $email

        Message:
        $message

        ---
        This message was sent via Your Marketplace App.
        ";

        // Email headers
        $headers = "From: noreply@yourmarketplace.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send email
        if (mail($to, $subject, $email_content, $headers)) {
            // Store the message in the database
            $sql = "INSERT INTO messages (listing_id, sender_name, sender_email, message_content) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isss", $listing_id, $name, $email, $message);
            mysqli_stmt_execute($stmt);

            $_SESSION['success'] = "Your message has been sent successfully!";
        } else {
            $_SESSION['error'] = "Failed to send message. Please try again later.";
        }
    } else {
        $_SESSION['error'] = "Listing not found.";
    }

    // Redirect back to the listing details page
    header("Location: listing_details.php?id=$listing_id");
    exit();
} else {
    // If accessed directly without POST data, redirect to home
    header("Location: ../index.php");
    exit();
}
?>
