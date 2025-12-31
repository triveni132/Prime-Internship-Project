<?php
/**
 * Database Configuration File
 * PrimeInternship.com - Industry Immersion & Career Pathway Platform
 * DEBUGGED & IMPROVED VERSION
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'primeinternship_db');

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Configure session with security settings
if (session_status() === PHP_SESSION_NONE) {
    // Session security settings
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    
    // Start session
    session_start();
    
    // Session timeout (30 minutes)
    if (isset($_SESSION['login_time'])) {
        $timeout = 1800; // 30 minutes
        if (time() - $_SESSION['login_time'] > $timeout) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        }
    }
}

// Define base URL
define('BASE_URL', 'http://localhost/primeinternship/');

// Define upload directories
define('RESUME_UPLOAD_DIR', 'uploads/resumes/');

// Function to sanitize input (DO NOT USE ON PASSWORDS!)
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

// Function to check user role with improved error handling
function check_role($required_role) {
    if (!is_logged_in()) {
        $_SESSION['error'] = "Please login to access this page";
        header("Location: login.php");
        exit();
    }
    
    if ($_SESSION['role'] !== $required_role) {
        $_SESSION['error'] = "Access denied. Insufficient permissions.";
        header("Location: index.php");
        exit();
    }
}

// Function to redirect
function redirect($url) {
    // Prevent header injection
    $url = str_replace(["\r", "\n"], '', $url);
    header("Location: " . $url);
    exit();
}

// Error logging function
function log_error($message) {
    $log_file = __DIR__ . '/../logs/errors.log';
    $log_dir = dirname($log_file);
    
    // Create logs directory if it doesn't exist
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message\n";
    error_log($log_message, 3, $log_file);
}

?>

