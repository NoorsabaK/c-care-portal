<?php
require_once 'config/config.php';
require_once 'config/database.php';

$database = Database::getInstance();
$conn = $database->getConnection();

// Get statistics
$stmt = $conn->query("SELECT COUNT(*) as total FROM patients");
$patients = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM hospitals WHERE approval_status = 'approved'");
$hospitals = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM appointments");
$appointments = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $conn->query("SELECT COUNT(*) as total FROM vaccinations WHERE status = 'completed'");
$vaccinations = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$pageTitle = "Home";
include 'includes/header.php';
?>

<!-- Hero Section -->
<!-- Hero Section -->
<section id="hero" class="hero" style="
    background: linear-gradient(rgba(0, 56, 147, 0.75), rgba(0, 56, 147, 0.75)), 
    url('https://img.freepik.com/premium-photo/doctor-holding-virus_1120604-4937.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 120px 0;
    color: white;
    margin-bottom: 30px;">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h2 style="font-weight: 800; font-size: 3.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); margin-bottom: 20px;">
                    Welcome to C-Care Portal
                </h2>
                <p style="font-size: 1.25rem; line-height: 1.6; margin-bottom: 35px; opacity: 0.9;">
                    Your trusted platform for COVID-19 testing, vaccination, and digital health records.
                </p>
                
                <?php if (!isLoggedIn()): ?>
                    <a href="auth/register.php" class="btn btn-light btn-lg px-4 me-2" style="font-weight: 600;">Register Now</a>
                    <a href="auth/login.php" class="btn btn-outline-light btn-lg px-4" style="font-weight: 600;">Login</a>
                <?php else: ?>
                    <a href="<?php echo $_SESSION['role']; ?>/dashboard.php" class="btn btn-light btn-lg px-4" style="font-weight: 600;">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Our Impact</h2>
                <p class="text-muted">Making healthcare accessible to everyone</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <i class="fas fa-hospital"></i>
                    <h3><?php echo number_format($hospitals); ?></h3>
                    <p class="text-muted">Partner Hospitals</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo number_format($patients); ?></h3>
                    <p class="text-muted">Registered Patients</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3><?php echo number_format($appointments); ?></h3>
                    <p class="text-muted">Appointments</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <i class="fas fa-syringe"></i>
                    <h3><?php echo number_format($vaccinations); ?></h3>
                    <p class="text-muted">Vaccinations</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=500&h=400&fit=crop" class="img-fluid rounded" alt="About">
            </div>
            <div class="col-lg-6">
                <h2>About C-Care Portal</h2>
                <p>We provide a seamless platform for COVID-19 testing and vaccination management, connecting patients with healthcare providers.</p>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <i class="fas fa-check-circle text-primary fa-2x mb-2"></i>
                        <h5>Easy Registration</h5>
                        <p>Simple patient registration with unique ID</p>
                    </div>
                    <div class="col-md-6">
                        <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                        <h5>Secure Platform</h5>
                        <p>Role-based access control</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Our Services</h2>
                <p class="text-muted">Comprehensive healthcare solutions</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-hover h-100 text-center p-4">
                    <i class="fas fa-vial fa-3x text-primary mb-3"></i>
                    <h4>COVID-19 Testing</h4>
                    <p>Book RT-PCR or Rapid Antigen tests. Get results within 24 hours.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-hover h-100 text-center p-4">
                    <i class="fas fa-syringe fa-3x text-primary mb-3"></i>
                    <h4>Vaccination Drive</h4>
                    <p>Register for 1st, 2nd, or booster doses at authorized centers.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-hover h-100 text-center p-4">
                    <i class="fas fa-file-medical fa-3x text-primary mb-3"></i>
                    <h4>Digital Reports</h4>
                    <p>Access test results and vaccination certificates online.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Appointment Section -->
