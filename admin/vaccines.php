<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['admin']);

$database = Database::getInstance();
$conn = $database->getConnection();
$message = '';
$error = '';

// Add Vaccine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vaccine'])) {
    $vaccine_id = generateUniqueId('VAC');
    $name = sanitize($_POST['name']);
    $manufacturer = sanitize($_POST['manufacturer']);
    $type = sanitize($_POST['type']);
    $description = sanitize($_POST['description']);
    $dosage_interval = intval($_POST['dosage_interval']);
    $total_doses = intval($_POST['total_doses']);
    $quantity = intval($_POST['quantity']);
    
    $query = "INSERT INTO vaccines (vaccine_id, name, manufacturer, type, description, dosage_interval, total_doses, quantity, availability_status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'available')";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$vaccine_id, $name, $manufacturer, $type, $description, $dosage_interval, $total_doses, $quantity])) {
        $message = "Vaccine added successfully!";
    } else {
        $error = "Failed to add vaccine!";
    }
}

// Update Vaccine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_vaccine'])) {
    $vaccine_id = sanitize($_POST['vaccine_id']);
    $quantity = intval($_POST['quantity']);
    $availability_status = sanitize($_POST['availability_status']);
    $query = "UPDATE vaccines SET quantity = ?, availability_status = ? WHERE vaccine_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$quantity, $availability_status, $vaccine_id])) {
        $message = "Vaccine updated successfully!";
    } else {
        $error = "Failed to update vaccine!";
    }
}

// Delete Vaccine
if (isset($_GET['delete'])) {
    $vaccine_id = sanitize($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM vaccines WHERE vaccine_id = ?");
    if ($stmt->execute([$vaccine_id])) {
        $message = "Vaccine deleted successfully!";
    } else {
        $error = "Cannot delete vaccine – it may have related records.";
    }
    header("Location: vaccines.php");
    exit();
}

// Get all vaccines
$stmt = $conn->query("SELECT * FROM vaccines ORDER BY created_at DESC");
$vaccines = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Vaccine Management";
include '../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-4x mb-3 text-primary"></i>
                    <h5>Admin Panel</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="hospitals.php" class="list-group-item list-group-item-action">Manage Hospitals</a>
                    <a href="patients.php" class="list-group-item list-group-item-action">Manage Patients</a>
                    <a href="approve-hospitals.php" class="list-group-item list-group-item-action">Pending Approvals</a>
                    <a href="vaccines.php" class="list-group-item list-group-item-action active">Vaccine Management</a>
                    <a href="reports.php" class="list-group-item list-group-item-action">Reports</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-lg-10">
            <h2><i class="fas fa-syringe me-2"></i>Vaccine Management</h2>
            <?php if ($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
            
            <!-- Add Vaccine Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white"><h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Vaccine</h5></div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3"><label>Vaccine Name *</label><input type="text" class="form-control" name="name" required></div>
                            <div class="col-md-4 mb-3"><label>Manufacturer</label><input type="text" class="form-control" name="manufacturer"></div>
                            <div class="col-md-4 mb-3"><label>Type</label><select class="form-control" name="type"><option>Viral Vector</option><option>mRNA</option><option>Inactivated Virus</option><option>Protein Subunit</option></select></div>
                            <div class="col-12 mb-3"><label>Description</label><textarea class="form-control" name="description" rows="2"></textarea></div>
                            <div class="col-md-3 mb-3"><label>Dosage Interval (days)</label><input type="number" class="form-control" name="dosage_interval" value="28"></div>
                            <div class="col-md-3 mb-3"><label>Total Doses</label><input type="number" class="form-control" name="total_doses" value="2"></div>
                            <div class="col-md-3 mb-3"><label>Initial Quantity</label><input type="number" class="form-control" name="quantity" value="0"></div>
                            <div class="col-md-3 mb-3"><label>&nbsp;</label><button type="submit" name="add_vaccine" class="btn btn-primary w-100">Add Vaccine</button></div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Vaccines List -->
            <div class="card">
                <div class="card-header bg-success text-white"><h5 class="mb-0"><i class="fas fa-list me-2"></i>Vaccine Inventory</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="vaccinesTable">
                            <thead><tr><th>ID</th><th>Name</th><th>Manufacturer</th><th>Type</th><th>Total Doses</th><th>Quantity</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach ($vaccines as $v): ?>
                                <tr>
                                    <form method="POST">
                                        <input type="hidden" name="vaccine_id" value="<?php echo $v['vaccine_id']; ?>">
                                        <td><?php echo $v['vaccine_id']; ?></td>
                                        <td><?php echo htmlspecialchars($v['name']); ?></td>
                                        <td><?php echo $v['manufacturer']; ?></td>
                                        <td><?php echo $v['type']; ?></td>
                                        <td><?php echo $v['total_doses']; ?></td>
                                        <td><input type="number" name="quantity" class="form-control" value="<?php echo $v['quantity']; ?>" style="width:100px;"></td>
                                        <td>
                                            <select name="availability_status" class="form-control">
                                                <option value="available" <?php echo $v['availability_status']=='available'?'selected':''; ?>>Available</option>
                                                <option value="low_stock" <?php echo $v['availability_status']=='low_stock'?'selected':''; ?>>Low Stock</option>
                                                <option value="unavailable" <?php echo $v['availability_status']=='unavailable'?'selected':''; ?>>Unavailable</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" name="update_vaccine" class="btn btn-sm btn-primary">Update</button>
                                            <a href="?delete=<?php echo $v['vaccine_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this vaccine?')">Delete</a>
                                        </td>
                                    </form>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>