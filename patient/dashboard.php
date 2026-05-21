<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);

$database = Database::getInstance();
$conn = $database->getConnection();
$patientId = $_SESSION['user_id'];

// Get patient info
$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patientId]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

// Get stats
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE patient_id = ?");
$stmt->execute([$patientId]);
$appointments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE patient_id = ? AND appointment_date >= CURDATE() AND status IN ('pending', 'confirmed')");
$stmt->execute([$patientId]);
$upcoming = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM covid_tests WHERE patient_id = ? AND result_status != 'pending'");
$stmt->execute([$patientId]);
$tests = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM vaccinations WHERE patient_id = ? AND status = 'completed'");
$stmt->execute([$patientId]);
$vaccinated = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Recent appointments
$stmt = $conn->prepare("SELECT a.*, h.name as hospital_name FROM appointments a JOIN hospitals h ON a.hospital_id = h.hospital_id WHERE a.patient_id = ? ORDER BY a.appointment_date DESC LIMIT 5");
$stmt->execute([$patientId]);
$recent = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Patient Dashboard";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x mb-3 text-primary"></i>
                    <h5><?php echo htmlspecialchars($patient['name']); ?></h5>
                    <p class="text-muted">ID: <?php echo $patient['patient_id']; ?></p>
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
            <h2>Welcome, <?php echo htmlspecialchars($patient['name']); ?>!</h2>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5>Appointments</h5>
                            <h2><?php echo $appointments; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5>Upcoming</h5>
                            <h2><?php echo $upcoming; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5>Test Results</h5>
                            <h2><?php echo $tests; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5>Vaccinated</h5>
                            <h2><?php echo $vaccinated; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>Recent Appointments</h5>
                </div>
                <div class="card-body">
                    <?php if (count($recent) > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead><tr><th>Hospital</th><th>Date</th><th>Type</th><th>Status</th></tr></thead>
                                <tbody>
                                    <?php foreach ($recent as $apt): ?>
                                    <tr>
                                        <td><?php echo $apt['hospital_name']; ?></td>
                                        <td><?php echo formatDate($apt['appointment_date']); ?></td>
                                        <td><?php echo ucfirst($apt['appointment_type']); ?></td>
                                        <td><?php echo getStatusBadge($apt['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No appointments found.</p>
                        <a href="../appointment.php" class="btn btn-primary">Book Appointment</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>