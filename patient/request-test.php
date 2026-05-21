<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);
$patientId = $_SESSION['user_id'];
$database = Database::getInstance();
$conn = $database->getConnection();
$error = '';
$success = '';

// Get approved hospitals
$hospitals = $conn->query("SELECT hospital_id, name, city FROM hospitals WHERE approval_status='approved' ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospitalId = sanitize($_POST['hospital_id']);
    $testType = sanitize($_POST['test_type']);
    $remarks = sanitize($_POST['remarks']);
    
    $requestId = generateUniqueId('REQ');
    $query = "INSERT INTO requests (request_id, patient_id, hospital_id, request_type, hospital_remarks) VALUES (?, ?, ?, 'test', ?)";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$requestId, $patientId, $hospitalId, $remarks])) {
        $success = "Test request submitted! Hospital will review and contact you.";
        // Optionally send SMS/email here
    } else {
        $error = "Failed to submit request.";
    }
}

$pageTitle = "Request COVID Test";
include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white"><h4>Request COVID-19 Test</h4></div>
                <div class="card-body">
                    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
                    <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
                    <form method="POST">
                        <div class="mb-3"><label>Select Hospital</label><select name="hospital_id" class="form-control" required><?php foreach($hospitals as $h): ?><option value="<?php echo $h['hospital_id']; ?>"><?php echo htmlspecialchars($h['name']." - ".$h['city']); ?></option><?php endforeach; ?></select></div>
                        <div class="mb-3"><label>Test Type</label><select name="test_type" class="form-control" required><option>PCR</option><option>Rapid Antigen</option><option>Antibody</option></select></div>
                        <div class="mb-3"><label>Additional Remarks</label><textarea name="remarks" class="form-control" rows="3"></textarea></div>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>