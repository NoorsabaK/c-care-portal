<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);
$hospitalId = $_SESSION['user_id'];
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
    
    $query = "INSERT INTO vaccines (vaccine_id, hospital_id, name, manufacturer, type, description, dosage_interval, total_doses, quantity, availability_status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$vaccine_id, $hospitalId, $name, $manufacturer, $type, $description, $dosage_interval, $total_doses, $quantity])) {
        $message = "Vaccine added successfully!";
    } else {
        $error = "Failed to add vaccine.";
    }
}

// Update Vaccine
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_vaccine'])) {
    $vaccine_id = sanitize($_POST['vaccine_id']);
    $quantity = intval($_POST['quantity']);
    $availability_status = sanitize($_POST['availability_status']);
    $query = "UPDATE vaccines SET quantity = ?, availability_status = ? WHERE vaccine_id = ? AND hospital_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$quantity, $availability_status, $vaccine_id, $hospitalId])) {
        $message = "Vaccine updated successfully!";
    } else {
        $error = "Update failed.";
    }
}

// Delete Vaccine
if (isset($_GET['delete'])) {
    $vaccine_id = sanitize($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM vaccines WHERE vaccine_id = ? AND hospital_id = ?");
    if ($stmt->execute([$vaccine_id, $hospitalId])) {
        $message = "Vaccine deleted.";
    } else {
        $error = "Cannot delete – it may have related records.";
    }
    header("Location: manage-vaccines.php");
    exit();
}

// Get hospital's vaccines
$stmt = $conn->prepare("SELECT * FROM vaccines WHERE hospital_id = ? ORDER BY created_at DESC");
$stmt->execute([$hospitalId]);
$vaccines = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Manage Vaccines";
include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4"><?php include 'sidebar.php'; ?></div>
        </div>
        <div class="col-md-9">
            <h2><i class="fas fa-syringe me-2"></i>Manage Vaccines</h2>
            <?php if ($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
            
            <!-- Add Vaccine Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Add New Vaccine</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Vaccine Name *</label><input type="text" name="name" class="form-control" required></div>
                            <div class="col-md-6 mb-3"><label>Manufacturer</label><input type="text" name="manufacturer" class="form-control"></div>
                            <div class="col-md-4 mb-3"><label>Type</label><select name="type" class="form-control"><option>Viral Vector</option><option>mRNA</option><option>Inactivated Virus</option><option>Protein Subunit</option></select></div>
                            <div class="col-md-4 mb-3"><label>Dosage Interval (days)</label><input type="number" name="dosage_interval" class="form-control" value="28"></div>
                            <div class="col-md-4 mb-3"><label>Total Doses</label><input type="number" name="total_doses" class="form-control" value="2"></div>
                            <div class="col-md-12 mb-3"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                            <div class="col-md-6 mb-3"><label>Initial Quantity</label><input type="number" name="quantity" class="form-control" value="0"></div>
                            <div class="col-md-6 mb-3"><label>&nbsp;</label><button type="submit" name="add_vaccine" class="btn btn-primary w-100">Add Vaccine</button></div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Existing Vaccines -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Your Vaccine Inventory</h5>
                </div>
                <div class="card-body">
                    <?php if (count($vaccines) > 0): ?>
                        <table class="table table-bordered">
                            <thead><tr><th>Name</th><th>Manufacturer</th><th>Type</th><th>Doses</th><th>Quantity</th><th>Status</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach ($vaccines as $v): ?>
                                <tr>
                                    <form method="POST">
                                        <input type="hidden" name="vaccine_id" value="<?php echo $v['vaccine_id']; ?>">
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
                    <?php else: ?>
                        <p class="text-muted">No vaccines added yet. Use the form above to add your first vaccine.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>