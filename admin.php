<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: lightgray;
            z-index: 2; 
            position: relative; 
        }
        .logo {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        .epic {
            font-size: 24px;
            color: Black;
        }

        .dot {
            color: #28a745;
            font-size:xx-large; 
        }
        .navbar {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .navbar a {
            padding: 10px 20px;
            font-size: 20px;
            color: black;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #28a745;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #28a745;
        }

        .input-group input {
            width: 96%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 3px;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
        <div class="logo">
       
            <span class="epic">Epic<span class="dot">.</span>Green</span>
        </div>
        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="admin.php" class="admin-link">Admin</a>
        </nav>
    </header>
<div class="login-container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <?php
    session_start();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check username and password
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Hardcoded credentials (Replace with your actual credentials)
        $valid_username = "admin";
        $valid_password = "123";
        
        // Check if username and password match
        if ($username === $valid_username && $password === $valid_password) {
            // Authentication successful
            $_SESSION['username'] = $username;
            header("Location: raw_material.php"); // Redirect to dashboard
            exit;
        } else {
            // Authentication failed
            echo "<p style='color: red; text-align: center;'>Invalid username or password</p>";
        }
    }
    ?>
</div>
</body>
</html>
