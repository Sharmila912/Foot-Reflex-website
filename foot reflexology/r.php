<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'foot_reflexology';
$username = 'root';  // Your MySQL username
$password = '';      // Your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate inputs
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if the email already exists
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user_exists = $stmt->fetchColumn();

    if ($user_exists > 0) {
        echo "An account with this email already exists.";
        exit;
    }

    // Hash the password and insert into the database
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$user, $email, $hashed_password])) {
        // Store user data in session
        $_SESSION['username'] = $user;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;  // Normally you shouldn't store password in session

        // Redirect to user page
        header("Location: l.html");
        exit;
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>
