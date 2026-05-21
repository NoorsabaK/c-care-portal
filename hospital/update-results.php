<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);

$database = Database::getInstance();
$conn = $database->getConnection();
$hospitalId = $_SESSION['user_id'];
$message = '';
$error = '';

// Update test result
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_test'])) {
    $testId = sanitize($_POST['test_id']);
    $result = sanitize($_POST['result']);
    $remarks = sanitize($_POST['remarks']);
    
    $query = "UPDATE covid_tests SET result_status = ?, result_details = ?, test_date = CURDATE() WHERE test_id = ? AND hospital_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$result, $remarks, $testId, $hospitalId])) {
        $message = "Test result updated successfully!";
    } else {
        $error = "Failed to update test result.";
    }
}

// Update vaccination status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_vaccination'])) {
    $vaccinationId = sanitize($_POST['vaccination_id']);
    $status = sanitize($_POST['status']);
    $vaccinationDate = sanitize($_POST['vaccination_date']);
    
    $query = "UPDATE vaccinations SET status = ?, vaccination_date = ? WHERE vaccination_id = ? AND hospital_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$status, $vaccinationDate, $vaccinationId, $hospitalId])) {
        $message = "Vaccination status updated successfully!";
    } else {
        $error = "Failed to update vaccination status.";
    }
}

// Get pending tests
$query = "SELECT ct.*, p.name as patient_name, p.phone as patient_phone 
          FROM covid_tests ct 
          JOIN patients p ON ct.patient_id = p.patient_id 
          WHERE ct.hospital_id = ? AND ct.result_status = 'pending' 
          ORDER BY ct.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$hospitalId]);
$pendingTests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get pending vaccinations
$query = "SELECT v.*, p.name as patient_name, p.phone as patient_phone, vac.name as vaccine_name 
          FROM vaccinations v 
          JOIN patients p ON v.patient_id = p.patient_id 
          JOIN vaccines vac ON v.vaccine_id = vac.vaccine_id 
          WHERE v.hospital_id = ? AND v.status = 'scheduled' 
          ORDER BY v.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$hospitalId]);
$pendingVaccinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Update Results";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        <div class="col-md-9">
            <h2>Update Test Results & Vaccination Status</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Pending Tests -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Pending COVID-19 Tests</h5>
                </div>
                <div class="card-body">
                    <?php if (count($pendingTests) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>Test ID</th><th>Patient</th><th>Phone</th><th>Request Date</th><th>Action</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingTests as $test): ?>
                                    <tr>
                                        <form method="POST">
                                            <input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
                                            <td><?php echo $test['test_id']; ?></td>
                                            <td><?php echo $test['patient_name']; ?></td>
                                            <td><?php echo $test['patient_phone']; ?></td>
                                            <td><?php echo formatDate($test['request_date']); ?></td>
                                            <td>
                                                <select name="result" class="form-control mb-2" required>
                                                    <option value="">Select Result</option>
                                                    <option value="negative">Negative</option>
                                                    <option value="positive">Positive</option>
                                                    <option value="inconclusive">Inconclusive</option>
                                                </select>
                                                <textarea name="remarks" class="form-control mb-2" placeholder="Remarks" rows="2"></textarea>
                                                <button type="submit" name="update_test" class="btn btn-primary btn-sm">Update Result</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No pending tests.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Pending Vaccinations -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Pending Vaccinations</h5>
                </div>
                <div class="card-body">
                    <?php if (count($pendingVaccinations) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>Vaccination ID</th><th>Patient</th><th>Phone</th><th>Vaccine</th><th>Request Date</th><th>Action</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingVaccinations as $vacc): ?>
                                    <tr>
                                        <form method="POST">
                                            <input type="hidden" name="vaccination_id" value="<?php echo $vacc['vaccination_id']; ?>">
                                            <td><?php echo $vacc['vaccination_id']; ?></td>
                                            <td><?php echo $vacc['patient_name']; ?></td>
                                            <td><?php echo $vacc['patient_phone']; ?></td>
                                            <td><?php echo $vacc['vaccine_name']; ?></td>
                                            <td><?php echo formatDate($vacc['request_date']); ?></td>
                                            <td>
                                                <select name="status" class="form-control mb-2" required>
                                                    <option value="">Select Status</option>
                                                    <option value="completed">Completed</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="missed">Missed</option>
                                                </select>
                                                <input type="date" name="vaccination_date" class="form-control mb-2">
                                                <button type="submit" name="update_vaccination" class="btn btn-primary btn-sm">Update Status</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No pending vaccinations.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>