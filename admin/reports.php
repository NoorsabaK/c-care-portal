<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['admin']);

$database = Database::getInstance();
$conn = $database->getConnection();
$reportData = [];
$reportTitle = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_report'])) {
    $type = $_POST['report_type'];
    $date = $_POST['date'];
    
    if ($type == 'daily') {
        $query = "SELECT a.*, p.name as patient_name, h.name as hospital_name 
                  FROM appointments a 
                  JOIN patients p ON a.patient_id = p.patient_id 
                  JOIN hospitals h ON a.hospital_id = h.hospital_id 
                  WHERE DATE(a.appointment_date) = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$date]);
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reportTitle = "Daily Report - " . formatDate($date);
    } elseif ($type == 'weekly') {
        $weekStart = date('Y-m-d', strtotime($date));
        $weekEnd = date('Y-m-d', strtotime($date . ' +6 days'));
        $query = "SELECT a.*, p.name as patient_name, h.name as hospital_name 
                  FROM appointments a 
                  JOIN patients p ON a.patient_id = p.patient_id 
                  JOIN hospitals h ON a.hospital_id = h.hospital_id 
                  WHERE DATE(a.appointment_date) BETWEEN ? AND ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$weekStart, $weekEnd]);
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reportTitle = "Weekly Report - $weekStart to $weekEnd";
    } elseif ($type == 'monthly') {
        $monthStart = date('Y-m-01', strtotime($date));
        $monthEnd = date('Y-m-t', strtotime($date));
        $query = "SELECT a.*, p.name as patient_name, h.name as hospital_name 
                  FROM appointments a 
                  JOIN patients p ON a.patient_id = p.patient_id 
                  JOIN hospitals h ON a.hospital_id = h.hospital_id 
                  WHERE DATE(a.appointment_date) BETWEEN ? AND ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$monthStart, $monthEnd]);
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reportTitle = "Monthly Report - " . date('F Y', strtotime($date));
    }
    
    // HTML export (no Excel library needed)
    if (isset($_POST['export_html']) && !empty($reportData)) {
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename="report_'.date('Ymd_His').'.html"');
        echo "<html><head><title>$reportTitle</title>";
        echo "<style>table{border-collapse:collapse;width:100%}th,td{border:1px solid #ddd;padding:8px}th{background:#1977cc;color:#fff}</style>";
        echo "</head><body><h2>$reportTitle</h2>";
        echo "<table><thead><tr><th>Appointment ID</th><th>Patient</th><th>Hospital</th><th>Date</th><th>Time</th><th>Type</th><th>Status</th></tr></thead><tbody>";
        foreach ($reportData as $row) {
            echo "<tr>";
            echo "<td>{$row['appointment_id']}</td>";
            echo "<td>{$row['patient_name']}</td>";
            echo "<td>{$row['hospital_name']}</td>";
            echo "<td>".formatDate($row['appointment_date'])."</td>";
            echo "<td>{$row['appointment_time']}</td>";
            echo "<td>".ucfirst($row['appointment_type'])."</td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table></body></html>";
        exit();
    }
}

$pageTitle = "Reports";
include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-4x mb-3 text-primary"></i>
                    <h5>Admin Panel</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="hospitals.php" class="list-group-item list-group-item-action">Manage Hospitals</a>
                    <a href="patients.php" class="list-group-item list-group-item-action">Manage Patients</a>
                    <a href="approve-hospitals.php" class="list-group-item list-group-item-action">Pending Approvals</a>
                    <a href="vaccines.php" class="list-group-item list-group-item-action">Vaccine Management</a>
                    <a href="reports.php" class="list-group-item list-group-item-action active">Reports</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>Generate Reports</h2>
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Report Type</label>
                                <select name="report_type" class="form-control" required>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" name="generate_report" class="btn btn-primary w-100">Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if (!empty($reportData)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo $reportTitle; ?></h5>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="report_type" value="<?php echo $_POST['report_type']; ?>">
                            <input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
                            <input type="hidden" name="generate_report" value="1">
                            <button type="submit" name="export_html" class="btn btn-success btn-sm">Export as HTML</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead><tr><th>Appointment ID</th><th>Patient</th><th>Hospital</th><th>Date</th><th>Time</th><th>Type</th><th>Status</th></tr></thead>
                                <tbody>
                                    <?php foreach ($reportData as $row): ?>
                                    <tr>
                                        <td><?php echo $row['appointment_id']; ?></td>
                                        <td><?php echo $row['patient_name']; ?></td>
                                        <td><?php echo $row['hospital_name']; ?></td>
                                        <td><?php echo formatDate($row['appointment_date']); ?></td>
                                        <td><?php echo $row['appointment_time']; ?></td>
                                        <td><?php echo ucfirst($row['appointment_type']); ?></td>
                                        <td><?php echo getStatusBadge($row['status']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>