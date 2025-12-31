<?php
/**
 * PrimeInternship.com - Home Page
 * Industry Immersion & Career Pathway Platform
 */
require_once 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PrimeInternship.com - Right Internship Pathway to the Right Career. India & Overseas Industry Immersion Programs for students.">
    <meta name="keywords" content="internship, career pathway, industry immersion, overseas internship, career counseling">
    <title>PrimeInternship - Industry Immersion & Career Pathway Platform</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header & Navigation -->
    <header class="header">
        <nav class="navbar">
            <div class="logo-container">
                <a href="index.php">
                    <img src="assets/images/logo.png" alt="Prime Internship – Career & Internship Platform" class="logo">
                </a>
            </div>
            
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link active">Home</a></li>
                <li><a href="about.php" class="nav-link">About Us</a></li>
                <li><a href="programs.php" class="nav-link">Programs</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
                <?php if (is_logged_in()): ?>
                    <?php if ($_SESSION['role'] === 'student'): ?>
                        <li><a href="student-dashboard.php" class="nav-link">Dashboard</a></li>
                    <?php elseif ($_SESSION['role'] === 'employer'): ?>
                        <li><a href="employer-dashboard.php" class="nav-link">Dashboard</a></li>
                    <?php elseif ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="admin-dashboard.php" class="nav-link">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-primary">Login</a></li>
                    <li><a href="register.php" class="btn btn-secondary">Register</a></li>
                <?php endif; ?>
            </ul>
            
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>
    
    <script src="js/main.js"></script>
</body>
</html>
