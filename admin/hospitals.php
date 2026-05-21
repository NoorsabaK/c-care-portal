<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['admin']);

$database = Database::getInstance();
$conn = $database->getConnection();

// Get all hospitals
$query = "SELECT * FROM hospitals ORDER BY registration_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$hospitals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Manage Hospitals";
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
                    <a href="hospitals.php" class="list-group-item list-group-item-action active">Manage Hospitals</a>
                    <a href="patients.php" class="list-group-item list-group-item-action">Manage Patients</a>
                    <a href="approve-hospitals.php" class="list-group-item list-group-item-action">Pending Approvals</a>
                    <a href="vaccines.php" class="list-group-item list-group-item-action">Vaccine Management</a>
                    <a href="reports.php" class="list-group-item list-group-item-action">Reports</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>All Hospitals</h2>
            <div class="table-responsive">
                <table class="table table-bordered" id="hospitalsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hospitals as $hospital): ?>
                        <tr>
                            <td><?php echo $hospital['hospital_id']; ?></td>
                            <td><?php echo htmlspecialchars($hospital['name']); ?></td>
                            <td><?php echo $hospital['email']; ?></td>
                            <td><?php echo $hospital['phone']; ?></td>
                            <td><?php echo $hospital['city']; ?></td>
                            <td><?php echo getStatusBadge($hospital['approval_status']); ?></td>
                            <td><?php echo formatDate($hospital['registration_date']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#hospitalsTable').DataTable();
});
</script>

<?php include '../includes/footer.php'; ?>