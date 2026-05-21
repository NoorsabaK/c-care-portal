<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);

$database = Database::getInstance();
$conn = $database->getConnection();
$patientId = $_SESSION['user_id'];

// Cancel appointment
if (isset($_GET['cancel']) && isset($_GET['id'])) {
    $aptId = sanitize($_GET['id']);
    $query = "UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ? AND patient_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$aptId, $patientId])) {
        $_SESSION['success'] = "Appointment cancelled successfully!";
    }
    redirect('my-appointments.php');
}

// Get appointments
$query = "SELECT a.*, h.name as hospital_name, h.address, h.city, h.phone as hospital_phone 
          FROM appointments a 
          JOIN hospitals h ON a.hospital_id = h.hospital_id 
          WHERE a.patient_id = ? 
          ORDER BY a.appointment_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$patientId]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "My Appointments";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x mb-3 text-primary"></i>
                    <h5>Patient Panel</h5>
                </div>
                <div class="list-group list-group-flush">
    <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
    <a href="request-test.php" class="list-group-item list-group-item-action">Request COVID Test</a>
    <a href="request-vaccination.php" class="list-group-item list-group-item-action">Request Vaccination</a>
    <a href="my-appointments.php" class="list-group-item list-group-item-action">My Appointments</a>
    <a href="test-results.php" class="list-group-item list-group-item-action">Test Results</a>
    <a href="vaccination-status.php" class="list-group-item list-group-item-action">Vaccination Status</a>
    <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
</div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>My Appointments</h2>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if (count($appointments) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Hospital</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $apt): ?>
                            <tr>
                                <td><?php echo $apt['appointment_id']; ?></td>
                                <td><?php echo htmlspecialchars($apt['hospital_name']); ?></td>
                                <td><?php echo $apt['city']; ?><br><small><?php echo $apt['address']; ?></small></td>
                                <td><?php echo formatDate($apt['appointment_date']); ?></td>
                                <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                <td><?php echo ucfirst($apt['appointment_type']); ?></td>
                                <td><?php echo getStatusBadge($apt['status']); ?></td>
                                <td>
                                    <?php if ($apt['status'] == 'pending' || $apt['status'] == 'confirmed'): ?>
                                        <a href="?cancel=1&id=<?php echo $apt['appointment_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this appointment?')">Cancel</a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No appointments found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>