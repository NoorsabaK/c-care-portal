<div class="card-body text-center">
    <i class="fas fa-hospital fa-4x mb-3 text-primary"></i>
    <h5>Hospital Panel</h5>
    <p class="text-muted"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Hospital'); ?></p>
</div>
<div class="list-group list-group-flush">
    <a href="dashboard.php" class="list-group-item list-group-item-action">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
    </a>
    <a href="manage-vaccines.php" class="list-group-item list-group-item-action">
    <i class="fas fa-syringe me-2"></i>Manage Vaccines
</a>
    <a href="manage-requests.php" class="list-group-item list-group-item-action">
        <i class="fas fa-clipboard-list me-2"></i>Patient Requests
    </a>
    <a href="patients.php" class="list-group-item list-group-item-action">
        <i class="fas fa-users me-2"></i>My Patients
    </a>
    <a href="update-results.php" class="list-group-item list-group-item-action">
        <i class="fas fa-flask me-2"></i>Update COVID Results
    </a>
    <a href="update-vaccination.php" class="list-group-item list-group-item-action">
        <i class="fas fa-syringe me-2"></i>Update Vaccination
    </a>
    <a href="profile.php" class="list-group-item list-group-item-action">
        <i class="fas fa-user-edit me-2"></i>Profile
    </a>
    <a href="../auth/logout.php" class="list-group-item list-group-item-action text-danger">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </a>
</div>