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

<!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About PrimeInternship</h4>
                <p>Industry Immersion & Career Pathway Platform helping students make informed career decisions through real-world experience.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <p><a href="about.php">About Us</a></p>
                <p><a href="programs.php">Programs</a></p>
                <p><a href="contact.php">Contact</a></p>
                <p><a href="login.php">Login</a></p>
            </div>
            <div class="footer-section">
                <h4>For Students</h4>
                <p><a href="register.php">Student Registration</a></p>
                <p><a href="student-dashboard.php">Student Dashboard</a></p>
                <p><a href="contact.php?type=counseling">Career Counseling</a></p>
            </div>
            <div class="footer-section">
                <h4>For Employers</h4>
                <p><a href="register.php?type=employer">Employer Registration</a></p>
                <p><a href="employer-dashboard.php">Post Opportunities</a></p>
                <p><a href="contact.php?type=corporate">Corporate Partnership</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> PrimeInternship.com - All Rights Reserved</p>
            <p>Career-First | Student-Centric | Industry-Aligned</p>
        </div>
    </footer>
<script src="js/main.js"></script>
</body>
</html>