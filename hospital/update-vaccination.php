<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);
$hospitalId = $_SESSION['user_id'];
$database = Database::getInstance();
$conn = $database->getConnection();
$msg = '';

// Get all scheduled vaccinations for this hospital
$vaccinations = $conn->prepare("SELECT v.*, p.name as patient_name, vac.name as vaccine_name FROM vaccinations v JOIN patients p ON v.patient_id=p.patient_id JOIN vaccines vac ON v.vaccine_id=vac.vaccine_id WHERE v.hospital_id=? AND v.status='scheduled' ORDER BY v.request_date DESC");
$vaccinations->execute([$hospitalId]);
$list = $vaccinations->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_vaccination'])) {
    $vacId = sanitize($_POST['vaccination_id']);
    $vaccination_date = sanitize($_POST['vaccination_date']);
    $status = sanitize($_POST['status']);
    $remarks = sanitize($_POST['remarks']);
    $update = $conn->prepare("UPDATE vaccinations SET vaccination_date=?, status=?, remarks=? WHERE vaccination_id=? AND hospital_id=?");
    if ($update->execute([$vaccination_date, $status, $remarks, $vacId, $hospitalId])) {
        $msg = "Vaccination status updated!";
    } else {
        $msg = "Update failed.";
    }
}

$pageTitle = "Update Vaccination";
include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        <div class="col-md-9">
            <h2>Update Vaccination Status</h2>
            <?php if($msg): ?><div class="alert alert-info"><?php echo $msg; ?></div><?php endif; ?>
            <?php if(count($list)>0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr><th>Vaccination ID</th><th>Patient</th><th>Vaccine</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach($list as $v): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="vaccination_id" value="<?php echo $v['vaccination_id']; ?>">
                                <td><?php echo $v['vaccination_id']; ?></td>
                                <td><?php echo htmlspecialchars($v['patient_name']); ?></td>
                                <td><?php echo $v['vaccine_name']; ?></td>
                                <td>
                                    <select name="status" class="form-control">
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="missed">Missed</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="date" name="vaccination_date" class="form-control mb-2" required>
                                    <textarea name="remarks" class="form-control mb-2" placeholder="Remarks"></textarea>
                                    <button type="submit" name="update_vaccination" class="btn btn-sm btn-primary">Update</button>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">No pending vaccinations.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>