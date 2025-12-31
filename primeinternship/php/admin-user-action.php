<?php
/**
 * PrimeInternship.com - Admin User Actions Handler
 */
require_once 'config.php';
check_role('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../admin-dashboard.php');
}

$user_id = intval($_POST['user_id']);
$action = clean_input($_POST['action']);

if ($action === 'block') {
    $sql = "UPDATE users SET status = 'blocked' WHERE id = ?";
    $message = "User blocked successfully!";
} elseif ($action === 'unblock') {
    $sql = "UPDATE users SET status = 'active' WHERE id = ?";
    $message = "User unblocked successfully!";
} else {
    $_SESSION['error'] = "Invalid action";
    redirect('../admin-dashboard.php');
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = $message;
} else {
    $_SESSION['error'] = "Action failed. Please try again.";
}

redirect('../admin-dashboard.php');
?>
