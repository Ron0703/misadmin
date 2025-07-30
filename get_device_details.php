<?php
include 'db.php';
header('Content-Type: application/json');

// Avoid printing errors as HTML
ini_set('display_errors', 0);       // Don't display errors
ini_set('log_errors', 1);           // Log errors instead
error_reporting(E_ALL);             // Report all errors

$assetcode = isset($_GET['assetcode']) ? $_GET['assetcode'] : '';
$table = isset($_GET['table']) ? $_GET['table'] : '';

$tableMap = [
  'desktop' => 'desktop',
  'printer' => 'printer',
  'telephone' => 'telephone',
  'laptop' => 'laptop',
  'cctv' => 'cctv',
  'dvr' => 'dvr',
  'server' => 'server',
  'manageswitch' => 'manageswitch',
  'software' => 'software'
];


if (!array_key_exists($table, $tableMap)) {
  echo json_encode(['error' => 'Invalid table specified']);
  exit;
}

$stmt = $conn->prepare("SELECT model, line_type, loc, stat FROM {$tableMap[$table]} WHERE assetcode = ?");
$stmt->bind_param("s", $assetcode);

if ($stmt->execute()) {
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
  } else {
    echo json_encode(['error' => 'No record found']);
  }
} else {
  echo json_encode(['error' => 'Database query failed']);
}
ini_set('display_errors', 1); // TEMP: enable error display

$stmt->close();
$conn->close();
?>
