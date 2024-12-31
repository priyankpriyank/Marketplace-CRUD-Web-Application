<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "marketuser");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch listings
$listings_query = "
    SELECT 
        listings.id AS listing_id,
        listings.title,
        listings.description,
        listings.price,
        listings.image,
        listings.user_id AS owner_id,
        users.name AS owner_name
    FROM listings
    JOIN users ON listings.user_id = users.id";
$listings_result = $conn->query($listings_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="homeStyle.css">
</head>
<body>
    <div class="header">
        <h1>Welcome to the Marketplace, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p>Browse and interact with user listings.</p>
    </div>

    <div class="navbar">
        <a href="home.php" class="active">Home</a>
        <a href="listing.php">Add Listing</a>
        <a href="inbox.php">Inbox</a>
        <a href="logout.php" class="right">Logout</a>
    </div>

    <div class="row">

        <div class="main">
            <h2>Listings</h2>
            <?php if ($listings_result->num_rows > 0): ?>
                <ul class="listing-container">
                    <?php while ($listing = $listings_result->fetch_assoc()): ?>
                        <li class="listing-item">
                            <h3><?php echo htmlspecialchars($listing['title']); ?></h3>
                            <p><?php echo htmlspecialchars($listing['description']); ?></p>
                            <p><b>Price:</b> $<?php echo htmlspecialchars($listing['price']); ?></p>
                            <p><b>Seller:</b> <?php echo htmlspecialchars($listing['owner_name']); ?></p>
                            <?php if (!empty($listing['image'])): ?>
                                <img src="<?php echo htmlspecialchars($listing['image']); ?>" alt="Listing Image" style="width:200px;height:auto;">
                            <?php endif; ?>
                            <br>
                            <?php if ($listing['owner_id'] == $_SESSION['user_id']): ?>
                                <!-- Show edit and delete options if the logged-in user is the owner -->
                                <button onclick="editListing(<?php echo $listing['listing_id']; ?>)">Edit</button>
                                <button onclick="deleteListing(<?php echo $listing['listing_id']; ?>)">Delete</button>
                            <?php else: ?>
                                <button onclick="contactSeller(<?php echo $listing['listing_id']; ?>, <?php echo $listing['owner_id']; ?>)">Contact Seller</button>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No listings available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function contactSeller(listingId, ownerId) {
            const userId = <?php echo $_SESSION['user_id']; ?>;
            window.location.href = `chat.php?listing_id=${listingId}&owner_id=${ownerId}&user_id=${userId}`;
        }

        function editListing(listingId) {
            window.location.href = `edit_listing.php?listing_id=${listingId}`;
        }

        function deleteListing(listingId) {
            if (confirm("Are you sure you want to delete this listing?")) {
                window.location.href = `delete_listing.php?listing_id=${listingId}`;
            }
        }
    </script>
</body>
</html>
