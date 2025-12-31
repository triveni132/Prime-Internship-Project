<?php
/**
 * PrimeInternship.com - Admin Job Actions Handler
 */
require_once 'config.php';
check_role('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../admin-dashboard.php');
}

$job_id = intval($_POST['job_id']);
$action = clean_input($_POST['action']);

if ($action === 'approve') {
    $sql = "UPDATE jobs SET status = 'approved' WHERE id = ?";
    $message = "Job posting approved successfully!";
} elseif ($action === 'reject') {
    $sql = "UPDATE jobs SET status = 'rejected' WHERE id = ?";
    $message = "Job posting rejected.";
} elseif ($action === 'delete') {
    $sql = "DELETE FROM jobs WHERE id = ?";
    $message = "Job posting deleted successfully!";
} else {
    $_SESSION['error'] = "Invalid action";
    redirect('../admin-dashboard.php');
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $job_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = $message;
} else {
    $_SESSION['error'] = "Action failed. Please try again.";
}

redirect('../admin-dashboard.php');
?>
