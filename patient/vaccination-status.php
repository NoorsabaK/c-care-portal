<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);
$patientId = $_SESSION['user_id'];

$database = Database::getInstance();
$conn = $database->getConnection();

// Fetch vaccination records for this patient
$query = "SELECT v.*, h.name as hospital_name, vac.name as vaccine_name 
          FROM vaccinations v 
          JOIN hospitals h ON v.hospital_id = h.hospital_id 
          LEFT JOIN vaccines vac ON v.vaccine_id = vac.vaccine_id 
          WHERE v.patient_id = ? 
          ORDER BY v.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$patientId]);
$vaccinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Vaccination Status";
include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x mb-3 text-primary"></i>
                    <h5>Patient Panel</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="request-test.php" class="list-group-item list-group-item-action">Request COVID Test</a>
                    <a href="request-vaccination.php" class="list-group-item list-group-item-action">Request Vaccination</a>
                    <a href="my-appointments.php" class="list-group-item list-group-item-action">My Appointments</a>
                    <a href="test-results.php" class="list-group-item list-group-item-action">Test Results</a>
                    <a href="vaccination-status.php" class="list-group-item list-group-item-action active">Vaccination Status</a>
                    <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2><i class="fas fa-syringe me-2"></i>My Vaccination Status</h2>
            
            <?php if (count($vaccinations) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Vaccination ID</th>
                                <th>Hospital</th>
                                <th>Vaccine</th>
                                <th>Dose #</th>
                                <th>Request Date</th>
                                <th>Vaccination Date</th>
                                <th>Status</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vaccinations as $vac): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($vac['vaccination_id']); ?></td>
                                <td><?php echo htmlspecialchars($vac['hospital_name']); ?></td>
                                <td><?php echo htmlspecialchars($vac['vaccine_name'] ?? 'N/A'); ?></td>
                                <td><?php echo $vac['dose_number']; ?> / <?php echo ($vac['dose_number'] == 1 ? '2' : '2'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($vac['request_date'])); ?></td>
                                <td><?php echo $vac['vaccination_date'] ? date('M d, Y', strtotime($vac['vaccination_date'])) : 'Not scheduled'; ?></td>
                                <td>
                                    <?php 
                                    $badge = '';
                                    switch($vac['status']) {
                                        case 'completed': $badge = 'success'; break;
                                        case 'scheduled': $badge = 'info'; break;
                                        case 'cancelled': $badge = 'danger'; break;
                                        case 'missed': $badge = 'warning'; break;
                                        default: $badge = 'secondary';
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $badge; ?>"><?php echo ucfirst($vac['status']); ?></span>
                                </td>
                                <td><?php echo nl2br(htmlspecialchars($vac['remarks'] ?? '')); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    You haven't requested any vaccination yet. 
                    <a href="request-vaccination.php" class="alert-link">Request your first vaccination now</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>