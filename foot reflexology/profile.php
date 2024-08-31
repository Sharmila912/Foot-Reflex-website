<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}

// Get user data from session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];  // For display, but avoid this in production

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body{
         font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
         background: linear-gradient(to right, #c7e9f5, #f2d2d2);
        }

        .user-container {
            max-width: 600px;
            margin: 175px auto 0;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .user-container h2 {
            margin-bottom: 20px;
        }

        .user-container p {
            font-size: 18px;
            margin: 10px 0;
        }

        .user-container a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            background-color: #ddd;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="user-container">
    <h2>Profile</h2>
    
    <p><strong>Name:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
   
    
    <!-- You can provide an option to update password here -->
    <a href="update_password.php">Update Profile</a>
</div>

</body>
</html>
