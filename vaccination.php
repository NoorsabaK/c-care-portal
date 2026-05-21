<?php
require_once 'config/config.php';
$pageTitle = "Vaccination Drive";
?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Drive - C-Care</title>
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

        /* Top Blue Bar Decor */
        .legal-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, #007bff, #00d2ff);
        }

        .legal-header h2 {
            font-weight: 800;
            color: #2c3e50;
            letter-spacing: -1px;
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
            font-size: 1.25rem;
        }

        .term-item h4 i {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .term-item p {
            color: #5a6268;
            padding-left: 35px;
            margin-top: 10px;
            font-size: 1rem;
        }

        .vaccine-badge {
            display: inline-block;
            background: #e7f1ff;
            color: #007bff;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 10px;
            margin-top: 10px;
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
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            color: white;
            transform: translateY(-2px);
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
                    <h2>Vaccination Drive</h2>
                    <small class="text-muted">Stay safe, stay protected</small>
                </div>

                <hr class="hr-style">

                <!-- Vaccination Point -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-syringe"></i> Get Vaccinated</h4>
                    <p>Register for vaccination today to protect yourself and your loved ones. We offer all government-approved vaccines..</p>
                    
                    <div class="mt-3" style="padding-left: 35px;">
                        <span class="vaccine-badge">COVID-19</span>
                        <span class="vaccine-badge">Flu Shot</span>
                        <span class="vaccine-badge">Hepatitis B</span>
                        <span class="vaccine-badge">Polio</span>
                    </div>
                </div>

                <!-- Registration Point -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-id-card"></i> Easy Registration</h4>
                    <p>You can book a vaccination appointment from your dashboard. You just need to provide your CV and medical history..</p>
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