<?php
session_start();
include 'db.php';

if (isset($_POST['id'], $_POST['table'])) {
    $id = (int)$_POST['id'];
    $table = $_POST['table'];
    $allowedTables = ['desktop', 'printer', 'telephone', 'laptop', 'cctv', 'dvr', 'server', 'manageswitch', 'software'];

    if (in_array($table, $allowedTables)) {
        $assetcode = $_POST['assetcode'];
        $accountable_person = $_POST['accountable_person'];
        $device_name = $_POST['device_name'];
        $model = $_POST['model'];
        $line_type = $_POST['line_type'];
        $loc = $_POST['loc'];
        $stat = $_POST['stat'];

        $stmt = $conn->prepare("
          UPDATE `$table` 
          SET assetcode = ?, 
              accountable_person = ?, 
              device_name = ?, 
              model = ?, 
              line_type = ?, 
              loc = ?, 
              stat = ? 
          WHERE id = ?
        ");
        $stmt->bind_param("sssssssi", $assetcode, $accountable_person, $device_name, $model, $line_type, $loc, $stat, $id);

        if ($stmt->execute()) {
            $_SESSION['edit_success'] = true;
        }

        $stmt->close();
        header("Location: {$table}.php");
        exit();
    }
}
?>
