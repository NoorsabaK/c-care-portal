<?php
require_once 'config/config.php';
require_once 'config/database.php';

$database = Database::getInstance();
$conn = $database->getConnection();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $msg = sanitize($_POST['message']);
    
    if (empty($name) || empty($email) || empty($subject) || empty($msg)) {
        $error = "Please fill all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } else {
        // Log contact message (in production, send email)
        $query = "INSERT INTO activity_logs (user_id, action, details) VALUES ('guest', 'contact', ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute(["Name: $name, Email: $email, Subject: $subject, Message: $msg"]);
        
        $message = "Thank you for contacting us! We'll get back to you shortly.";
    }
}

$pageTitle = "Contact Us";
?>
<?php include 'includes/header.php'; ?>

<main class="main">
    <section class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Contact Us</h1>
                        <p class="mb-0">Have questions? We'd love to hear from you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact section">
        <div class="container" data-aos="fade-up">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="info-item d-flex">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Location</h3>
                            <p>123 Healthcare Ave, Medical District, NY 10001</p>
                        </div>
                    </div>
                    <div class="info-item d-flex">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+1 234 567 8900</p>
                        </div>
                    </div>
                    <div class="info-item d-flex">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>support@ccareportal.com</p>
                        </div>
                    </div>
                    <div class="info-item d-flex">
                        <i class="bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h3>Support Hours</h3>
                            <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="php-email-form">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>