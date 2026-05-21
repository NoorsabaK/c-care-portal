<?php
require_once 'config/config.php';
$pageTitle = "About Us";
?>
<?php include 'includes/header.php'; ?>

<main class="main">
    <section class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>About Us</h1>
                        <p class="mb-0">Learn more about C-Care Portal and our mission to make healthcare accessible.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about section">
        <div class="container">
            <div class="row gy-4 gx-5">
                <div class="col-lg-6 position-relative align-self-start">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" class="img-fluid rounded" alt="About Us">
                </div>
                <div class="col-lg-6 content">
                    <h3>Our Mission</h3>
                    <p>To provide a seamless, efficient, and reliable platform for COVID-19 testing and vaccination management, connecting patients with healthcare providers across the nation.</p>
                    
                    <h3 class="mt-4">What We Do</h3>
                    <p>C-Care Portal simplifies the process of finding hospitals, booking appointments, and tracking COVID-19 test results and vaccination status. Our platform serves as a bridge between patients and healthcare providers, ensuring timely and efficient service delivery.</p>
                    
                    <h3 class="mt-4">Our Vision</h3>
                    <p>Creating a healthier world by eliminating barriers to healthcare access through innovative digital solutions.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-primary fa-2x me-3"></i>
                                <div>
                                    <h5>Easy Registration</h5>
                                    <p class="text-muted">Simple patient and hospital registration process</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-primary fa-2x me-3"></i>
                                <div>
                                    <h5>Real-time Updates</h5>
                                    <p class="text-muted">Instant SMS notifications for all activities</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-primary fa-2x me-3"></i>
                                <div>
                                    <h5>Secure Platform</h5>
                                    <p class="text-muted">Role-based access with password protection</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <i class="fas fa-check-circle text-primary fa-2x me-3"></i>
                                <div>
                                    <h5>24/7 Access</h5>
                                    <p class="text-muted">Access your health records anytime, anywhere</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>