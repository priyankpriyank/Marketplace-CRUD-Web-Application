<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$connection = new mysqli('localhost', 'root', '', 'marketuser');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the listing_id from the URL
$listing_id = $_GET['listing_id'];
$user_id = $_SESSION['user_id'];

// Check if the logged-in user owns this listing
$query = "SELECT * FROM listings WHERE id = ? AND user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("ii", $listing_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("You are not authorized to delete this listing.");
}

// Step 1: Delete related messages
$message_delete_query = "DELETE FROM messages WHERE listing_id = ?";
$message_stmt = $connection->prepare($message_delete_query);
$message_stmt->bind_param("i", $listing_id);
$message_stmt->execute();

// Step 2: Delete the listing
$delete_query = "DELETE FROM listings WHERE id = ? AND user_id = ?";
$delete_stmt = $connection->prepare($delete_query);
$delete_stmt->bind_param("ii", $listing_id, $user_id);

if ($delete_stmt->execute()) {
    header("Location: home.php"); // Redirect to the listings page after deletion
    exit;
} else {
    echo "Error deleting listing.";
}
?>
