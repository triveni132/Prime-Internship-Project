<?php
/**
 * PrimeInternship.com - Job Application Handler
 */
require_once 'config.php';
check_role('student');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../student-dashboard.php');
}

$job_id = intval($_POST['job_id']);
$student_id = $_SESSION['user_id'];

// Check if job exists and is approved
$sql = "SELECT id FROM jobs WHERE id = ? AND status = 'approved'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $job_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    $_SESSION['error'] = "Invalid or unavailable job opportunity";
    redirect('../student-dashboard.php');
}

// Check if already applied
$sql = "SELECT id FROM applications WHERE job_id = ? AND student_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $job_id, $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['error'] = "You have already applied for this opportunity";
    redirect('../student-dashboard.php');
}

// Insert application
$sql = "INSERT INTO applications (job_id, student_id, application_status) VALUES (?, ?, 'pending')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $job_id, $student_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Application submitted successfully!";
} else {
    $_SESSION['error'] = "Failed to submit application. Please try again.";
}

redirect('../student-dashboard.php');
?>
