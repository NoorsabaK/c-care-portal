<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - C-Care</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #27ae60; /* Privacy ke liye green theme behtar hai */
            --secondary-color: #6c757d;
            --bg-light: #f4fbf7;
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
            box-shadow: 0 10px 30px rgba(39, 174, 96, 0.1);
            position: relative;
            overflow: hidden;
        }

        /* Top Green Bar Decor */
        .legal-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, #27ae60, #2ecc71);
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

        .policy-item {
            margin-bottom: 35px;
            transition: transform 0.3s ease;
        }

        .policy-item:hover {
            transform: translateX(10px);
        }

        .policy-item h4 {
            color: var(--primary-color);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
        }

        .policy-item p {
            color: #5a6268;
            padding-left: 35px;
            margin-top: 10px;
            font-size: 1rem;
        }

        .btn-home {
            background: linear-gradient(135deg, #27ae60, #1e8449);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }
    </style>
</head>
<body>

<div class="container legal-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="legal-container">
                <div class="legal-header">
                    <p>C-Care Medical System</p>
                    <h2>Privacy Policy</h2>
                    <small class="text-muted">Last Updated: May 9, 2026</small>
                </div>

                <hr class="hr-style">

                <!-- 1. Data Collection -->
                <div class="policy-item">
                    <h4><i class="fa-solid fa-database"></i> 1. Information We Collect</h4>
                    <p>Hum aapka personal data (Name, Email, Phone Number) aur medical history collect karte hain taake aapko behtar medical services di ja saken.</p>
                </div>

                <!-- 2. Data Usage -->
                <div class="policy-item">
                    <h4><i class="fa-solid fa-eye-slash"></i> 2. How We Use Data</h4>
                    <p>Aapka data sirf hospital records maintain karne, appointments confirm karne aur zarurat parne par doctor se rabta karne ke liye istemal hota hai.</p>
                </div>

                <!-- 3. Third Party -->
                <div class="policy-item">
                    <h4><i class="fa-solid fa-user-lock"></i> 3. No Third-Party Sharing</h4>
                    <p>C-Care aapki koi bhi personal information kisi bhi marketing company ya third-party ko farokht (sell) nahi karta. Aapka data hamare pas mahfooz hai.</p>
                </div>

                <!-- 4. Security -->
                <div class="policy-item">
                    <h4><i class="fa-solid fa-shield-halved"></i> 4. Data Security</h4>
                    <p>Hum high-level encryption aur secure servers use karte hain taake aapke medical records ko unauthorized access se bachaya ja sakay.</p>
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