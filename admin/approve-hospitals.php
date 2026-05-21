<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['admin']);

$database = Database::getInstance();
$conn = $database->getConnection();

// Handle approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $hospital_id = sanitize($_POST['hospital_id']);
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $query = "UPDATE hospitals SET approval_status = 'approved' WHERE hospital_id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$hospital_id])) {
            $_SESSION['success'] = "Hospital approved successfully!";
        }
    } elseif ($action == 'reject') {
        $query = "UPDATE hospitals SET approval_status = 'rejected' WHERE hospital_id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt->execute([$hospital_id])) {
            $_SESSION['success'] = "Hospital rejected!";
        }
    }
    redirect('approve-hospitals.php');
}

// Get pending hospitals
$query = "SELECT * FROM hospitals WHERE approval_status = 'pending' ORDER BY registration_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$pendingHospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Approve Hospitals";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-4x mb-3 text-primary"></i>
                    <h5>Admin Panel</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="hospitals.php" class="list-group-item list-group-item-action">Manage Hospitals</a>
                    <a href="patients.php" class="list-group-item list-group-item-action">Manage Patients</a>
                    <a href="approve-hospitals.php" class="list-group-item list-group-item-action active">Pending Approvals</a>
                    <a href="vaccines.php" class="list-group-item list-group-item-action">Vaccine Management</a>
                    <a href="reports.php" class="list-group-item list-group-item-action">Reports</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>Pending Hospital Approvals</h2>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if (count($pendingHospitals) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hospital Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingHospitals as $hospital): ?>
                            <tr>
                                <td><?php echo $hospital['hospital_id']; ?></td>
                                <td><?php echo htmlspecialchars($hospital['name']); ?></td>
                                <td><?php echo $hospital['email']; ?></td>
                                <td><?php echo $hospital['phone']; ?></td>
                                <td><?php echo $hospital['city']; ?></td>
                                <td><?php echo formatDate($hospital['registration_date']); ?></td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="hospital_id" value="<?php echo $hospital['hospital_id']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm" onclick="return confirm('Approve this hospital?')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm" onclick="return confirm('Reject this hospital?')">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No pending hospital approvals.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>