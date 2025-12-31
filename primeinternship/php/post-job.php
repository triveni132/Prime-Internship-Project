<?php
/**
 * PrimeInternship.com - Post Job Handler
 */
require_once 'config.php';
check_role('employer');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../employer-dashboard.php');
}

$employer_id = $_SESSION['user_id'];
$title = clean_input($_POST['title']);
$description = clean_input($_POST['description']);
$qualification = clean_input($_POST['qualification']);
$branch = isset($_POST['branch']) && $_POST['branch'] !== '' ? clean_input($_POST['branch']) : NULL;
$location = clean_input($_POST['location']);
$duration = clean_input($_POST['duration']);
$stipend = clean_input($_POST['stipend']);
$skills_required = isset($_POST['skills_required']) ? clean_input($_POST['skills_required']) : NULL;

// Insert job posting
$sql = "INSERT INTO jobs (employer_id, title, description, qualification, branch, location, duration, stipend, skills_required, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "issssssss", $employer_id, $title, $description, $qualification, $branch, $location, $duration, $stipend, $skills_required);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success'] = "Internship opportunity posted successfully! It will be visible to students once approved by admin.";
} else {
    $_SESSION['error'] = "Failed to post opportunity. Please try again.";
}

redirect('../employer-dashboard.php');
?>
