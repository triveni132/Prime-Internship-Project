<?php
/**
 * PrimeInternship.com - Registration Page
 */
require_once 'php/config.php';

// If already logged in, redirect
if (is_logged_in()) {
    redirect('index.php');
}

$type = isset($_GET['type']) && $_GET['type'] === 'employer' ? 'employer' : 'student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($type); ?> Registration - PrimeInternship</title>
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
                <li><a href="login.php" class="btn btn-primary">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <div class="container">
            <div class="form-container">
                <h2 class="text-center"><?php echo ucfirst($type); ?> Registration</h2>
                <p class="text-center mb-3">Create your account to get started</p>
                
                <!-- Toggle Registration Type -->
                <div class="text-center mb-3">
                    <a href="register.php?type=student" class="btn <?php echo $type === 'student' ? 'btn-primary' : 'btn-outline'; ?>">Student</a>
                    <a href="register.php?type=employer" class="btn <?php echo $type === 'employer' ? 'btn-primary' : 'btn-outline'; ?>">Employer</a>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($type === 'student'): ?>
                    <!-- Student Registration Form -->
                    <form action="php/register-handler.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="student">
                        
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Qualification *</label>
                            <select name="qualification" class="form-control" required>
                                <option value="">Select Qualification</option>
                                <optgroup label="B.Tech">
                                    <option value="BTech-IT">BTech - Information Technology</option>
                                    <option value="BTech-CSE">BTech - Computer Science</option>
                                    <option value="BTech-ECE">BTech - Electronics & Communication</option>
                                    <option value="BTech-Mechanical">BTech - Mechanical</option>
                                    <option value="BTech-Civil">BTech - Civil</option>
                                    <option value="BTech-Other">BTech - Other</option>
                                </optgroup>
                                <optgroup label="Other Degrees">
                                    <option value="BSc">BSc</option>
                                    <option value="BBA">BBA</option>
                                    <option value="BCA">BCA</option>
                                    <option value="MBA">MBA</option>
                                    <option value="MCA">MCA</option>
                                </optgroup>
                                <optgroup label="Class 12th">
                                    <option value="12th-Science">12th - Science</option>
                                    <option value="12th-Arts">12th - Arts</option>
                                    <option value="12th-Commerce">12th - Commerce</option>
                                    <option value="12th-Agriculture">12th - Agriculture</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group branch-field" style="display: none;">
                            <label class="form-label">Branch/Specialization</label>
                            <input type="text" name="branch" class="form-control" placeholder="e.g., Computer Science, Mechanical, etc.">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Resume (PDF/DOC only)</label>
                            <input type="file" name="resume" class="form-control form-file" accept=".pdf,.doc,.docx">
                            <small style="color: #718096;">Max file size: 5MB</small>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Register as Student</button>
                    </form>

                <?php else: ?>
                    <!-- Employer Registration Form -->
                    <form action="php/register-handler.php" method="POST">
                        <input type="hidden" name="type" value="employer">
                        
                        <div class="form-group">
                            <label class="form-label">Contact Person Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Company Description *</label>
                            <textarea name="company_details" class="form-control" required rows="4" placeholder="Tell us about your company..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Register as Employer</button>
                    </form>
                <?php endif; ?>

                <p class="text-center mt-3">
                    Already have an account? <a href="login.php">Login here</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> PrimeInternship.com - All Rights Reserved</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
