<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.php">
</head>
<body>
    <div class="container">
        <h2>Welcome Back</h2>
        <p id="error-message" class="error" style="display: none;"></p>
        <form method="POST" action="login.php">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <?php 
                if(isset($_GET['error'])){
                    echo '<h4 id="eMessage">'.$_GET['error'].'</h4>';
                }
            ?>
            <?php 
                if(isset($_GET['success'])){
                    echo '<h4 id="sMessage">'.$_GET['success'].'</h4>';
                }
            ?>

            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>