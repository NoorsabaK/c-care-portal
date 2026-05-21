<?php
require_once 'config/config.php';
$pageTitle = "COVID-19 Testing";
?>
<?php include 'includes/header.php'; ?>

<style>
        :root {
            --primary-color: #1977cc;
            --secondary-color: #2c4964;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            background: rgba(25, 119, 204, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .service-icon i {
            font-size: 32px;
            color: var(--primary-color);
        }
        
        .service-card h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        
        .service-card p {
            color: #6c757d;
            line-height: 1.6;
        }
        
        .btn-learn-more {
            background: var(--primary-color);
            color: white;
            border-radius: 30px;
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-learn-more:hover {
            background: var(--secondary-color);
            color: white;
        }
    </style>
</head>
<body>


<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>COVID-19 Testing Services</h1>
        <p class="lead mb-0">Accurate, Fast, and Reliable Testing for Your Safety</p>
    </div>
</section>

<!-- Testing Options -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-vial"></i>
                </div>
                <h3>RT-PCR Test</h3>
                <p>The gold standard for COVID-19 detection. Highly accurate results delivered within 24-48 hours. Recommended for travel and official purposes.</p>
                <ul class="text-muted mb-4">
                    <li>Accuracy: >99%</li>
                    <li>Results: 24-48 hours</li>
                    <li>Certified Lab</li>
                </ul>
                <?php if (isLoggedIn() && $_SESSION['role'] == 'patient'): ?>
                    <a href="<?php echo SITE_URL; ?>patient/request-test.php" class="btn-learn-more">Book Test <i class="fas fa-arrow-right ms-2"></i></a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>auth/login.php" class="btn-learn-more">Login to Book <i class="fas fa-arrow-right ms-2"></i></a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Rapid Antigen Test</h3>
                <p>Quick results for immediate screening. Perfect for emergency situations and rapid clearance. Results in just 15-30 minutes.</p>
                <ul class="text-muted mb-4">
                    <li>Speed: 15-30 minutes</li>
                    <li>Easy sample collection</li>
                    <li>Ideal for screening</li>
                </ul>
                <?php if (isLoggedIn() && $_SESSION['role'] == 'patient'): ?>
                    <a href="<?php echo SITE_URL; ?>patient/request-test.php" class="btn-learn-more">Book Test <i class="fas fa-arrow-right ms-2"></i></a>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>auth/login.php" class="btn-learn-more">Login to Book <i class="fas fa-arrow-right ms-2"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Information Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Important Information:</strong> All tests are conducted by certified professionals at our partner hospitals. Results are uploaded to your digital dashboard and accessible anytime.
            </div>
        </div>
    </div>
    
    <!-- Process Steps -->
    <div class="row mt-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">How It Works</h2>
            <p class="text-muted">Simple 3-step process to get tested</p>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="stat-card">
                <i class="fas fa-calendar-plus fa-3x"></i>
                <h4>1. Book Appointment</h4>
                <p>Select your preferred hospital and test type</p>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="stat-card">
                <i class="fas fa-microscope fa-3x"></i>
                <h4>2. Visit & Give Sample</h4>
                <p>Visit the hospital at scheduled time</p>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="stat-card">
                <i class="fas fa-file-alt fa-3x"></i>
                <h4>3. Get Results Online</h4>
                <p>View and download your report from dashboard</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>