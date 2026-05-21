<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);

$database = Database::getInstance();
$conn = $database->getConnection();
$patientId = $_SESSION['user_id'];

// Get test results
$query = "SELECT ct.*, h.name as hospital_name 
          FROM covid_tests ct 
          JOIN hospitals h ON ct.hospital_id = h.hospital_id 
          WHERE ct.patient_id = ? 
          ORDER BY ct.test_date DESC, ct.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$patientId]);
$testResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get vaccination results
$query = "SELECT v.*, h.name as hospital_name, vac.name as vaccine_name 
          FROM vaccinations v 
          JOIN hospitals h ON v.hospital_id = h.hospital_id 
          JOIN vaccines vac ON v.vaccine_id = vac.vaccine_id 
          WHERE v.patient_id = ? 
          ORDER BY v.vaccination_date DESC, v.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$patientId]);
$vaccinationResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Test Results";
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
            <h2>My Test Results</h2>
            
            <!-- COVID-19 Test Results -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">COVID-19 Test Results</h5>
                </div>
                <div class="card-body">
                    <?php if (count($testResults) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Test ID</th>
                                        <th>Hospital</th>
                                        <th>Test Type</th>
                                        <th>Test Date</th>
                                        <th>Result</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($testResults as $test): ?>
                                    <tr>
                                        <td><?php echo $test['test_id']; ?></td>
                                        <td><?php echo htmlspecialchars($test['hospital_name']); ?></td>
                                        <td><?php echo $test['test_type']; ?></td>
                                        <td><?php echo formatDate($test['test_date']); ?></td>
                                        <td><?php echo getStatusBadge($test['result_status']); ?></td>
                                        <td><?php echo nl2br($test['result_details']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No test results available yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Vaccination Results -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Vaccination Status</h5>
                </div>
                <div class="card-body">
                    <?php if (count($vaccinationResults) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Vaccination ID</th>
                                        <th>Hospital</th>
                                        <th>Vaccine</th>
                                        <th>Dose</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vaccinationResults as $vacc): ?>
                                    <tr>
                                        <td><?php echo $vacc['vaccination_id']; ?></td>
                                        <td><?php echo htmlspecialchars($vacc['hospital_name']); ?></td>
                                        <td><?php echo $vacc['vaccine_name']; ?></td>
                                        <td><?php echo $vacc['dose_number']; ?>/<?php echo ($vacc['dose_number'] == 1 ? '2' : '2'); ?></td>
                                        <td><?php echo formatDate($vacc['vaccination_date']); ?></td>
                                        <td><?php echo getStatusBadge($vacc['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No vaccination records available yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>