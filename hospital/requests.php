<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);

$database = Database::getInstance();
$conn = $database->getConnection();
$hospitalId = $_SESSION['user_id'];

// Handle request approval/rejection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $requestId = sanitize($_POST['request_id']);
    $action = $_POST['action'];
    $status = ($action == 'approve') ? 'approved' : 'rejected';
    
    $query = "UPDATE requests SET status = ?, processed_date = NOW() WHERE request_id = ? AND hospital_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$status, $requestId, $hospitalId])) {
        if ($action == 'approve') {
            // Create appointment
            $aptId = generateUniqueId('APT');
            $aptQuery = "INSERT INTO appointments (appointment_id, patient_id, hospital_id, appointment_type, appointment_date, appointment_time, status) 
                        SELECT ?, r.patient_id, r.hospital_id, r.request_type, CURDATE(), '10:00:00', 'confirmed' 
                        FROM requests r WHERE r.request_id = ?";
            $aptStmt = $conn->prepare($aptQuery);
            $aptStmt->execute([$aptId, $requestId]);
        }
        $_SESSION['success'] = "Request $status successfully!";
    }
    redirect('requests.php');
}

// Get all requests
$query = "SELECT r.*, p.name as patient_name, p.phone as patient_phone, p.email as patient_email 
          FROM requests r 
          JOIN patients p ON r.patient_id = p.patient_id 
          WHERE r.hospital_id = ? 
          ORDER BY r.request_date DESC";
$stmt = $conn->prepare($query);
$stmt->execute([$hospitalId]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Patient Requests";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        
        <div class="col-md-9">
            <h2>Patient Requests</h2>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="requestsTable">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td><?php echo $req['request_id']; ?></td>
                            <td><?php echo $req['patient_name']; ?></td>
                            <td><?php echo $req['patient_phone']; ?><br><small><?php echo $req['patient_email']; ?></small></td>
                            <td><?php echo ucfirst($req['request_type']); ?></td>
                            <td><?php echo formatDate($req['request_date']); ?></td>
                            <td><?php echo getStatusBadge($req['status']); ?></td>
                            <td>
                                <?php if ($req['status'] == 'pending'): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                                <?php else: ?>
                                <span class="text-muted">Processed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#requestsTable').DataTable();
});
</script>

<?php include '../includes/footer.php'; ?>