<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);
$patientId = $_SESSION['user_id'];
$database = Database::getInstance();
$conn = $database->getConnection();
$error = '';
$success = '';

// Get approved hospitals and available vaccines
$hospitals = $conn->query("SELECT hospital_id, name, city FROM hospitals WHERE approval_status='approved' ORDER BY name")->fetchAll();
$vaccines = $conn->query("SELECT vaccine_id, name FROM vaccines WHERE availability_status='available' AND quantity > 0 ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hospitalId = sanitize($_POST['hospital_id']);
    $vaccineId = sanitize($_POST['vaccine_id']);
    $remarks = sanitize($_POST['remarks']);
    
    $requestId = generateUniqueId('REQ');
    $query = "INSERT INTO requests (request_id, patient_id, hospital_id, request_type, hospital_remarks) VALUES (?, ?, ?, 'vaccination', ?)";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$requestId, $patientId, $hospitalId, $remarks])) {
        // Also create a placeholder vaccination record
        $vacId = generateUniqueId('VAC');
        $vacQuery = "INSERT INTO vaccinations (vaccination_id, patient_id, hospital_id, vaccine_id, status) VALUES (?, ?, ?, ?, 'scheduled')";
        $vacStmt = $conn->prepare($vacQuery);
        $vacStmt->execute([$vacId, $patientId, $hospitalId, $vaccineId]);
        $success = "Vaccination request submitted! Hospital will confirm your appointment.";
    } else {
        $error = "Failed to submit request.";
    }
}

$pageTitle = "Request Vaccination";
include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white"><h4>Request Vaccination</h4></div>
                <div class="card-body">
                    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
                    <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
                    <form method="POST">
                        <div class="mb-3"><label>Select Hospital</label><select name="hospital_id" class="form-control" required><?php foreach($hospitals as $h): ?><option value="<?php echo $h['hospital_id']; ?>"><?php echo htmlspecialchars($h['name']." - ".$h['city']); ?></option><?php endforeach; ?></select></div>
                        <div class="mb-3"><label>Select Vaccine</label><select name="vaccine_id" class="form-control" required><?php foreach($vaccines as $v): ?><option value="<?php echo $v['vaccine_id']; ?>"><?php echo htmlspecialchars($v['name']); ?></option><?php endforeach; ?></select></div>
                        <div class="mb-3"><label>Additional Remarks</label><textarea name="remarks" class="form-control" rows="3"></textarea></div>
                        <button type="submit" class="btn btn-success">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>