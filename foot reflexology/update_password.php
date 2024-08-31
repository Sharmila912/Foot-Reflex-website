<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit;
}

// Get user data from session
$username = $_SESSION['username'];
$email = $_SESSION['email']; // Get phone number from session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new values
    $new_username = $_POST['new-username'];
    $new_email = $_POST['new-email'];

    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Initialize PDO
    $conn = new PDO("mysql:host=localhost;dbname=foot_reflexology", 'root', '');

    // Prepare the SQL query to update user details
    if ($new_password === $confirm_password && strlen($new_password) >= 8) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$new_username, $new_email, $hashed_password, $_SESSION['email']]);

        // Update session with new details
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;


        echo "<p>Profile updated successfully!</p>";
    } else {
        echo "<p>Passwords do not match or are less than 8 characters.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #c7e9f5, #f2d2d2);
        }

        .profile-container {
            max-width: 600px;
            margin: 100px auto 0;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            margin-bottom: 20px;
        }

        .profile-container p {
            font-size: 18px;
            margin: 10px 0;
        }

        .profile-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .profile-container input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .profile-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-container button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Update Profile</h2>
    <form method="POST" action="">
        <label for="new-username">New Username:</label>
        <input type="text" id="new-username" name="new-username" value="<?php echo htmlspecialchars($username); ?>" required>
        
        <label for="new-email">New Email:</label>
        <input type="email" id="new-email" name="new-email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        
        <label for="new-password">Password:</label>
        <input type="password" id="new-password" name="new-password">
        
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password">
        
        <button type="submit">Update Profile</button>
    </form>
</div>


</body>
</html>
