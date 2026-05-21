<?php
require_once 'config/config.php';
$pageTitle = "Emergency Support";
?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Support - C-Care</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --emergency-red: #dc3545;
            --primary-color: #007bff;
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
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.1);
            position: relative;
            overflow: hidden;
        }

        /* Top Red Bar for Emergency */
        .legal-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 8px;
            background: linear-gradient(90deg, #dc3545, #ff4d5a);
        }

        .legal-header h2 {
            font-weight: 800;
            color: #2c3e50;
        }

        .legal-header p {
            color: var(--emergency-red);
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
        }

        .term-item h4 {
            color: var(--emergency-red);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .term-item p {
            color: #5a6268;
            padding-left: 35px;
            margin-top: 10px;
            font-size: 1.1rem;
        }

        /* Helpline Pulse Button */
        .helpline-box {
            background: #fff5f5;
            border: 2px dashed var(--emergency-red);
            padding: 20px;
            text-align: center;
            border-radius: 15px;
            margin-left: 35px;
            margin-top: 20px;
        }

        .helpline-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--emergency-red);
            display: block;
            text-decoration: none;
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-home {
            background: #6c757d;
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
            background: #5a6268;
            color: white;
        }
    </style>
</head>
<body>

<div class="container legal-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="legal-container">
                <div class="legal-header">
                    <p>24/7 Priority Support</p>
                    <h2>Emergency Support</h2>
                    <small class="text-danger"><strong>Note:</strong> Call immediately in a life-threatening situation.</small>
                </div>

                <hr class="hr-style">

                <!-- Main Contact -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-phone-volume"></i> Immediate Assistance</h4>
                    <p>In case of a serious emergency, call our helpline or send an ambulance request through the website immediately.</p>
                    
                    <div class="helpline-box">
                        <span class="d-block mb-2 text-muted">Emergency Helpline Number:</span>
                        <a href="tel:1122" class="helpline-number">1122</a>
                    </div>
                </div>

                <!-- Ambulance Service -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-truck-medical"></i> Ambulance Service</h4>
                    <p>Our fully-equipped ambulances are capable of reaching locations across the city within 15-20 minutes. You can also track in real time from your dashboard..</p>
                </div>

                <!-- First Aid -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-kit-medical"></i> First Aid Guidance</h4>
                    <p>Our Trinidad operators will provide you with life-saving instructions over the phone until the medical team arrives.</p>
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