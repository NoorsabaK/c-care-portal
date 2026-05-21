<?php
// Start output buffering to avoid header issues
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1977cc;
            --secondary-color: #2c4964;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        /* ========== COMPACT TOPBAR ========== */
        .topbar {
            background-color: var(--primary-color);
            color: white;
            padding: 4px 0;
            font-size: 12px;
        }
        
        .topbar a {
            color: white;
            text-decoration: none;
        }
        
        .topbar .social-links a {
            color: white;
            margin-left: 12px;
            font-size: 12px;
            opacity: 0.8;
        }
        
        .topbar .social-links a:hover {
            opacity: 1;
        }
        
        /* ========== COMPACT NAVBAR ========== */
        .navbar {
            background-color: white;
            box-shadow: 0 1px 5px rgba(0,0,0,0.08);
            padding: 0.2rem 1rem;
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: var(--secondary-color);
            padding: 0;
        }
        
        .navbar-nav .nav-link {
            color: var(--secondary-color);
            font-weight: 500;
            font-size: 13px;
            padding: 0.5rem 0.75rem !important;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: var(--primary-color);
        }
        
        /* Dropdown menu styling */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            border: none;
            padding: 0.3rem 0;
            font-size: 13px;
        }
        
        .dropdown-item {
            padding: 0.35rem 1.2rem;
            font-size: 13px;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 6px;
            font-size: 12px;
        }
        
        .btn-appointment {
            background-color: var(--primary-color);
            color: white;
            border-radius: 30px;
            padding: 4px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-left: 8px;
        }
        
        .btn-appointment:hover {
            background-color: #1c84e3;
            color: white;
        }
        
        /* Badge for role (smaller) */
        .badge {
            font-size: 10px;
            padding: 3px 6px;
        }
        
        /* Mobile toggle */
        .navbar-toggler {
            font-size: 1rem;
            padding: 0.2rem 0.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-nav .nav-link {
                padding: 0.3rem 0 !important;
            }
            .btn-appointment {
                margin-top: 5px;
                width: 100%;
                text-align: center;
            }
        }
        
        /* Rest of your existing styles (hero, cards, footer, etc.) remain unchanged */
        /* ... keep all your existing styles from your original header ... */
        
        /* Hero Section */
        .hero {
            position: relative;
            min-height: 400px;
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 60px 0;
        }
        
        .hero h2 {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        /* Cards */
        .card-hover { transition: transform 0.3s; }
        .card-hover:hover { transform: translateY(-5px); }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card i { font-size: 40px; color: var(--primary-color); margin-bottom: 10px; }
        .stat-card h3 { font-size: 32px; font-weight: bold; margin-bottom: 5px; }
        
        /* Footer */
        .footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
            font-size: 13px;
        }
        .footer a { color: #ecf0f1; text-decoration: none; }
        .footer a:hover { color: var(--primary-color); }
        .social-icons a {
            display: inline-block;
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 6px;
            font-size: 14px;
        }
        
        /* Loading Spinner */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        /* Scroll Top */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 999;
        }
        .scroll-top.active { opacity: 1; visibility: visible; }
        .scroll-top:hover { background: #1c84e3; }
        
        @media (max-width: 768px) {
            .hero h2 { font-size: 28px; }
            .hero p { font-size: 16px; }
        }
    </style>
</head>
<body>

<div class="loading" id="loading">
    <div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>
</div>

<!-- Compact Top Bar -->
<div class="topbar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <i class="fas fa-envelope me-1"></i> <a href="mailto:support@ccareportal.com">support@ccareportal.com</a>
                <i class="fas fa-phone ms-3 me-1"></i> <span>+1 234 567 8900</span>
            </div>
            <div class="col-md-6 text-end social-links">
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Compact Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <i class="fas fa-heartbeat me-1 text-primary"></i>C-Care Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>about.php">About</a></li>
                
                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                        
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>vaccination.php"><i class="fas fa-syringe me-2"></i>Vaccination</a></li>
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>covid-testing.php"><i class="fas fa-vial me-2"></i>COVID-19 Testing</a></li>
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>digital-reports.php"><i class="fas fa-file-medical me-2"></i>Digital Reports</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>emergency.php"><i class="fas fa-ambulance me-2"></i>Emergency</a></li>
                    </ul>
                </li>
                
                <?php if (!isLoggedIn()): ?>
                    <!-- Patient Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Patient</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/register.php"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/login.php"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                        </ul>
                    </li>
                    <!-- Hospital Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Hospital</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/hospital-register.php"><i class="fas fa-building me-2"></i>Register</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/login.php"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                        </ul>
                    </li>
                    <!-- Admin Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admin</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/admin-register.php"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/admin-login.php"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Logged In User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?>
                            <span class="badge bg-primary ms-1"><?php echo ucfirst($_SESSION['role']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL . $_SESSION['role']; ?>/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <?php if ($_SESSION['role'] == 'patient'): ?>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>patient/my-appointments.php"><i class="fas fa-calendar-check me-2"></i>My Appointments</a></li>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>patient/test-results.php"><i class="fas fa-flask me-2"></i>Test Results</a></li>
                            <?php elseif ($_SESSION['role'] == 'hospital'): ?>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>hospital/manage-requests.php"><i class="fas fa-clipboard-list me-2"></i>Patient Requests</a></li>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>hospital/update-results.php"><i class="fas fa-edit me-2"></i>Update Results</a></li>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>hospital/manage-vaccines.php"><i class="fas fa-syringe me-2"></i>Manage Vaccines</a></li>
                            <?php elseif ($_SESSION['role'] == 'admin'): ?>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/hospitals.php"><i class="fas fa-hospital me-2"></i>Manage Hospitals</a></li>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/patients.php"><i class="fas fa-users me-2"></i>Manage Patients</a></li>
                                <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>admin/approve-hospitals.php"><i class="fas fa-check-circle me-2"></i>Pending Approvals</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>auth/logout.php"><i class="fas fa-sign-out-alt me-2 text-danger"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>contact.php">Contact</a></li>
            </ul>
            <a href="<?php echo SITE_URL; ?>appointment.php" class="btn btn-appointment">Book Appointment</a>
        </div>
    </div>
</nav>

<main>