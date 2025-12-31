<?php
/**
 * PrimeInternship.com - Programs Page
 */
require_once 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Programs - PrimeInternship</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
    <link rel="apple-touch-icon" href="assets/images/logo.png">
</head>
<body>
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
                <li><a href="programs.php" class="nav-link active">Programs</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
                <?php if (!is_logged_in()): ?>
                    <li><a href="login.php" class="btn btn-primary">Login</a></li>
                <?php else: ?>
                    <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
                <?php endif; ?>
            </ul>
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Our Programs</h1>
            <p class="subtitle">Industry Immersion Opportunities for Your Career Growth</p>
        </div>
    </section>

    <section class="section" id="india">
        <div class="container">
            <h2 class="section-title">🇮🇳 Industry Immersion – India</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">Work with leading Indian companies across various sectors. Gain practical skills and understand the Indian job market dynamics firsthand.</p>
                
                <div class="card-grid">
                    <div class="card">
                        <h3>Technology & IT</h3>
                        <p>Software development, data science, cybersecurity, and emerging tech opportunities.</p>
                    </div>
                    <div class="card">
                        <h3>Business & Management</h3>
                        <p>Marketing, finance, operations, and strategic business roles.</p>
                    </div>
                    <div class="card">
                        <h3>Engineering</h3>
                        <p>Mechanical, civil, electronics, and manufacturing internships.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-gray" id="overseas">
        <div class="container">
            <h2 class="section-title">✈️ Overseas Internship Exposure</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">Experience global work culture and international industry standards. Build a worldwide professional network.</p>
                
                <div class="card-grid">
                    <div class="card">
                        <h3>North America</h3>
                        <p>USA & Canada - Tech hubs, innovation centers, and corporate excellence.</p>
                    </div>
                    <div class="card">
                        <h3>Europe</h3>
                        <p>UK, Germany, Netherlands - Engineering and business opportunities.</p>
                    </div>
                    <div class="card">
                        <h3>Asia-Pacific</h3>
                        <p>Singapore, Japan, Australia - Growing markets and diverse industries.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="corporate">
        <div class="container">
            <h2 class="section-title">👔 Corporate-Mentored Internship Tracks</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">Specialized tracks designed with our corporate partners. Get mentored by industry veterans.</p>
                
                <div class="card-grid">
                    <div class="card">
                        <h3>Full-Stack Development Track</h3>
                        <p>6-month program with hands-on projects and industry mentorship.</p>
                    </div>
                    <div class="card">
                        <h3>Digital Marketing Track</h3>
                        <p>Learn SEO, social media, content strategy from practitioners.</p>
                    </div>
                    <div class="card">
                        <h3>Data Analytics Track</h3>
                        <p>Real-world data projects with Python, SQL, and visualization tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-gray">
        <div class="container text-center">
            <h2>Ready to Start Your Journey?</h2>
            <p style="font-size: 1.1rem; margin: 1rem 0 2rem;">Register now and explore opportunities matching your interests</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Register Now</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> PrimeInternship.com - All Rights Reserved</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
