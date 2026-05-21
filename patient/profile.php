<?php
require_once '../config/config.php';
require_once '../config/database.php';
checkRole(['patient']);

$database = Database::getInstance();
$conn = $database->getConnection();
$patientId = $_SESSION['user_id'];
$message = '';
$error = '';

// Get patient data
$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$patientId]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $city = sanitize($_POST['city']);
    $dob = sanitize($_POST['dob']);
    $gender = sanitize($_POST['gender']);
    $blood_group = sanitize($_POST['blood_group']);
    
    $query = "UPDATE patients SET name = ?, email = ?, phone = ?, address = ?, city = ?, date_of_birth = ?, gender = ?, blood_group = ? WHERE patient_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute([$name, $email, $phone, $address, $city, $dob, $gender, $blood_group, $patientId])) {
        $message = "Profile updated successfully!";
        $_SESSION['name'] = $name;
        // Refresh data
        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
        $stmt->execute([$patientId]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Failed to update profile.";
    }
}

$pageTitle = "My Profile";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-4x mb-3 text-primary"></i>
                    <h5>Patient Panel</h5>
                </div>
                <div class="list-group list-group-flush">
    <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
    <a href="request-test.php" class="list-group-item list-group-item-action">Request COVID Test</a>
    <a href="request-vaccination.php" class="list-group-item list-group-item-action">Request Vaccination</a>
    <a href="my-appointments.php" class="list-group-item list-group-item-action">My Appointments</a>
    <a href="test-results.php" class="list-group-item list-group-item-action">Test Results</a>
    <a href="vaccination-status.php" class="list-group-item list-group-item-action">Vaccination Status</a>
    <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
</div>
            </div>
        </div>
        <div class="col-md-9">
            <h2>My Profile</h2>
            
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
                                <label>Patient ID</label>
                                <input type="text" class="form-control" value="<?php echo $patient['patient_id']; ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Registration Date</label>
                                <input type="text" class="form-control" value="<?php echo formatDate($patient['registration_date']); ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Full Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $patient['email']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo $patient['phone']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="<?php echo $patient['date_of_birth']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">Select</option>
                                    <option value="male" <?php echo $patient['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo $patient['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo $patient['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Blood Group</label>
                                <select class="form-control" name="blood_group">
                                    <option value="">Select</option>
                                    <option value="A+" <?php echo $patient['blood_group'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                                    <option value="A-" <?php echo $patient['blood_group'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                                    <option value="B+" <?php echo $patient['blood_group'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                                    <option value="B-" <?php echo $patient['blood_group'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                                    <option value="O+" <?php echo $patient['blood_group'] == 'O+' ? 'selected' : ''; ?>>O+</option>
                                    <option value="O-" <?php echo $patient['blood_group'] == 'O-' ? 'selected' : ''; ?>>O-</option>
                                    <option value="AB+" <?php echo $patient['blood_group'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                                    <option value="AB-" <?php echo $patient['blood_group'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea class="form-control" name="address" rows="2"><?php echo htmlspecialchars($patient['address']); ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" value="<?php echo $patient['city']; ?>">
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