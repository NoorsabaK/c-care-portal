<?php
require_once '../config/config.php';
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $full_name = sanitize($_POST['full_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_code = $_POST['admin_code'];
    
    // Secret admin registration code (change this to your own)
    $SECRET_ADMIN_CODE = 'ADMIN2024';
    
    if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } elseif ($admin_code != $SECRET_ADMIN_CODE) {
        $error = "Invalid admin registration code!";
    } else {
        // Check if username or email exists
        $check = $conn->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);
        
        if ($check->rowCount() > 0) {
            $error = "Username or email already exists!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO admins (username, email, password, phone, full_name, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            
            if ($stmt->execute([$username, $email, $hashed, $phone, $full_name])) {
                $success = "Admin account created successfully! Please login.";
                // Auto redirect after 2 seconds
                echo '<meta http-equiv="refresh" content="2;url=admin-login.php">';
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
    <title>Admin Registration - <?php echo SITE_NAME; ?></title>
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
            background: linear-gradient(135deg, #1977cc 0%, #2c4964 100%);
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
        .btn-register:hover {
            background: #1c84e3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-shield fa-3x mb-3"></i>
                        <h3>Admin Registration</h3>
                        <p>Create Administrator Account</p>
                    </div>
                    <div class="register-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?> Redirecting to login...</div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label>Username *</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label>Full Name *</label>
                                <input type="text" class="form-control" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                            <div class="mb-3">
                                <label>Password *</label>
                                <input type="password" class="form-control" name="password" required>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <div class="mb-3">
                                <label>Admin Registration Code *</label>
                                <input type="password" class="form-control" name="admin_code" required>
                                <small class="text-muted">Contact system administrator for the code</small>
                            </div>
                            <button type="submit" class="btn btn-register w-100 text-white">Register as Admin</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            Already have an account? <a href="admin-login.php">Login here</a><br>
                            <a href="login.php">Patient / Hospital Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>