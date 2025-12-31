<?php
/**
 * PrimeInternship.com - Login Page
 */
require_once 'php/config.php';

// If already logged in, redirect
if (is_logged_in()) {
    $role = $_SESSION['role'];
    if ($role === 'admin') {
        redirect('admin-dashboard.php');
    } elseif ($role === 'employer') {
        redirect('employer-dashboard.php');
    } else {
        redirect('student-dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PrimeInternship</title>
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
                <li><a href="register.php" class="btn btn-secondary">Register</a></li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <div class="container">
            <div class="form-container">
                <h2 class="text-center">Login to Your Account</h2>
                <p class="text-center mb-3">Welcome back to PrimeInternship</p>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="php/login-handler.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                </form>

                <p class="text-center mt-3">
                    Don't have an account? <a href="register.php">Register here</a>
                </p>
                
                <div class="text-center mt-2">
                    <small style="color: #718096;">
                        For admin access, please use your admin credentials.<br>
                        Default admin: admin@primeinternship.com | Password: admin123
                    </small>
                </div>
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
