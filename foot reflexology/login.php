<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful! Welcome " . $user['username'];
        header("Location: suc.html");
        // You can start a session and redirect the user to a dashboard page
        // session_start();
        // $_SESSION['user'] = $user['username'];
        // header("Location: dashboard.php");
    } else {
        echo "Invalid credentials!";
    }
}
?>
