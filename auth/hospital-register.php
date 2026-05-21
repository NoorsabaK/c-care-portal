<?php
require_once '../config/config.php';
require_once '../config/database.php';

$database = Database::getInstance();
$conn = $database->getConnection();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $address = sanitize($_POST['address']);
    $city = sanitize($_POST['city']);
    $state = sanitize($_POST['state']);
    $zip = sanitize($_POST['zip']);
    
    if ($password != $confirm) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        $check = $conn->prepare("SELECT id FROM hospitals WHERE email = ?");
        $check->execute([$email]);
        
        if ($check->rowCount() > 0) {
            $error = "Email already registered!";
        } else {
            $hospitalId = generateUniqueId('HOS');
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO hospitals (hospital_id, name, email, password, phone, address, city, state, zip_code) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            if ($stmt->execute([$hospitalId, $name, $email, $hashed, $phone, $address, $city, $state, $zip])) {
                $success = "Registration successful! Your application is pending admin approval. Redirecting to login...";
                header("refresh:3;url=login.php");
            } else {
                $error = "Registration failed!";
            }
        }
    }
}

$pageTitle = "Hospital Registration";
?>
<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Hospital Registration</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Hospital Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone *</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Address *</label>
                                <textarea class="form-control" name="address" rows="2" required></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>City *</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>State *</label>
                                <input type="text" class="form-control" name="state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Zip Code *</label>
                                <input type="text" class="form-control" name="zip" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Password *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register Hospital</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        Already registered? <a href="login.php">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>