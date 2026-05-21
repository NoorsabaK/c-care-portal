<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);

$database = Database::getInstance();
$conn = $database->getConnection();
$hospitalId = $_SESSION['user_id'];

// Get hospital info
$stmt = $conn->prepare("SELECT * FROM hospitals WHERE hospital_id = ?");
$stmt->execute([$hospitalId]);
$hospital = $stmt->fetch(PDO::FETCH_ASSOC);

// Get statistics
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM requests WHERE hospital_id = ? AND status = 'pending'");
$stmt->execute([$hospitalId]);
$pendingRequests = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE hospital_id = ? AND appointment_date >= CURDATE()");
$stmt->execute([$hospitalId]);
$todayAppointments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM covid_tests WHERE hospital_id = ? AND result_status = 'pending'");
$stmt->execute([$hospitalId]);
$pendingTests = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM patients p JOIN requests r ON p.patient_id = r.patient_id WHERE r.hospital_id = ?");
$stmt->execute([$hospitalId]);
$totalPatients = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Recent appointments
$stmt = $conn->prepare("SELECT a.*, p.name as patient_name, p.phone as patient_phone 
                        FROM appointments a 
                        JOIN patients p ON a.patient_id = p.patient_id 
                        WHERE a.hospital_id = ? 
                        ORDER BY a.appointment_date DESC LIMIT 5");
$stmt->execute([$hospitalId]);
$recentAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Hospital Dashboard";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        <div class="col-md-9">
            <h2>Welcome, <?php echo htmlspecialchars($hospital['name']); ?>!</h2>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5>Pending Requests</h5>
                            <h2><?php echo $pendingRequests; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5>Today's Appointments</h5>
                            <h2><?php echo $todayAppointments; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5>Pending Tests</h5>
                            <h2><?php echo $pendingTests; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5>Total Patients</h5>
                            <h2><?php echo $totalPatients; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>Recent Appointments</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr><th>Patient</th><th>Phone</th><th>Date</th><th>Type</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentAppointments as $apt): ?>
                                <tr>
                                    <td><?php echo $apt['patient_name']; ?></td>
                                    <td><?php echo $apt['patient_phone']; ?></td>
                                    <td><?php echo formatDate($apt['appointment_date']); ?></td>
                                    <td><?php echo ucfirst($apt['appointment_type']); ?></td>
                                    <td><?php echo getStatusBadge($apt['status']); ?></td>
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