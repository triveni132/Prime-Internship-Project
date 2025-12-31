<?php
/**
 * PrimeInternship.com - About Us Page
 */
require_once 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - PrimeInternship</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
<link rel="apple-touch-icon" href="assets/images/logo.png">
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>About PrimeInternship</h1>
            <p class="subtitle">Transforming Career Decisions Through Industry Experience</p>
        </div>
    </section>

    <!-- Who We Are -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Who We Are</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <p style="font-size: 1.1rem; line-height: 1.8;">PrimeInternship.com is not your typical job portal or university admission service. We are a career clarity platform that believes in <strong>experience before commitment</strong>.</p>
                
                <h3 class="mt-3">Why Career Decisions Fail Today</h3>
                <div class="card-grid">
                    <div class="card">
                        <h4>❌ Blind Choices</h4>
                        <p>Students choose degrees based on trends, parent pressure, or peer influence—without understanding what the career actually involves.</p>
                    </div>
                    <div class="card">
                        <h4>❌ Expensive Mistakes</h4>
                        <p>Realizing mid-degree or post-graduation that the field isn't for you leads to wasted time, money, and opportunities.</p>
                    </div>
                    <div class="card">
                        <h4>❌ Theory vs Reality Gap</h4>
                        <p>Academic knowledge doesn't always translate to workplace skills, leaving graduates unprepared for actual jobs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Philosophy -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Our Philosophy</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">🔬</div>
                    <h3>Industry Exposure Before Degree Commitment</h3>
                    <p>Try before you buy. Experience different career paths through our immersion programs before investing years and lakhs in education.</p>
                </div>
                <div class="card">
                    <div class="card-icon">⚡</div>
                    <h3>Skills & Experience Over Brand Names</h3>
                    <p>What you can do matters more than where you studied. We focus on building real capabilities that employers value.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🤝</div>
                    <h3>Neutral, Transparent Guidance</h3>
                    <p>No hidden agendas, no commission-based referrals. Our advice is based purely on what's best for your career goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What Makes Us Different -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">What Makes Us Different</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <div class="card mb-2">
                    <h3>✅ NOT a University</h3>
                    <p>We don't sell degrees. We help you figure out if you need one, and if so, which path makes sense for you.</p>
                </div>
                <div class="card mb-2">
                    <h3>✅ NOT an Admission Agent</h3>
                    <p>We don't earn commissions from colleges. Our recommendations are genuinely in your best interest.</p>
                </div>
                <div class="card mb-2">
                    <h3>✅ NOT a Placement Promise Platform</h3>
                    <p>We don't guarantee jobs. We guarantee real experience that makes you genuinely employable.</p>
                </div>
                <div class="card">
                    <h3>✅ Career-First Approach</h3>
                    <p>Everything we do is designed to help you make informed, confident career decisions based on firsthand experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Vision -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Our Global Vision</h2>
            <div style="max-width: 900px; margin: 0 auto; text-align: center;">
                <p style="font-size: 1.1rem; line-height: 1.8;">We envision a world where every student makes career decisions based on <strong>experience, not guesswork</strong>. Where Indian talent competes globally not just on academics, but on practical skills and industry readiness.</p>
                
                <div class="card-grid mt-3">
                    <div class="card">
                        <h3>🇮🇳 India Focus</h3>
                        <p>Connecting students with India's booming industries and startup ecosystem.</p>
                    </div>
                    <div class="card">
                        <h3>🌍 Global Exposure</h3>
                        <p>Opening doors to international opportunities and cross-cultural work experiences.</p>
                    </div>
                    <div class="card">
                        <h3>🎯 Industry Partnership</h3>
                        <p>Working with companies to create meaningful immersion experiences, not just internships.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Statement -->
    <section class="section">
        <div class="container">
            <div class="trust-badge">
                <h3>🛡️ Our Promise</h3>
                <p><strong>We will NEVER push you toward a specific university, country, or degree program based on commissions.</strong></p>
                <p>Every recommendation we make is based on your unique situation, interests, and career goals. Your success is our only metric.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section-gray">
        <div class="container text-center">
            <h2>Ready to Make Informed Career Decisions?</h2>
            <p style="font-size: 1.1rem; margin: 1rem 0 2rem;">Join us in revolutionizing how students approach their careers.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">Get Started</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>
