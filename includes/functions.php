<?php
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function generateUniqueId($prefix) {
    return $prefix . date('Ymd') . rand(1000, 9999);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function checkRole($allowedRoles) {
    if (!isLoggedIn()) {
        redirect(SITE_URL . 'auth/login.php');
    }
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        redirect(SITE_URL . 'index.php');
    }
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function getStatusBadge($status) {
    $badges = [
        'pending' => 'warning',
        'approved' => 'success',
        'confirmed' => 'info',
        'completed' => 'success',
        'cancelled' => 'danger',
        'positive' => 'danger',
        'negative' => 'success',
        'scheduled' => 'info',
        'active' => 'success'
    ];
    $color = isset($badges[$status]) ? $badges[$status] : 'secondary';
    return "<span class='badge bg-$color'>" . ucfirst($status) . "</span>";
}

function formatDate($date) {
    if (!$date || $date == '0000-00-00') return 'N/A';
    return date('M d, Y', strtotime($date));
}
?>