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
    die("You are not authorized to edit this listing.");
}

$listing = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']); // Add price handling

    if (!empty($title) && !empty($description) && !empty($price)) {
        $update_query = "UPDATE listings SET title = ?, description = ?, price = ? WHERE id = ? AND user_id = ?";
        $stmt = $connection->prepare($update_query);
        $stmt->bind_param("ssdii", $title, $description, $price, $listing_id, $user_id);

        if ($stmt->execute()) {

            header("Location: home.php"); // Redirect to the listings page after updating
            exit;
        } else {
            echo "Error updating listing.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <style>
                /* General Styles */
        body {
            font-family: 'Georgia', serif;
            color: #333;
            background-color: #f4f4f9;
            align-items: center;
         
        }


        /* Container */
        form {
            justify-self: center;
            width: 100%;
            text-align: left;
            border: 1px solid #ddd;
            animation: fadeIn 1s ease-in-out;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            max-height:900px;
            margin: 20px auto;
            border: 1px solid #ddd;
        }

        h2 {
            text-align: center;
            font-size: 3em;
            color: #ffffff;

            font-family: 'Georgia', serif;
            margin: 0;
            padding: 0;
            background-color: #495057;
            line-height: 1.6;
            overflow-x: hidden;

        }

        label {
            display: block;
            font-weight: bold;
            color: #495057;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        input[type="number"]:focus {
            border-color: #6c757d;
            outline: none;
            box-shadow: 0 0 5px rgba(108, 117, 125, 0.5);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            
        }

        button {
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #495057;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }

    </style>
</head>
<body>

<h2>Edit Listing</h2>

<form method="POST" action="edit_listing.php?listing_id=<?php echo $listing['id']; ?>">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($listing['title']); ?>" required>
    <br>
    <label for="description">Description:</label>
    <textarea name="description" id="description" required><?php echo htmlspecialchars($listing['description']); ?></textarea>
    <br>
    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($listing['price']); ?>" required>
    <br>
    <button type="submit">Update Listing</button>
</form>

</body>
</html>
