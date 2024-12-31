
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.php">
</head>
<body>
    <div class="container">
        <h2>Create an Account</h2>

        <!-- Signup Form -->
        <form method="POST" action="signup.php" id="signup-form">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <?php 
                if(isset($_GET['error'])){
                    echo "<h4>".$_GET['error']."</h4>";
                }
            ?>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="index.php">Log in</a></p>
    </div>

    <!-- Link to external JavaScript file -->
    <script src="script.js"></script>
</body>
</html>
