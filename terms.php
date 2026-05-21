<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - C-Care</title>
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

        .btn-home {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            background: linear-gradient(135deg, #0056b3, #004085);
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
                    <h2>Terms & Conditions</h2>
                    <small class="text-muted">Last Updated: May 9, 2026</small>
                </div>

                <hr class="hr-style">

                <!-- 1. Appointment -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-calendar-check"></i> 1. Appointment Booking</h4>
                    <p>Appointment book karte waqt sahi aur mukammal details dena aap ki zimmedari hai. Ghalat maloomat ki surat mein system automatically appointment cancel kar sakta hai.</p>
                </div>

                <!-- 2. Cancellation -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-clock"></i> 2. Cancellation Policy</h4>
                    <p>Agar aap kisi wajah se hospital nahi aa sakte, toh baraye meherbani 24 ghante pehle humein dashboard ke zariye itlaa dein taake kisi aur mareez ka waqt bach sakay.</p>
                </div>

                <!-- 3. Emergency -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-truck-medical"></i> 3. Emergency Services</h4>
                    <p>Ye portal sirf routine checkups ke liye hai. Shadeed emergency ki surat mein website ka intezar na karein aur foran hospital ke Emergency Ward mein tashreef layein.</p>
                </div>

                <!-- 4. User Conduct -->
                <div class="term-item">
                    <h4><i class="fa-solid fa-user-shield"></i> 4. User Conduct & Security</h4>
                    <p>Website par kisi bhi kism ka spam data ya ghalat records upload karna sakht mana hai. Aisa karne par aapka account block kiya ja sakta hai.</p>
                </div>

                <div class="pt-4 border-top">
                    <a href="index.php" class="btn btn-primary btn-home">
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