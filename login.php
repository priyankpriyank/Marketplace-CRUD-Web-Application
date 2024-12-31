<?php
// Start session
session_start();

// Database connection
$host = 'localhost';
$dbname = 'marketuser';
$username = 'root'; // Replace with your DB username
$password = '';     // Replace with your DB password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize error or success message
$error = '';
$success = '';

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Fetch user by email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Valid user: start session and redirect to home
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php");
            exit;
        } else {
            // Invalid credentials
            header("Location: index.php?error= Invalid email or password. Please sign up if you don't have an account.");
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Check for success messages from signup
if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
}
?>

