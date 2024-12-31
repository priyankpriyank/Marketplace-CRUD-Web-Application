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

// Handle signup logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
                header("Location: register.php?error= Email already exists. Please log in.");
        } else {
            // Insert new user
            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            // Success message
            header("Location: index.php?success= Account created successfully! Please log in.");
            
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
