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
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
<link rel="apple-touch-icon" href="assets/images/logo.png">

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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Right Internship Pathway to the Right Career</h1>
            <p class="subtitle">India & Overseas Industry Immersion Programs</p>
            <p>Discover your true potential through hands-on industry experience before making critical career decisions. We bridge the gap between education and real-world industry requirements.</p>
            <div class="hero-buttons">
                <a href="programs.php" class="btn btn-secondary">Explore Programs</a>
                <a href="contact.php?type=counseling" class="btn btn-outline">Talk to a Career Counselor</a>
            </div>
        </div>
    </section>

    <!-- What We Do Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">What We Do – Our 3 Pillars</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">🎓</div>
                    <h3>Career Clarity Before Degree</h3>
                    <p>We help students gain real industry exposure before committing to expensive degrees. Make informed decisions based on actual experience, not assumptions.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🏭</div>
                    <h3>Industry-Led Immersion</h3>
                    <p>Our programs are designed and mentored by industry professionals. Get hands-on experience with real projects and understand what different careers truly entail.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🌍</div>
                    <h3>Global Exposure, Neutral Guidance</h3>
                    <p>Experience opportunities both in India and overseas. We provide unbiased, career-first guidance without pushing any specific university or country.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Snapshot Section -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Our Programs</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">🇮🇳</div>
                    <h3>Industry Immersion – India</h3>
                    <p>Work with leading Indian companies across IT, engineering, business, and more. Gain practical skills and understand the Indian job market dynamics.</p>
                    <a href="programs.php#india" class="btn btn-primary mt-2">Learn More</a>
                </div>
                <div class="card">
                    <div class="card-icon">✈️</div>
                    <h3>Overseas Internship Exposure</h3>
                    <p>Experience global work culture and international industry standards. Build a worldwide professional network and enhance your career prospects.</p>
                    <a href="programs.php#overseas" class="btn btn-primary mt-2">Learn More</a>
                </div>
                <div class="card">
                    <div class="card-icon">🎯</div>
                    <h3>Career Counseling & Pathway Planning</h3>
                    <p>One-on-one guidance from experienced career counselors. Map your unique pathway based on your interests, skills, and career goals.</p>
                    <a href="contact.php?type=counseling" class="btn btn-primary mt-2">Book Session</a>
                </div>
                <div class="card">
                    <div class="card-icon">👔</div>
                    <h3>Corporate-Mentored Internship Tracks</h3>
                    <p>Specialized tracks designed with corporate partners. Get mentored by industry veterans and learn skills that employers actually need.</p>
                    <a href="programs.php#corporate" class="btn btn-primary mt-2">View Tracks</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Who Is This For Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Who Is This For?</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">📚</div>
                    <h3>Class 12 Students & Parents</h3>
                    <p>Explore career options before choosing a college major. Make informed decisions about your educational path with real industry exposure.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🎓</div>
                    <h3>Undergraduate Students</h3>
                    <p>Gain practical experience alongside your degree. Build your resume and understand which career path suits you best.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🔄</div>
                    <h3>Career Switch Explorers</h3>
                    <p>Considering a career change? Test the waters with immersion programs before making a major life decision.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🌏</div>
                    <h3>International Students</h3>
                    <p>Seeking India exposure? Experience the dynamic Indian market and build connections with growing industries.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Statement -->
    <section class="section section-gray">
        <div class="container">
            <div class="trust-badge">
                <h3>🛡️ Our Commitment to You</h3>
                <p><strong>We do not promote or push any specific university or country.</strong></p>
                <p>Our guidance is career-first, student-centric, and industry-aligned. We believe in transparent, neutral advice that puts your interests first, always.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section">
        <div class="container text-center">
            <h2>Ready to Start Your Career Journey?</h2>
            <p style="font-size: 1.1rem; max-width: 700px; margin: 1rem auto 2rem;">Join thousands of students who have discovered their true calling through our industry immersion programs.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Get Started Now</a>
                <a href="about.php" class="btn btn-outline">Learn More About Us</a>
            </div>
        </div>
    </section>

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
