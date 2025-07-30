<?php
session_start();

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

// DB connection
$host = "127.0.0.1";
$dbname = "inventorydb";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current admin info
$currentUser = $_SESSION['admin_user'];
$adminQuery = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$adminQuery->bind_param("s", $currentUser);
$adminQuery->execute();
$result = $adminQuery->get_result();
$admin = $result->fetch_assoc();

$successMessage = "";
$isError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['admin_name']);
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Update username
    if (!empty($newUsername) && $newUsername !== $currentUser) {
        $stmt = $conn->prepare("UPDATE admins SET username = ? WHERE username = ?");
        $stmt->bind_param("ss", $newUsername, $currentUser);
        if ($stmt->execute()) {
            $_SESSION['admin_user'] = $newUsername;
            $currentUser = $newUsername; // Update current user reference
            $successMessage .= "Username updated successfully.\n";
        } else {
            $successMessage .= "Failed to update username.\n";
            $isError = true;
        }
    }

    // Update password (only if new and confirm fields are filled)
    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword !== $confirmPassword) {
            $successMessage .= "New passwords do not match.\n";
            $isError = true;
        } else {
            $hashedNew = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashedNew, $currentUser);
            if ($stmt->execute()) {
                $successMessage .= "Password updated successfully.\n";
            } else {
                $successMessage .= "Failed to update password.\n";
                $isError = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - MIS Inventory</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="dashboard.css"> 
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="text-center mb-4">Menu</h4>
  <a href="dashboard.html"><i class="fas fa-home me-2"></i> Dashboard</a>
  <a href="settings.php" class="fw-bold text-primary"><i class="fas fa-cog me-2"></i> Settings</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
  <h1 class="mb-5 text-center fw-bold">Settings</h1>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card p-4 shadow-sm">
          <h5 class="mb-3"><i class="fas fa-user-cog me-2"></i>Update Admin Info</h5>
          <form method="POST">
            <div class="mb-3">
              <label for="admin_name" class="form-label">Admin Username</label>
              <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?= htmlspecialchars($admin['username']) ?>" required>
            </div>

            <hr>

            <h6 class="text-muted">Change Password (optional)</h6>
            <div class="mb-3">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SweetAlert Message -->
<?php if (!empty($successMessage)) : ?>
<script>
  Swal.fire({
    title: 'Settings',
    text: `<?= str_replace(["\r", "\n"], ["", "\\n"], trim($successMessage)) ?>`,
    icon: '<?= $isError ? "error" : "success" ?>',
    confirmButtonText: 'OK'
  });
</script>
<?php endif; ?>

</body>
</html>
