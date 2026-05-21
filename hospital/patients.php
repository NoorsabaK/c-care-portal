<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);

$database = Database::getInstance();
$conn = $database->getConnection();
$hospitalId = $_SESSION['user_id'];

// Get all patients for this hospital
$query = "SELECT DISTINCT p.*, r.request_type, r.status as request_status, r.request_date 
          FROM patients p 
          JOIN requests r ON p.patient_id = r.patient_id 
          WHERE r.hospital_id = ? 
          ORDER BY r.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$hospitalId]);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "My Patients";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        <div class="col-md-9">
            <h2>My Patients</h2>
            <div class="table-responsive">
                <table class="table table-bordered" id="patientsTable">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Request Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo $patient['patient_id']; ?></td>
                            <td><?php echo htmlspecialchars($patient['name']); ?></td>
                            <td><?php echo $patient['email']; ?></td>
                            <td><?php echo $patient['phone']; ?></td>
                            <td><?php echo $patient['city']; ?></td>
                            <td><?php echo ucfirst($patient['request_type']); ?></td>
                            <td><?php echo getStatusBadge($patient['request_status']); ?></td>
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
    $('#patientsTable').DataTable();
});
</script>

<?php include '../includes/footer.php'; ?>