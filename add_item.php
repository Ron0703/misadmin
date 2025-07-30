<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "inventorydb";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    header("Location: dashboard.html?status=error");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['table'], $_POST['assetcode'], $_POST['accountable_person'], $_POST['device_name'], $_POST['model'], $_POST['line_type'], $_POST['loc'], $_POST['stat'])) {

    $table = $_POST['table'];
    $validTables = ['desktop', 'printer', 'telephone', 'laptop', 'cctv', 'dvr', 'server', 'manageswitch', 'software'];
    if (!in_array($table, $validTables)) {
        error_log("Invalid table: $table");
        header("Location: dashboard.html?status=error");
        exit();
    }

    $assetcode = $conn->real_escape_string(trim($_POST['assetcode']));
    $accountable_person = $conn->real_escape_string(trim($_POST['accountable_person']));
    $device_name = $conn->real_escape_string(trim($_POST['device_name']));
    $model = $conn->real_escape_string(trim($_POST['model']));
    $line_type = $conn->real_escape_string(trim($_POST['line_type']));
    $loc = $conn->real_escape_string(trim($_POST['loc']));
    $stat = $conn->real_escape_string(trim($_POST['stat']));

    $checkSql = "SELECT id FROM `$table` WHERE assetcode = ?";
    $stmt = $conn->prepare($checkSql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $assetcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        header("Location: dashboard.html?status=duplicate");
        exit();
    }
    $stmt->close();

    $insertSql = "INSERT INTO `$table` (assetcode, accountable_person, device_name, model, line_type, loc, stat)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    if (!$stmt) {
        die("Insert prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $assetcode, $accountable_person, $device_name, $model, $line_type, $loc, $stat);
    if ($stmt->execute()) {
        header("Location: dashboard.html?status=success");
    } else {
        error_log("Insert error: " . $stmt->error);
        header("Location: dashboard.html?status=error");
    }

    $stmt->close();
    $conn->close();
} else {
    error_log("Invalid POST or missing fields");
    header("Location: dashboard.html?status=error");
}
?>