<section id="appointment" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Book an Appointment</h2>
                <p>Schedule your COVID-19 test or vaccination now</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="lead mb-4">We've moved our booking form to its own dedicated page to make it easier for you to schedule your visit.</p>
                <a href="appointment.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                    <i class="fas fa-calendar-check me-2"></i> Go to Booking Page
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Gallery section -->
 <section class="gallery-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <p class="text-primary fw-bold text-uppercase">Visual Tour</p>
            <h2 class="fw-bold">Our Hospital Gallery</h2>
            <div class="title-line mx-auto"></div>
        </div>

        <div class="row g-4">
            <!-- Image 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <img src="https://media.istockphoto.com/id/2174582602/photo/a-smiling-male-receptionist-in-a-modern-clinic-is-talking-to-a-male-senior-patient-at-the.jpg?s=612x612&w=0&k=20&c=wBFibLhVwdzJA8drHzxFWLAG4Fv49QQlPDajHfDBlyE=" alt="Reception" class="img-fluid">
                    <div class="gallery-overlay">
                        <span>Modern Reception</span>
                    </div>
                </div>
            </div>
            <!-- Image 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <img src="https://dmwmc.com.ph/wp-content/uploads/2025/01/Laboratory.jpg" alt="Lab" class="img-fluid">
                    <div class="gallery-overlay">
                        <span>Diagnostic Lab</span>
                    </div>
                </div>
            </div>
            <!-- Image 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <img src="https://media.istockphoto.com/id/1481136088/photo/group-of-concentrated-surgical-doctor-team-doing-surgery-patients-in-hospital-operating.jpg?s=612x612&w=0&k=20&c=tM3fM9TzyLRap9tGQPtZDHVqx58QtFeBo3rhTAL38d8=" alt="Operation Theater" class="img-fluid">
                    <div class="gallery-overlay">
                        <span>Operation Theater</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- faq section -->
 <section class="faq-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <p class="text-primary fw-bold text-uppercase">Got Questions?</p>
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <div class="title-line mx-auto"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden" id="hospitalFAQ">
                    
                    <!-- Question 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fa-solid fa-circle-question me-2 text-primary"></i> How to book an appointment?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#hospitalFAQ">
                            <div class="accordion-body text-muted">
                                You can select your desired doctor and time by clicking the "Book Appointment" button on our website. Registration is required.
                            </div>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fa-solid fa-circle-question me-2 text-primary"></i>When do reports become available?
                            </div>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#hospitalFAQ">
                            <div class="accordion-body text-muted">
                                Most lab reports are uploaded to the "Digital Reports" section on your dashboard within 24 hours.
                            </div>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fa-solid fa-circle-question me-2 text-primary"></i> Is emergency service available 24 hours a day??
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#hospitalFAQ">
                            <div class="accordion-body text-muted">
                                Yes! Our emergency department and ambulance service are available 24/7. You can call 1122 at any time.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- .health-tips-section -->
 <section class="health-tips-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <p class="text-primary fw-bold text-uppercase">Wellness Center</p>
            <h2 class="fw-bold">Daily Health Tips</h2>
            <div class="title-line mx-auto"></div>
        </div>

        <div class="row g-4">
            <!-- Tip 1: Hydration -->
            <div class="col-md-4">
                <div class="tip-card h-100 shadow-sm border-0">
                    <div class="tip-image-wrapper">
                        <img src="https://justaddbuoy.com/cdn/shop/articles/2149456756.jpg?v=1759110500&width=1100" class="card-img-top" alt="Hydration">
                        <span class="tip-badge"></span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold"><i class="fa-solid fa-glass-water text-primary me-2"></i> Stay Hydrated</h5>
                        <p class="text-muted">Drink at least 8-10 glasses of water a day to protect your body from heatstroke and dehydration..</p>
                    </div>
                </div>
            </div>

            <!-- Tip 2: Exercise -->
            <div class="col-md-4">
                <div class="tip-card h-100 shadow-sm border-0">
                    <div class="tip-image-wrapper">
                        <img src="https://www.maplewoodseniorliving.com/wp-content/uploads/2021/07/shutterstock_452798881-scaled.jpg" class="card-img-top" alt="Exercise">
                        <span class="tip-badge"></span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold"><i class="fa-solid fa-person-walking text-success me-2"></i> Morning Walk</h5>
                        <p class="text-muted">A 30-minute walk every day is very helpful in controlling your heart health and sugar level..</p>
                    </div>
                </div>
            </div>

            <!-- Tip 3: Vaccination -->
            <div class="col-md-4">
                <div class="tip-card h-100 shadow-sm border-0">
                    <div class="tip-image-wrapper">
                        <img src="https://thumbs.dreamstime.com/b/immune-system-immunity-natural-protection-human-body-against-external-factors-bacteria-viruses-various-immune-279329075.jpg" class="card-img-top" alt="Immunity">
                        <span class="tip-badge"></span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold"><i class="fa-solid fa-shield-virus text-info me-2"></i> Boost Immunity</h5>
                        <p class="text-muted">Use vitamin C and a healthy diet and get your vaccinations done on time..</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Contact Us</h2>
                <p>Get in touch with our support team</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                    <h5>Location</h5>
                    <p>123 Healthcare Ave, Medical District, NY 10001</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                    <h5>Call Us</h5>
                    <p>+1 234 567 8900</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                    <h5>Email Us</h5>
                    <p>support@ccareportal.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>