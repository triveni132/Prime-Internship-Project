<?php
/**
 * PrimeInternship.com - Login Handler (DEBUGGED & FIXED)
 */
require_once 'config.php';

// Enable error logging for debugging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/login_errors.log');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../login.php');
}

// Get credentials - DO NOT escape password (it will break hash verification)
$email = clean_input($_POST['email']);
$password = $_POST['password']; // IMPORTANT: Do NOT clean/escape password!

// Debug logging (remove in production)
error_log("Login attempt for email: $email");

// Fetch user from database
$sql = "SELECT u.*, s.qualification, s.branch, e.company_name 
        FROM users u 
        LEFT JOIN students s ON u.id = s.user_id 
        LEFT JOIN employers e ON u.id = e.user_id 
        WHERE u.email = ? AND u.status = 'active'";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    error_log("Database prepare error: " . mysqli_error($conn));
    $_SESSION['error'] = "System error. Please try again.";
    redirect('../login.php');
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if user exists
if (mysqli_num_rows($result) === 0) {
    error_log("Login failed: User not found or inactive - $email");
    $_SESSION['error'] = "Invalid email or password";
    redirect('../login.php');
}

$user = mysqli_fetch_assoc($result);

// Debug logging
error_log("User found: ID={$user['id']}, Role={$user['role']}, Name={$user['name']}");
error_log("Stored hash: " . substr($user['password'], 0, 20) . "...");

// Verify password
if (!password_verify($password, $user['password'])) {
    error_log("Login failed: Invalid password for $email");
    $_SESSION['error'] = "Invalid email or password";
    redirect('../login.php');
}

// Password verified successfully
error_log("Login successful for $email (Role: {$user['role']})");

// Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Set session variables
$_SESSION['user_id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];
$_SESSION['login_time'] = time();

// Set role-specific session data
if ($user['role'] === 'student') {
    $_SESSION['qualification'] = $user['qualification'];
    $_SESSION['branch'] = $user['branch'];
    error_log("Student session data set: {$user['qualification']}, {$user['branch']}");
} elseif ($user['role'] === 'employer') {
    $_SESSION['company_name'] = $user['company_name'];
    error_log("Employer session data set: {$user['company_name']}");
}

// Redirect based on role with absolute path
if ($user['role'] === 'admin') {
    error_log("Redirecting to admin dashboard");
    header("Location: ../admin-dashboard.php");
    exit();
} elseif ($user['role'] === 'employer') {
    error_log("Redirecting to employer dashboard");
    header("Location: ../employer-dashboard.php");
    exit();
} else {
    error_log("Redirecting to student dashboard");
    header("Location: ../student-dashboard.php");
    exit();
}
?>
