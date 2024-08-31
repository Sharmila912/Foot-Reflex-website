<?php
session_start();  // Resume the session

// Check if the user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'foot_reflexology';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $aadhaar = trim($_POST['aadhaar']);
    $dob = $_POST['dob'];
    $phone = trim($_POST['phone']);
    $email = $_SESSION['email'];  // Email is fetched from session

    // Update user details in the database
    $sql = "UPDATE users SET name = ?, aadhaar = ?, dob = ?, phone = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$name, $aadhaar, $dob, $phone, $email])) {
        $_SESSION['name'] = $name;  // Update session with new name
        echo "Profile updated successfully!";
    } else {
        echo "Failed to update profile!";
    }
}
?>
