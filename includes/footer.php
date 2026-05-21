</main>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-heartbeat me-2"></i>C-Care Portal</h5>
                <p>Your trusted platform for COVID-19 testing and vaccination management.</p>
                <div class="social-icons mt-3">
                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a>
                </li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Our Services</h5>
                <ul class="list-unstyled">
                    <li><a href="covid-testing.php">COVID-19 Testing</a></li>
                    <li><a href="vaccination.php">Vaccination Drive</a></li>
                    <li><a href="digital-reports.php">Digital Reports</a></li>
                    <li><a href="emergency.php">Emergency Support</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Healthcare Ave, NY</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 8900</li>
                    <li><i class="fas fa-envelope me-2"></i> support@ccareportal.com</li>
                    <li><i class="fas fa-clock me-2"></i> 24/7 Emergency Support</li>
                </ul>
            </div>
        </div>
        <hr class="bg-light">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> C-Care Portal. All rights reserved.</p>
        </div>
    </div>
</footer>

<div class="scroll-top">
    <i class="fas fa-arrow-up"></i>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showLoading() {
    $('#loading').css('display', 'flex');
}

function hideLoading() {
    $('#loading').hide();
}

function showSuccess(message, redirectUrl = null) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        confirmButtonColor: '#1977cc'
    }).then((result) => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message,
        confirmButtonColor: '#dc3545'
    });
}

// Scroll to top
$(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
        $('.scroll-top').addClass('active');
    } else {
        $('.scroll-top').removeClass('active');
    }
});

$('.scroll-top').click(function() {
    $('html, body').animate({scrollTop: 0}, 500);
});
</script>
</body>
</html>