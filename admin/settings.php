<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['admin']);

$database = Database::getInstance();
$conn = $database->getConnection();
$message = '';
$error = '';

// Get admin info
$admin_id = $_SESSION['admin_id'] ?? 0;
$query = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    
    $query = "UPDATE admins SET full_name = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute([$full_name, $email, $phone, $admin_id])) {
        $_SESSION['name'] = $full_name;
        $message = "Profile updated successfully!";
        // Refresh data
        $stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([$admin_id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Failed to update profile!";
    }
}

// Change password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (!password_verify($current_password, $admin['password'])) {
        $error = "Current password is incorrect!";
    } elseif ($new_password != $confirm_password) {
        $error = "New passwords do not match!";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE admins SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute([$hashed, $admin_id])) {
            $message = "Password changed successfully!";
        } else {
            $error = "Failed to change password!";
        }
    }
}

$pageTitle = "Admin Settings";
?>
<?php include '../includes/header.php'; ?>

<style>
    .settings-card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .settings-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 15px 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 col-lg-2">
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
                    <a href="reports.php" class="list-group-item list-group-item-action">Reports</a>
                    <a href="settings.php" class="list-group-item list-group-item-action active">Settings</a>
                    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9 col-lg-10">
            <h2><i class="fas fa-cog me-2"></i>Admin Settings</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="row">
                <!-- Profile Settings -->
                <div class="col-md-6">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profile Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?php echo $admin['username']; ?>" disabled>
                                    <small class="text-muted">Username cannot be changed</small>
                                </div>
                                <div class="mb-3">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($admin['full_name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $admin['email']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control" name="phone" value="<?php echo $admin['phone']; ?>">
                                </div>
                                <button type="submit" name="update_profile" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Change Password -->
                <div class="col-md-6">
                    <div class="card settings-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label>Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>
                                <div class="mb-3">
                                    <label>Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" name="change_password" class="btn btn-warning">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>System Name:</th>
                                    <td><?php echo SITE_NAME; ?></td>
                                </tr>
                                <tr>
                                    <th>PHP Version:</th>
                                    <td><?php echo phpversion(); ?></td>
                                </tr>
                                <tr>
                                    <th>MySQL Version:</th>
                                    <td><?php echo $conn->getAttribute(PDO::ATTR_SERVER_VERSION); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Server Time:</th>
                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Login:</th>
                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                </tr>
                                <tr>
                                    <th>Admin Since:</th>
                                    <td><?php echo date('Y-m-d', strtotime($admin['created_at'])); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>