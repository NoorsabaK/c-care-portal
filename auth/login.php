<?php
require_once '../config/config.php';
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    if ($role == 'admin') {
        // Admin login
        $query = "SELECT * FROM admins WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['username'];
            $_SESSION['role'] = 'admin';
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['admin_id'] = $user['id'];
            
            // Log activity
            $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, 'login', 'Admin logged in', ?)");
            $logStmt->execute([$user['username'], $_SERVER['REMOTE_ADDR']]);
            
            header("Location: ../admin/dashboard.php");
            exit();
        } else {
            $error = "Invalid admin credentials!";
        }
    } elseif ($role == 'hospital') {
        // Hospital login
        $query = "SELECT * FROM hospitals WHERE email = ? AND approval_status = 'approved'";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['hospital_id'];
            $_SESSION['role'] = 'hospital';
            $_SESSION['name'] = $user['name'];
            
            header("Location: ../hospital/dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials or hospital not approved!";
        }
    } else {
        // Patient login
        $query = "SELECT * FROM patients WHERE email = ? OR phone = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['patient_id'];
            $_SESSION['role'] = 'patient';
            $_SESSION['name'] = $user['name'];
            
            header("Location: ../patient/dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1977cc 0%, #2c4964 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: #1977cc;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
        }
        .btn-login {
            background: #1977cc;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            background: #1c84e3;
        }
        .role-option {
            cursor: pointer;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s;
        }
        .role-option.active {
            border-color: #1977cc;
            background: rgba(25, 119, 204, 0.1);
            color: #1977cc;
        }
        .role-option i {
            font-size: 24px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-heartbeat fa-3x mb-3"></i>
                        <h3>Welcome Back!</h3>
                        <p>Login to your account</p>
                    </div>
                    <div class="login-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <div class="role-option active" data-role="patient">
                                        <i class="fas fa-user"></i>
                                        <div>Patient</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="role-option" data-role="hospital">
                                        <i class="fas fa-hospital"></i>
                                        <div>Hospital</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="role-option" data-role="admin">
                                        <i class="fas fa-user-shield"></i>
                                        <div>Admin</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="role" id="role" value="patient">
                            <div class="mb-3">
                                <label class="form-label">Email / Username / Phone</label>
                                <input type="text" class="form-control" name="email" required placeholder="Enter your email or username">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-login w-100 text-white">Login</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="mb-1">
                                <a href="register.php">New Patient? Register here</a>
                            </p>
                            <p class="mb-1">
                                <a href="hospital-register.php">Hospital Registration</a>
                            </p>
                            <p class="mb-0">
                                <a href="admin-register.php">Admin Registration</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.role-option').forEach(opt => {
            opt.onclick = function() {
                document.querySelectorAll('.role-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('role').value = this.dataset.role;
            }
        });
    </script>
</body>
</html>