<?php
// config.php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'homeworkhub_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Function to get PDO connection
function getPDO() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}

// Check if user is logged in
function checkLogin() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
        header('Location: login.php');
        exit();
    }
    return true;
}

// Get current user info
function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        $pdo = getPDO();
        // REMOVED user_type from the query since it doesn't exist
        $stmt = $pdo->prepare("SELECT id, email, full_name FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>