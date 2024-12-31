<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$connection = new mysqli('localhost', 'root', '', 'marketuser');

// Check if the connection is successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$listing_id = $_GET['listing_id']; // The listing that the user contacted about
$owner_id = $_GET['owner_id']; // Logged-in owner ID
$user_id = $_GET['user_id']; // The user who messaged the owner

// Get listing details (title) to display on the page
$listing_query = "SELECT title FROM listings WHERE id = ?";
$stmt = $connection->prepare($listing_query);
$stmt->bind_param("i", $listing_id);
$stmt->execute();
$listing_result = $stmt->get_result();
$listing = $listing_result->fetch_assoc();

$title = htmlspecialchars($listing['title']); // Sanitize output for security

// Get the chat messages between the user and the owner
$chat_query = "
    SELECT messages.*, users.name AS sender_name 
    FROM messages
    JOIN users ON messages.sender_id = users.id
    WHERE messages.listing_id = ? 
      AND ((messages.sender_id = ? AND messages.receiver_id = ?) 
       OR (messages.sender_id = ? AND messages.receiver_id = ?))
    ORDER BY messages.id ASC";

$stmt = $connection->prepare($chat_query);
$stmt->bind_param("iiiii", $listing_id, $user_id, $owner_id, $owner_id, $user_id);
$stmt->execute();
$chat_result = $stmt->get_result();

// Handle form submission (message sending)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = trim($_POST['message']);  // Trim white spaces

    if (!empty($message)) {
        // Insert message into the database with correct sender and receiver
        $insert_message_query = "INSERT INTO messages (listing_id, sender_id, receiver_id, message) 
                                 VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($insert_message_query);
        $stmt->bind_param("iiis", $listing_id, $user_id, $owner_id, $message); // user_id as sender and owner_id as receiver
        if ($stmt->execute()) {
            header("Location: chat.php?listing_id=$listing_id&owner_id=$owner_id&user_id=$user_id"); // Refresh the chat
            exit;
        } else {
            echo "Error: Message could not be sent.";
        }
    } else {
        echo "Please enter a message.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat for Listing: <?php echo $title; ?></title>
    <style>
        /* Add your custom styles here */
        /* General Styles */
body {
    font-family: 'Georgia', serif;
    color: #333;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    line-height: 1.6;
    overflow-x: hidden;
}

/* Header */
.header {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
    padding: 30px 20px;
    text-align: center;
    border-bottom: 5px solid #343a40;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.header h1 {
    margin: 0;
    font-size: 3em;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}
.header p {
    font-size: 1.3em;
    margin-top: 10px;
}

/* Navbar */
.navbar {
    overflow: hidden;
    background-color: #343a40;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}
.navbar a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
    font-size: 1.1em;
    transition: all 0.3s ease;
}
.navbar a:hover {
    background-color: #495057;
    color: #f8f9fa;
    transform: scale(1.1);
}
.navbar a.right {
    margin-left: auto;
}
.navbar .active {
    background-color: #6c757d;
    font-weight: bold;
    border-radius: 5px;
}

/* Layout */
.row {
    display: flex;
    margin: 20px;
    flex-wrap: wrap;
}

.main {
    flex: 70%;
    background: white;
    padding: 30px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin: auto;
    max-width: 1200px;
    border: 1px solid #ddd;
    animation: fadeIn 1s ease-in-out;
}

/* Listings */
.listing-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.listing-item {
    background: #ffffff;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}
.listing-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}
.listing-item h3 {
    font-size: 1.8em;
    margin: 0 0 10px;
    color: #495057;
}
.listing-item p {
    margin: 5px 0;
    color: #555;
}
.listing-item img {
    display: block;
    margin: 10px 0;
    border-radius: 8px;
    max-width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.listing-item button {
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
}
.listing-item button:hover {
    background-color: #495057;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Form Styles */
form {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
    border: 1px solid #ddd;
}
form label {
    display: block;
    margin: 15px 0 5px;
    font-weight: bold;
    color: #495057;
}
form input,
form textarea {
    width: 100%;
    padding: 10px;
    margin: 5px 0 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 1em;
}
form textarea {
    resize: vertical;
    height: 100px;
}
form input[type="file"] {
    padding: 5px;
}
form button {
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
}
form button:hover {
    background-color: #495057;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Chat Styles */
.chat-container {
    display: flex;
    flex-direction: column;
    max-width: 800px;
    margin: 20px auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    
}
.chat-header {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 1.5em;
    font-weight: bold;
    border-bottom: 3px solid #343a40;
}
.chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    height: 400px;
    background-color: #f9f9f9;

    padding:10px;
    
}
.message {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
    word-wrap: break-word;
    font-size: 0.95em;
    
}
.sent {
    background-color: #d1f7c4;
    margin-left: auto;
    border: 1px solid #a8d5a1;
}
.received {
    background-color: #f1f0f0;
    margin-right: auto;
    border: 2px solid red;
    border: 1px solid #d6d6d6;
}
.chat-input {
    width: 100%;
    display:flex;
    
}
.chat-input textarea {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95em;
}
.chat-input button {
    
    margin-left: 10px;

    background-color: #343a40;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 0.95em;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}
.chat-input button:hover {
    background-color: #495057;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .listing-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .main {
        flex: 100%;
        padding: 20px;
    }
    .listing-container {
        grid-template-columns: 1fr;
    }
    .navbar a {
        font-size: 1em;
        padding: 10px;
    }
    .chat-container {
        max-width: 100%;
    }
}

/* Animations */
/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">
        <h2>Chat for: <?php echo $title; ?></h2>
    </div>
    <div class="chat-messages">
        <?php while ($message = $chat_result->fetch_assoc()): ?>
            <div class="message <?php echo $message['sender_id'] == $user_id ? 'received' : 'sent'; ?>">
                <p><strong><?php echo htmlspecialchars($message['sender_name']); ?>:</strong></p>
                <p><?php echo htmlspecialchars($message['message']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <form class="chat-input" method="POST">
        <textarea name="message" placeholder="Type your message..." required></textarea>
        <input type="hidden" name="receiver_id" value="<?php echo $owner_id; ?>">
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
