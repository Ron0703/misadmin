<?php
session_start();
include 'db.php';

// --- TOTAL COUNTS ---
$desktopCount = $conn->query("SELECT COUNT(*) AS total FROM desktop")->fetch_assoc()['total'];
$printerCount = $conn->query("SELECT COUNT(*) AS total FROM printer")->fetch_assoc()['total'];
$telephoneCount = $conn->query("SELECT COUNT(*) AS total FROM telephone")->fetch_assoc()['total'];
$laptopCount = $conn->query("SELECT COUNT(*) AS total FROM laptop")->fetch_assoc()['total'];
$cctvCount = $conn->query("SELECT COUNT(*) AS total FROM cctv")->fetch_assoc()['total'];
$dvrCount = $conn->query("SELECT COUNT(*) AS total FROM dvr")->fetch_assoc()['total'];
$serverCount = $conn->query("SELECT COUNT(*) AS total FROM server")->fetch_assoc()['total'];
$manageswitchCount = $conn->query("SELECT COUNT(*) AS total FROM manageswitch")->fetch_assoc()['total'];
$softwareCount = $conn->query("SELECT COUNT(*) AS total FROM software")->fetch_assoc()['total'];

$grandTotal = $desktopCount + $printerCount + $telephoneCount + $laptopCount + $cctvCount + $dvrCount + $serverCount + $manageswitchCount + $softwareCount;

// --- COMBINED LIST ---
$combinedQuery = "
    SELECT id, assetcode, accountable_person, 'Desktop' AS type FROM desktop
    UNION ALL
    SELECT id, assetcode, accountable_person, 'Printer' AS type FROM printer
    UNION ALL
    SELECT id, assetcode, accountable_person, 'Telephone' AS type FROM telephone
    UNION ALL
    SELECT id, assetcode, accountable_person, 'Laptop' AS type FROM laptop
    UNION ALL
    SELECT id, assetcode, accountable_person, 'CCTV' AS type FROM cctv
    UNION ALL
    SELECT id, assetcode, accountable_person, 'DVR' AS type FROM dvr
    UNION ALL
    SELECT id, assetcode, accountable_person, 'Server' AS type FROM server
    UNION ALL
    SELECT id, assetcode, accountable_person, 'ManageSwitch' AS type FROM manageswitch
    UNION ALL
    SELECT id, assetcode, accountable_person, 'Software' AS type FROM software
    ORDER BY type, id ASC
";
$combinedResult = $conn->query($combinedQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Summary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<style>
  /* Color-coded rows */
tr.type-desktop td {
  background-color: #007bff !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-printer td {
  background-color: #ae00ff !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-telephone td {
  background-color: #ff00bf !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-laptop td {
  background-color: #2a9c08 !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-cctv td {
  background-color: #585858 !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-dvr td {
  background-color: #ff0000 !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-server td {
  background-color: #ffd000 !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-manageswitch td {
  background-color: #ffa600 !important; 
  color: #fff !important;
  text-align: center;
}

tr.type-software td {
  background-color: #bbff8e !important; 
  color: #000 !important;
  text-align: center;
}

/* Hover effect */
.table tbody tr:hover {
  filter: brightness(0.95);
}

</style>
<body>
<div class="container mt-4">

  <!-- Home Button -->
  <a href="dashboard.html" class="btn-home mb-4">
    <i class="bi bi-house-door-fill"></i> Home
  </a>

  <h1 class="text-center mb-4" style="cursor: pointer;" onclick="location.reload();" title="Click to refresh">
    Inventory Totals
  </h1>

  <!-- Totals Table -->
  <table class="table table-bordered text-center">
    <thead class="table-dark">
      <tr>
        <th>Inventory Category</th>
        <th>Total Items</th>
      </tr>
    </thead>
    <tbody>
      <tr class="type-desktop"><td>Desktop</td><td><?= $desktopCount ?></td></tr>
      <tr class="type-printer"><td>Printer</td><td><?= $printerCount ?></td></tr>
      <tr class="type-telephone"><td>Telephone</td><td><?= $telephoneCount ?></td></tr>
      <tr class="type-laptop"><td>Laptop</td><td><?= $laptopCount ?></td></tr>
      <tr class="type-cctv"><td>CCTV</td><td><?= $cctvCount ?></td></tr>
      <tr class="type-dvr"><td>DVR</td><td><?= $dvrCount ?></td></tr>
      <tr class="type-server"><td>Server</td><td><?= $serverCount ?></td></tr>
      <tr class="type-manageswitch"><td>ManageSwitch</td><td><?= $manageswitchCount ?></td></tr>
      <tr class="type-software"><td>Software</td><td><?= $softwareCount ?></td></tr>
      <tr class="table-primary fw-bold"><td>Total</td><td><?= $grandTotal ?></td></tr>
    </tbody>
  </table>

  <h2 class="mt-5 mb-3 text-center">Combined Inventory List</h2>

  <!-- Scrollable Table -->
  <div class="scrollable-table">
    <table class="table table-bordered mb-0">
      <thead class="table-secondary text-center">
        <tr>
          <th>#</th>
          <th>Asset Code</th>
          <th>Accountable Person</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $counter = 1;
          while ($row = $combinedResult->fetch_assoc()):
            $type = strtolower($row['type']); // e.g., desktop, laptop
            $class = "type-" . $type;
        ?>
          <tr class="<?= $class ?>">
            <td><?= $counter ?></td>
            <td><?= htmlspecialchars($row['assetcode']) ?></td>
            <td><?= htmlspecialchars($row['accountable_person']) ?></td>
            <td class="fw-bold"><?= htmlspecialchars($row['type']) ?></td>
          </tr>
        <?php 
          $counter++; 
          endwhile; 
        ?>
      </tbody>
    </table>
  </div>

</div>
</body>
</html>
