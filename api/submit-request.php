<?php
require_once '../config/config.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$database = Database::getInstance();
$conn = $database->getConnection();

// Get form data
$name = sanitize($_POST['name']);
$email = sanitize($_POST['email']);
$phone = sanitize($_POST['phone']);
$service = sanitize($_POST['service']);
$hospitalId = sanitize($_POST['hospital']);
$date = sanitize($_POST['date']);
$message = isset($_POST['message']) ? sanitize($_POST['message']) : '';

// Validate inputs
if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($hospitalId) || empty($date)) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
    exit();
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
    exit();
}

try {
    // Check if patient exists
    $checkStmt = $conn->prepare("SELECT patient_id FROM patients WHERE email = ? OR phone = ?");
    $checkStmt->execute([$email, $phone]);
    $existingPatient = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingPatient) {
        $patientId = $existingPatient['patient_id'];
    } else {
        // Create new patient
        $patientId = generateUniqueId('PAT');
        $tempPassword = password_hash('temp123', PASSWORD_DEFAULT);
        
        $insertStmt = $conn->prepare("INSERT INTO patients (patient_id, name, email, phone, password, registration_date) VALUES (?, ?, ?, ?, ?, NOW())");
        if (!$insertStmt->execute([$patientId, $name, $email, $phone, $tempPassword])) {
            echo json_encode(['success' => false, 'message' => 'Failed to create patient account']);
            exit();
        }
    }

    // Check for duplicate appointment
    $checkApt = $conn->prepare("SELECT * FROM appointments WHERE patient_id = ? AND hospital_id = ? AND appointment_date = ? AND status NOT IN ('cancelled', 'completed')");
    $checkApt->execute([$patientId, $hospitalId, $date]);
    if ($checkApt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'You already have an appointment on this date']);
        exit();
    }

    // Create appointment
    $appointmentId = generateUniqueId('APT');
    $appointmentType = ($service == 'COVID-19 Test') ? 'test' : 'vaccination';
    $time = '10:00:00'; // Default time

    $query = "INSERT INTO appointments (appointment_id, patient_id, hospital_id, appointment_type, appointment_date, appointment_time, notes, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($query);

    if ($stmt->execute([$appointmentId, $patientId, $hospitalId, $appointmentType, $date, $time, $message])) {
        // Log activity
        $logStmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, 'appointment_booking', ?, ?)");
        $logStmt->execute([$patientId, "Booked appointment with ID: $appointmentId", $_SERVER['REMOTE_ADDR']]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Appointment booked successfully! We will contact you shortly.',
            'redirect' => SITE_URL . 'auth/login.php'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to book appointment. Please try again.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>