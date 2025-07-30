<?php
header('Content-Type: application/json');
$host = "gateway01.us-west-2.prod.aws.tidbcloud.com";
$user = "2CmofanFHB8EpD6.root";
$password = "";
$dbname = "test";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

$results = [];

$tables = ['desktop', 'printer', 'telephone', 'laptop', 'cctv', 'dvr', 'server', 'manageswitch', 'software'];

foreach ($tables as $table) {
    $sql = "SELECT id, assetcode, accountable_person FROM $table 
            WHERE assetcode LIKE '%$q%' OR accountable_person LIKE '%$q%' LIMIT 5";
    $query = $conn->query($sql);
    if ($query) {
        while ($row = $query->fetch_assoc()) {
            $row['table'] = $table;
            $results[] = $row;
        }
    }
}

echo json_encode($results);
$conn->close();
?>
