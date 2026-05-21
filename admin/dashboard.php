<?php
require_once '../config/config.php';
require_once '../config/database.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/admin-login.php");
    exit();
}

$database = Database::getInstance();
$conn = $database->getConnection();

// Function to safely get count
function safeCount($conn, $table, $condition = '') {
    try {
        $query = "SELECT COUNT(*) as total FROM $table $condition";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Get statistics with error handling
$patients = safeCount($conn, 'patients');
$hospitals = safeCount($conn, 'hospitals');
$pending = safeCount($conn, 'hospitals', "WHERE approval_status = 'pending'");
$appointments = safeCount($conn, 'appointments');
$positive = safeCount($conn, 'covid_tests', "WHERE result_status = 'positive'");
$vaccinated = safeCount($conn, 'vaccinations', "WHERE status = 'completed'");

$pageTitle = "Admin Dashboard";
?>
<?php include '../includes/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-4x mb-3 text-primary"></i>
                    <h5><?php echo htmlspecialchars($_SESSION['name']); ?></h5>
                    <p class="text-muted">Administrator</p>
                    <span class="badge bg-primary">Admin Panel</span>
                </div>
                <div class="list-group list-group-flush">
                    <a href="dashboard.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="hospitals.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-hospital me-2"></i>Manage Hospitals
                    </a>
                    <a href="patients.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>Manage Patients
                    </a>
                    <a href="approve-hospitals.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-check-circle me-2"></i>Pending Approvals
                        <?php if ($pending > 0): ?>
                            <span class="badge bg-danger float-end"><?php echo $pending; ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="vaccines.php" class="list-group-item list-group-item-action">
    <i class="fas fa-syringe me-2"></i>Vaccine mangment (All)
</a>
                    <a href="reports.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-line me-2"></i>Reports
                    </a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9 col-lg-10">
            <div class="welcome-banner bg-primary text-white p-4 rounded mb-4">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                <p class="mb-0">Here's an overview of your healthcare system.</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Total Patients</h6>
                                    <h2 class="mb-0"><?php echo number_format($patients); ?></h2>
                                </div>
                                <i class="fas fa-users fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Total Hospitals</h6>
                                    <h2 class="mb-0"><?php echo number_format($hospitals); ?></h2>
                                </div>
                                <i class="fas fa-hospital fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Pending Approvals</h6>
                                    <h2 class="mb-0"><?php echo number_format($pending); ?></h2>
                                </div>
                                <i class="fas fa-clock fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Appointments</h6>
                                    <h2 class="mb-0"><?php echo number_format($appointments); ?></h2>
                                </div>
                                <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Positive Cases</h6>
                                    <h2 class="mb-0"><?php echo number_format($positive); ?></h2>
                                </div>
                                <i class="fas fa-virus fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Vaccinated</h6>
                                    <h2 class="mb-0"><?php echo number_format($vaccinated); ?></h2>
                                </div>
                                <i class="fas fa-syringe fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="approve-hospitals.php" class="btn btn-outline-primary">
                                    <i class="fas fa-check-circle me-2"></i>Approve Pending Hospitals
                                </a>
                                <a href="hospitals.php" class="btn btn-outline-success">
                                    <i class="fas fa-hospital me-2"></i>Manage Hospitals
                                </a>
                                <a href="patients.php" class="btn btn-outline-info">
                                    <i class="fas fa-users me-2"></i>View All Patients
                                </a>
                                <a href="reports.php" class="btn btn-outline-warning">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>System Info</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th>System Name:</th>
                                    <td><?php echo SITE_NAME; ?></td>
                                </tr>
                                <tr>
                                    <th>PHP Version:</th>
                                    <td><?php echo phpversion(); ?></td>
                                </tr>
                                <tr>
                                    <th>Server Time:</th>
                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                </tr>
                                <tr>
                                    <th>Logged in as:</th>
                                    <td><?php echo htmlspecialchars($_SESSION['name']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #1977cc 0%, #2c4964 100%);
    }
    .opacity-50 {
        opacity: 0.5;
    }
</style>

<?php include '../includes/footer.php'; ?>