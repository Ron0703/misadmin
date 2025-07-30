<?php
session_start();
include 'db.php';

// Fetch data from the server table
$result = $conn->query("SELECT * FROM server");

// Get the row to highlight if provided
$highlightId = isset($_GET['highlight']) ? intval($_GET['highlight']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Server Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .specs-row {
      background-color: #f8f9fa;
      display: none;
    }
    .specs-row.show {
      display: table-row;
    }
    .specs-text {
      white-space: pre-wrap;
      font-family: monospace;
    }

    .modal-body {
      max-height: 400px;
      overflow-y: auto;
    }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center">
        <a href="dashboard.html" class="btn-home me-3">
          <i class="fas fa-home"></i> Home</a>
        <h2 id="refresh-server" class="mb-0" style="cursor: pointer;">Server Inventory</h2>
      </div>
    </div>

    <!-- Table -->
    <div class="table-responsive custom-scroll">
      <table class="table custom-table table-bordered table-hover">
        <thead>
          <tr>
            <th>Asset Code</th>
            <th>Accountable Person</th>
            <th>Device Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): 
          $highlightClass = ($highlightId === (int)$row['id']) ? 'table-warning' : '';
        ?>
          <!-- Main Row -->
          <tr id="row-<?php echo $row['id']; ?>" class="data-row <?= $highlightClass ?>" data-id="<?= $row['id'] ?>" data-table="server">
            <td><?= htmlspecialchars($row['assetcode']) ?></td>
            <td><?= htmlspecialchars($row['accountable_person']) ?></td>
            <td><?= htmlspecialchars($row['device_name']) ?></td>
            <td class="text-center">
              <div class="d-flex justify-content-center flex-wrap gap-1">
                <!-- View Specs Button -->
                <button 
                  class="btn btn-info btn-sm me-1 toggle-specs-btn"
                  data-id="<?= $row['id'] ?>"
                  data-table="server"
                  data-assetcode="<?= htmlspecialchars($row['assetcode']) ?>">
                  <i class="fas fa-eye"></i> View Specs
                </button>

                <!-- Edit Button -->
                <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">
                  <i class="fas fa-edit"></i> Edit
                </button>

                <!-- Delete Button -->
                <a href="delete.php?id=<?= $row['id'] ?>&table=server" 
                  class="btn btn-danger btn-sm delete-btn" 
                  data-id="<?= $row['id'] ?>" 
                  data-table="server">
                  <i class="fas fa-trash-alt"></i> Delete
                </a>
              </div>
            </td>
          </tr>

          <!-- Expandable Specs Row -->
          <tr class="specs-row" id="specs-<?= $row['id'] ?>">
            <td colspan="4">
              <div id="specs-content-<?= $row['id'] ?>" class="p-3 specs-text text-muted" data-loaded="false">
                Loading specs...
              </div>
            </td>
          </tr>

          <!-- Edit Modal -->
          <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
              <form method="POST" action="edit.php">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Edit Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="table" value="server">

                    <div class="mb-3">
                      <label class="form-label">Asset Code</label>
                      <input type="text" class="form-control" name="assetcode" value="<?= $row['assetcode'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Accountable Person</label>
                      <input type="text" class="form-control" name="accountable_person" value="<?= $row['accountable_person'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Device Name</label>
                      <input type="text" class="form-control" name="device_name" value="<?= $row['device_name'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Model</label>
                      <input type="text" class="form-control" name="model" value="<?= $row['model'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Line Type</label>
                      <input type="text" class="form-control" name="line_type" value="<?= $row['line_type'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Location</label>
                      <input type="text" class="form-control" name="loc" value="<?= $row['loc'] ?>">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <input type="text" class="form-control" name="stat" value="<?= $row['stat'] ?>">
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>

  <!-- SweetAlert Success -->
  <?php if (isset($_SESSION['edit_success'])): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Item Updated',
        text: 'The inventory item has been successfully updated.',
        confirmButtonColor: '#3085d6'
      });
    </script>
    <?php unset($_SESSION['edit_success']); ?>
  <?php endif; ?>

</body>
</html>
