<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);
$hospitalId = $_SESSION['user_id'];
$database = Database::getInstance();
$conn = $database->getConnection();
$message = '';

// Approve Request
if (isset($_GET['approve'])) {
    $reqId = sanitize($_GET['approve']);
    $conn->beginTransaction();
    try {
        // Update request status
        $upd = $conn->prepare("UPDATE requests SET status='approved', processed_date=NOW(), processed_by=? WHERE request_id=? AND hospital_id=?");
        $upd->execute([$hospitalId, $reqId, $hospitalId]);
        // Get request details
        $req = $conn->prepare("SELECT patient_id, request_type FROM requests WHERE request_id=?");
        $req->execute([$reqId]);
        $r = $req->fetch();
        // Create appointment
        $aptId = generateUniqueId('APT');
        $aptDate = date('Y-m-d', strtotime('+2 days'));
        $aptTime = '10:00:00';
        $aptStmt = $conn->prepare("INSERT INTO appointments (appointment_id, patient_id, hospital_id, appointment_type, appointment_date, appointment_time, status) VALUES (?,?,?,?,?,?,'confirmed')");
        $aptStmt->execute([$aptId, $r['patient_id'], $hospitalId, $r['request_type'], $aptDate, $aptTime]);
        
        $conn->commit();
        $message = "Request approved. Appointment created for $aptDate at $aptTime.";
    } catch (Exception $e) {
        $conn->rollBack();
        $message = "Error approving request.";
    }
    header("Location: manage-requests.php?msg=".urlencode($message));
    exit();
}

// Reject Request
if (isset($_GET['reject'])) {
    $reqId = sanitize($_GET['reject']);
    $upd = $conn->prepare("UPDATE requests SET status='rejected', processed_date=NOW(), processed_by=? WHERE request_id=? AND hospital_id=?");
    $upd->execute([$hospitalId, $reqId, $hospitalId]);
    $message = "Request rejected.";
    header("Location: manage-requests.php?msg=".urlencode($message));
    exit();
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$pendingRequests = $conn->prepare("SELECT r.*, p.name as patient_name, p.phone, p.email FROM requests r JOIN patients p ON r.patient_id=p.patient_id WHERE r.hospital_id=? AND r.status='pending' ORDER BY r.request_date DESC");
$pendingRequests->execute([$hospitalId]);
$pending = $pendingRequests->fetchAll();

$pageTitle = "Manage Requests";
include '../includes/header.php';
?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><div class="card mb-4"><?php include 'sidebar.php'; ?></div></div>
        <div class="col-md-9">
            <h2>Patient Requests</h2>
            <?php if($msg): ?><div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
            <?php if(count($pending)>0): ?>
            <table class="table table-bordered">
                <thead><tr><th>Request ID</th><th>Patient</th><th>Type</th><th>Date</th><th>Remarks</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach($pending as $req): ?>
                <tr>
                    <td><?php echo $req['request_id']; ?></td>
                    <td><?php echo htmlspecialchars($req['patient_name']); ?><br><small><?php echo $req['phone']; ?></small></td>
                    <td><?php echo ucfirst($req['request_type']); ?></td>
                    <td><?php echo formatDate($req['request_date']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($req['hospital_remarks'])); ?></td>
                    <td>
                        <a href="?approve=<?php echo $req['request_id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Approve this request?')">Approve</a>
                        <a href="?reject=<?php echo $req['request_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Reject this request?')">Reject</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-warning">No pending requests.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>