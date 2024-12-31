<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "marketuser");

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];
    $image_path = "";

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Error uploading image.";
        }
    }

    // Insert listing into the database
    $stmt = $conn->prepare("INSERT INTO listings (title, description, price, image, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $title, $description, $price, $image_path, $user_id);
    $stmt->execute();

    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Listing</title>
    <link rel="stylesheet" href="listingstyle.css">
</head>
<body>
    <div class="header">
        <h1>Add a New Listing</h1>
    </div>

    <div class="main">
        <form action="listing.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Add Listing</button>
        </form>
    </div>
</body>
</html>
