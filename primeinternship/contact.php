<?php
/**
 * PrimeInternship.com - Contact Us Page
 */
require_once 'php/config.php';

$inquiry_type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - PrimeInternship</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
<link rel="apple-touch-icon" href="assets/images/logo.png">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="logo-container">
                <a href="index.php">
                    <img src="assets/images/logo.png" alt="Prime Internship – Career & Internship Platform" class="logo">
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li><a href="programs.php" class="nav-link">Programs</a></li>
                <li><a href="contact.php" class="nav-link active">Contact</a></li>
                <?php if (!is_logged_in()): ?>
                    <li><a href="login.php" class="btn btn-primary">Login</a></li>
                <?php else: ?>
                    <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
                <?php endif; ?>
            </ul>
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Get in Touch</h1>
            <p class="subtitle">We're here to help you make the right career decisions</p>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="section">
        <div class="container">
            <div class="form-container">
                <h2 class="text-center">Send Us Your Inquiry</h2>
                <p class="text-center mb-3">Fill out the form below and we'll get back to you soon</p>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="php/contact-handler.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+91-XXXXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Inquiry Type *</label>
                        <select name="inquiry_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Career Counseling Request" <?php echo $inquiry_type === 'counseling' ? 'selected' : ''; ?>>Career Counseling Request</option>
                            <option value="Corporate Partnership Inquiry" <?php echo $inquiry_type === 'corporate' ? 'selected' : ''; ?>>Corporate Partnership Inquiry</option>
                            <option value="Overseas Partner Collaboration" <?php echo $inquiry_type === 'overseas' ? 'selected' : ''; ?>>Overseas Partner Collaboration</option>
                            <option value="General Inquiry">General Inquiry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" required rows="6" placeholder="Tell us about your inquiry..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Inquiry</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Other Ways to Reach Us</h2>
            <div class="card-grid">
                <div class="card text-center">
                    <div class="card-icon">📧</div>
                    <h3>Email Us</h3>
                    <p>info@primeinternship.com</p>
                    <p>support@primeinternship.com</p>
                </div>
                <div class="card text-center">
                    <div class="card-icon">📞</div>
                    <h3>Call Us</h3>
                    <p>+91-8518914204</p>
                    <p>Mon-Fri: 9:00 AM - 6:00 PM IST</p>
                </div>
                <div class="card text-center">
                    <div class="card-icon">📍</div>
                    <h3>Visit Us</h3>
                    <p>PrimeInternship </p>
                    <p>3rd Floor, Above Bapu Ki Kutiya, Jyoti Shopping Complex, M. P. Nagar Bhopal, Madhya Pradesh, India</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>About PrimeInternship</h4>
                <p>Industry Immersion & Career Pathway Platform helping students make informed career decisions.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <p><a href="about.php">About Us</a></p>
                <p><a href="programs.php">Programs</a></p>
                <p><a href="contact.php">Contact</a></p>
            </div>
            <div class="footer-section">
                <h4>For Students</h4>
                <p><a href="register.php">Student Registration</a></p>
                <p><a href="student-dashboard.php">Dashboard</a></p>
            </div>
            <div class="footer-section">
                <h4>For Employers</h4>
                <p><a href="register.php?type=employer">Employer Registration</a></p>
                <p><a href="employer-dashboard.php">Dashboard</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> PrimeInternship.com - All Rights Reserved</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
