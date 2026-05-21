<?php
require_once '../config/config.php';
require_once '../config/database.php';

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
    $dob = sanitize($_POST['dob']);
    $gender = sanitize($_POST['gender']);
    
    if ($password != $confirm) {
        $error = "Passwords do not match!";
    } else {
        $check = $conn->prepare("SELECT id FROM patients WHERE email = ? OR phone = ?");
        $check->execute([$email, $phone]);
        if ($check->rowCount() > 0) {
            $error = "Email or phone already registered!";
        } else {
            $patientId = generateUniqueId('PAT');
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO patients (patient_id, name, email, phone, password, date_of_birth, gender, address, city) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            if ($stmt->execute([$patientId, $name, $email, $phone, $hashed, $dob, $gender, $address, $city])) {
                $success = "Registration successful! Your Patient ID is: $patientId";
                header("refresh:2;url=login.php");
            } else {
                $error = "Registration failed!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1977cc 0%, #2c4964 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .register-header {
            background: #1977cc;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .register-body {
            padding: 40px;
        }
        .btn-register {
            background: #1977cc;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <h3>Patient Registration</h3>
                        <p>Create your account</p>
                    </div>
                    <div class="register-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Full Name *</label>
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
                                <div class="col-md-6 mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="dob">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="">Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" rows="2"></textarea>
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
                            <button type="submit" class="btn btn-register w-100 text-white">Register</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            Already have an account? <a href="login.php">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>