<?php
/**
 * PrimeInternship.com - Student Dashboard
 */
require_once 'php/config.php';
check_role('student');

// Fetch student details
$sql = "SELECT s.*, u.name, u.email FROM students s 
        JOIN users u ON s.user_id = u.id 
        WHERE s.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$student = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Fetch approved jobs matching student's qualification
$qualification = $student['qualification'];
$branch = $student['branch'];

$sql = "SELECT j.*, u.name as company_name, e.company_details 
        FROM jobs j 
        JOIN users u ON j.employer_id = u.id 
        JOIN employers e ON u.id = e.user_id 
        WHERE j.status = 'approved' 
        AND j.qualification = ? 
        AND (j.branch IS NULL OR j.branch = '' OR j.branch = ?)
        ORDER BY j.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $qualification, $branch);
mysqli_stmt_execute($stmt);
$jobs = mysqli_stmt_get_result($stmt);

// Fetch student's applications
$sql = "SELECT a.*, j.title, j.location, u.name as company_name 
        FROM applications a 
        JOIN jobs j ON a.job_id = j.id 
        JOIN users u ON j.employer_id = u.id 
        WHERE a.student_id = ? 
        ORDER BY a.applied_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$applications = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - PrimeInternship</title>
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
                <li><a href="student-dashboard.php" class="nav-link active">Dashboard</a></li>
                <li><span class="nav-link" style="color: var(--accent-gold);">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></span></li>
                <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#available-jobs" class="sidebar-link active">📋 Available Opportunities</a></li>
                <li><a href="#my-applications" class="sidebar-link">📝 My Applications</a></li>
                <li><a href="#profile" class="sidebar-link">👤 My Profile</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
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

            <div class="dashboard-header">
                <h1>Welcome, <?php echo htmlspecialchars($student['name']); ?>! 👋</h1>
                <p>Qualification: <strong><?php echo htmlspecialchars($student['qualification']); ?></strong> 
                <?php if ($student['branch']): ?>
                    | Branch: <strong><?php echo htmlspecialchars($student['branch']); ?></strong>
                <?php endif; ?>
                </p>
            </div>

            <!-- Available Jobs Section -->
            <section id="available-jobs" class="mb-3">
                <h2>Available Internship Opportunities</h2>
                <p class="mb-2">Showing opportunities matching your qualification</p>

                <?php if (mysqli_num_rows($jobs) > 0): ?>
                    <div class="card-grid">
                        <?php while ($job = mysqli_fetch_assoc($jobs)): 
                            // Check if already applied
                            $check_sql = "SELECT id FROM applications WHERE job_id = ? AND student_id = ?";
                            $check_stmt = mysqli_prepare($conn, $check_sql);
                            mysqli_stmt_bind_param($check_stmt, "ii", $job['id'], $_SESSION['user_id']);
                            mysqli_stmt_execute($check_stmt);
                            $already_applied = mysqli_num_rows(mysqli_stmt_get_result($check_stmt)) > 0;
                        ?>
                            <div class="card">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><strong>🏢 <?php echo htmlspecialchars($job['company_name']); ?></strong></p>
                                <p><?php echo htmlspecialchars(substr($job['description'], 0, 150)); ?>...</p>
                                
                                <div style="margin-top: 1rem;">
                                    <p><strong>📍 Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                                    <p><strong>⏰ Duration:</strong> <?php echo htmlspecialchars($job['duration']); ?></p>
                                    <p><strong>💰 Stipend:</strong> <?php echo htmlspecialchars($job['stipend']); ?></p>
                                    <?php if ($job['skills_required']): ?>
                                        <p><strong>🎯 Skills:</strong> <?php echo htmlspecialchars($job['skills_required']); ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if ($already_applied): ?>
                                    <button class="btn btn-success mt-2" disabled>✓ Applied</button>
                                <?php else: ?>
                                    <form action="php/apply-job.php" method="POST" style="margin-top: 1rem;">
                                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Now</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>No internship opportunities available for your qualification at the moment. Please check back later!</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- My Applications Section -->
            <section id="my-applications" class="mb-3">
                <h2>My Applications</h2>
                
                <?php if (mysqli_num_rows($applications) > 0): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Position</th>
                                    <th>Location</th>
                                    <th>Applied On</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($app = mysqli_fetch_assoc($applications)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($app['company_name']); ?></td>
                                        <td><?php echo htmlspecialchars($app['title']); ?></td>
                                        <td><?php echo htmlspecialchars($app['location']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($app['applied_at'])); ?></td>
                                        <td>
                                            <?php
                                            $status_class = [
                                                'pending' => 'badge-pending',
                                                'shortlisted' => 'badge-approved',
                                                'rejected' => 'badge-rejected',
                                                'selected' => 'badge-approved'
                                            ];
                                            ?>
                                            <span class="badge <?php echo $status_class[$app['application_status']]; ?>">
                                                <?php echo ucfirst($app['application_status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>You haven't applied to any opportunities yet. Browse available opportunities above!</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Profile Section -->
            <section id="profile">
                <h2>My Profile</h2>
                <div class="card">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                    <p><strong>Qualification:</strong> <?php echo htmlspecialchars($student['qualification']); ?></p>
                    <?php if ($student['branch']): ?>
                        <p><strong>Branch:</strong> <?php echo htmlspecialchars($student['branch']); ?></p>
                    <?php endif; ?>
                    <?php if ($student['resume']): ?>
                        <p><strong>Resume:</strong> <a href="uploads/resumes/<?php echo htmlspecialchars($student['resume']); ?>" target="_blank" class="btn btn-primary">View Resume</a></p>
                    <?php else: ?>
                        <p><strong>Resume:</strong> Not uploaded</p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
