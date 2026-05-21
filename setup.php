<?php
require_once 'config/config.php';

try {
    // Connect to MySQL server first (without database)
    $conn = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`");
    echo "Database created or already exists.<br>";
    
    // Connect to the database
    $conn->exec("USE `" . DB_NAME . "`");
    
    // Read the SQL file
    $sqlFile = __DIR__ . '/ors_system.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        $conn->exec($sql);
        echo "Database schema imported successfully.<br>";
    } else {
        echo "Error: ors_system.sql file not found.<br>";
    }

    // Insert default admin if none exists
    $stmt = $conn->query("SELECT COUNT(*) as total FROM admins");
    $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if ($adminCount == 0) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $conn->prepare("INSERT INTO admins (username, email, password, full_name) VALUES (?, ?, ?, ?)");
        $insertAdmin->execute(['admin', 'admin@ccareportal.com', $adminPassword, 'Super Admin']);
        echo "Default admin account created. <br>Email: admin@ccareportal.com <br>Password: admin123<br>";
    } else {
        echo "Admin account already exists.<br>";
    }
    
    echo "Setup completed successfully! Please <a href='auth/login.php'>Login here</a>.";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
