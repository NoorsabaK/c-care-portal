<?php
require_once 'config/config.php';
require_once 'config/database.php';
$pageTitle = "Book Appointment";
?>
<?php include 'includes/header.php'; ?>

<main class="main">
    <section class="page-title bg-light py-5">
        <div class="container text-center">
            <h1 class="fw-bold">Book an Appointment</h1>
            <p class="mb-0">Schedule your COVID-19 test or vaccination now</p>
        </div>
    </section>

    <section id="appointment" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <form id="appointmentForm" action="api/submit-request.php" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Full Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" placeholder="Your Phone" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Service Type</label>
                                        <select name="service" class="form-control" required>
                                            <option value="">Select Service</option>
                                            <option value="COVID-19 Test">COVID-19 Test</option>
                                            <option value="Vaccination">Vaccination</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Hospital</label>
                                        <select name="hospital" class="form-control" required>
                                            <option value="">Select Hospital</option>
                                            <?php
                                            $database = Database::getInstance();
                                            $conn = $database->getConnection();
                                            $stmt = $conn->query("SELECT hospital_id, name FROM hospitals WHERE approval_status = 'approved'");
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='".$row['hospital_id']."'>".$row['name']."</option>";
                                            }
                                            // Fallbacks if no hospital approved
                                            if ($stmt->rowCount() == 0) {
                                                echo "<option value='HOS001'>City General Hospital</option>";
                                                echo "<option value='HOS002'>Memorial Medical Center</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label text-muted">Preferred Date</label>
                                        <input type="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <div class="col-12 mb-4">
                                        <label class="form-label text-muted">Additional Notes</label>
                                        <textarea name="message" class="form-control" rows="4" placeholder="Any specific requirements or medical conditions?"></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 w-100 fw-bold">Book Appointment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointmentForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (typeof showLoading === 'function') showLoading();
        
        const formData = new FormData(this);
        
        fetch('api/submit-request.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (typeof hideLoading === 'function') hideLoading();
            
            if (data.success) {
                if (typeof showSuccess === 'function') {
                    showSuccess(data.message, data.redirect);
                } else {
                    alert(data.message);
                    window.location.href = data.redirect;
                }
            } else {
                if (typeof showError === 'function') {
                    showError(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            }
        })
        .catch(error => {
            if (typeof hideLoading === 'function') hideLoading();
            if (typeof showError === 'function') {
                showError('An unexpected error occurred. Please try again.');
            } else {
                alert('An unexpected error occurred.');
            }
            console.error('Error:', error);
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
