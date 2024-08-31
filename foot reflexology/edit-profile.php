<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: l.html");
    exit;
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

$user = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$user]);
$userData = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $about = $_POST['about'];

    $sql = "UPDATE users SET email = ?, phone = ?, about = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $phone, $about, $user]);

    header("Location: profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header>
        <img src="https://media.istockphoto.com/id/480392420/photo/close-up-of-reflexology.jpg?s=1024x1024&w=is&k=20&c=FXO1NQvwvaybfaB1n3eDXjQKgDKrLgAzUJwDB3g3OQQ=" alt="Sharmi Foot Reflex Logo" class="logo">
        <h1>Sharmi Foot Reflexology</h1>
        <nav>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="profile-container">
        <h1>Edit Profile</h1>
        <form action="edit-profile.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userData['phone']); ?>" required>
            
            <label for="about">About Me</label>
            <textarea id="about" name="about" rows="4" required><?php echo htmlspecialchars($userData['about']); ?></textarea>
            
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
