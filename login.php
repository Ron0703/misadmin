<?php
session_start();

// Database credentials
$host = "localhost";
$dbname = "admin_login_system";
$user = "root";
$pass = "";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input safely
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Return if empty
if (empty($username) || empty($password)) {
    $error = urlencode("Username or password cannot be empty.");
    header("Location: index.html?error=$error");
    exit();
}

// Prepare and query user
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Use password_verify if you stored the password with password_hash()
    if (password_verify($password, $row['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $username;
        header("Location: hm.html");
        exit();
    } else {
        $error = urlencode("Invalid username or password.");
        header("Location: index.html?error=$error");
        exit();
    }
} else {
    $error = urlencode("Invalid username or password.");
    header("Location: index.html?error=$error");
    exit();
}
?>
