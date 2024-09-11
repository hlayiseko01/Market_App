<?php
function sanitize_input($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}


function get_listings($category, $limit = 100) {
    global $conn;
    $category = sanitize_input($category);
    $sql = "SELECT * FROM listings WHERE category = '$category' ORDER BY created_at DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}