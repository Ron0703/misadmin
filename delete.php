<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = (int)$_GET['id'];
    $table = $_GET['table'];

    // Whitelist allowed tables to prevent SQL injection
    $allowedTables = ['desktop', 'printer', 'telephone', 'laptop', 'cctv', 'dvr', 'server', 'manageswitch', 'software'];

    if (in_array($table, $allowedTables)) {
        // Secure deletion using prepared statement
        $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Optional: Reindex IDs (only safe if no foreign key constraints)
        $conn->query("SET @count = 0");
        $conn->query("UPDATE `$table` SET id = @count:=@count+1");
        $conn->query("ALTER TABLE `$table` AUTO_INCREMENT = 1");

        // Redirect back to appropriate table page
        header("Location: {$table}.php");
        exit();
    } else {
        // Invalid table name
        echo "Invalid table name.";
    }
} else {
    echo "Missing ID or table parameter.";
}
?>
