<?php
/**
 * PrimeInternship.com - Contact Form Handler
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../contact.php');
}

$name = clean_input($_POST['name']);
$email = clean_input($_POST['email']);
$phone = isset($_POST['phone']) ? clean_input($_POST['phone']) : NULL;
$inquiry_type = clean_input($_POST['inquiry_type']);
$message = clean_input($_POST['message']);

// Insert inquiry
$sql = "INSERT INTO inquiries (name, email, phone, inquiry_type, message, status) VALUES (?, ?, ?, ?, ?, 'new')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $inquiry_type, $message);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Thank you for contacting us! We'll get back to you soon.";
} else {
    $_SESSION['error'] = "Failed to submit inquiry. Please try again.";
}

redirect('../contact.php');
?>
