<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['hospital']);

$database = Database::getInstance();
$conn = $database->getConnection();
$hospitalId = $_SESSION['user_id'];
$message = '';
$error = '';

// Get hospital data
$stmt = $conn->prepare("SELECT * FROM hospitals WHERE hospital_id = ?");
$stmt->execute([$hospitalId]);
$hospital = $stmt->fetch(PDO::FETCH_ASSOC);

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $city = sanitize($_POST['city']);
    $state = sanitize($_POST['state']);
    $zip = sanitize($_POST['zip']);
    
    $query = "UPDATE hospitals SET name = ?, email = ?, phone = ?, address = ?, city = ?, state = ?, zip_code = ? WHERE hospital_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute([$name, $email, $phone, $address, $city, $state, $zip, $hospitalId])) {
        $message = "Profile updated successfully!";
        $_SESSION['name'] = $name;
        // Refresh data
        $stmt = $conn->prepare("SELECT * FROM hospitals WHERE hospital_id = ?");
        $stmt->execute([$hospitalId]);
        $hospital = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Failed to update profile.";
    }
}

$pageTitle = "Hospital Profile";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
        <div class="col-md-9">
            <h2>Hospital Profile</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Hospital ID</label>
                                <input type="text" class="form-control" value="<?php echo $hospital['hospital_id']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <input type="text" class="form-control" value="<?php echo ucfirst($hospital['approval_status']); ?>" disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Hospital Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($hospital['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $hospital['email']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo $hospital['phone']; ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Address *</label>
                                <textarea class="form-control" name="address" rows="2" required><?php echo htmlspecialchars($hospital['address']); ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>City *</label>
                                <input type="text" class="form-control" name="city" value="<?php echo $hospital['city']; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>State *</label>
                                <input type="text" class="form-control" name="state" value="<?php echo $hospital['state']; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Zip Code *</label>
                                <input type="text" class="form-control" name="zip" value="<?php echo $hospital['zip_code']; ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>