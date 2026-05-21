<?php
require_once 'config/config.php';
$pageTitle = "Digital Reports";
?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Reports - C-Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --bg-light: #f4f7fe;
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .legal-wrapper {
            padding: 60px 0;
        }

        .legal-container {
            background: #ffffff;
            padding: 50px;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .legal-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 8px;
            background: linear-gradient(90deg, #007bff, #00d2ff);
        }

        .legal-header h2 {
            font-weight: 800;
            color: #2c3e50;
        }

        .legal-header p {
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .hr-style {
            height: 2px;
            background: #eee;
            margin: 30px 0;
            border: none;
        }

        .term-item {
            margin-bottom: 35px;
            transition: transform 0.3s ease;
        }

        .term-item:hover {
            transform: translateX(10px);
        }

        .term-item h4 {
            color: var(--primary-color);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .term-item p {
            color: #5a6268;
            padding-left: 35px;
            margin-top: 10px;
        }

        /* Step Guide Style */
        .step-box {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin-left: 35px;
            margin-top: 15px;
            border-radius: 0 10px 10px 0;
        }

        .btn-home {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }
    </style>
</head>
<body>

<div class="container legal-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="legal-container">
                <div class="legal-header">
                    <p>Our Services</p>
                    <h2>Digital Reports</h2>
                    <small class="text-muted">Fast. Secure. Paperless.</small>
                </div>

                <hr class="hr-style">

                <!-- Main Service -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-file-medical"></i> Online Lab Results</h4>
                    <p>There's no need to visit the hospital for your reports anymore. You can download your reports from your dashboard at any time.</p>
                </div>

                <!-- How to Download -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-circle-info"></i> How to get the report?</h4>
                    <div class="step-box">
                        <ul class="list-unstyled m-0">
                            <li><i class="fa-solid fa-1 me-2 text-primary"></i> in your account<strong>Login</strong> do.</li>
                            <li><i class="fa-solid fa-2 me-2 text-primary"></i> Sidebar my <strong>"My Reports"</strong> click on.</li>
                            <li><i class="fa-solid fa-3 me-2 text-primary"></i> You are in front of the Matlab report. <strong>Download PDF</strong>click on.</li>
                        </ul>
                    </div>
                </div>

                <!-- Security -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-shield-halved"></i> Data Privacy</h4>
                    <p>Your medical reports are encrypted on our servers and only you can access them.</p>
                </div>

                <div class="pt-4 border-top">
                    <a href="index.php" class="btn btn-home">
                        <i class="fa-solid fa-house me-2"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>