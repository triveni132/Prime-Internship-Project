<?php
/**
 * PrimeInternship.com - View Applications (Employer)
 */
require_once 'php/config.php';
check_role('employer');

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// Verify job belongs to this employer
$sql = "SELECT j.*, u.name as company_name FROM jobs j 
        JOIN users u ON j.employer_id = u.id 
        WHERE j.id = ? AND j.employer_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $job_id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$job = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$job) {
    $_SESSION['error'] = "Job not found or access denied";
    redirect('employer-dashboard.php');
}

// Fetch applications for this job
$sql = "SELECT a.*, u.name, u.email, s.qualification, s.branch, s.resume 
        FROM applications a 
        JOIN users u ON a.student_id = u.id 
        JOIN students s ON u.id = s.user_id 
        WHERE a.job_id = ? 
        ORDER BY a.applied_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $job_id);
mysqli_stmt_execute($stmt);
$applications = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications - PrimeInternship</title>
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="employer-dashboard.php" class="nav-link">← Back to Dashboard</a></li>
                <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <div class="container">
            <div class="dashboard-header">
                <h1>Applications for: <?php echo htmlspecialchars($job['title']); ?></h1>
                <p><strong>Status:</strong> <span class="badge badge-<?php echo $job['status'] === 'approved' ? 'approved' : 'pending'; ?>">
                    <?php echo ucfirst($job['status']); ?>
                </span></p>
                <p><strong>Total Applications:</strong> <?php echo mysqli_num_rows($applications); ?></p>
            </div>

            <?php if (mysqli_num_rows($applications) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Qualification</th>
                                <th>Branch</th>
                                <th>Resume</th>
                                <th>Applied On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($app = mysqli_fetch_assoc($applications)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($app['name']); ?></td>
                                    <td><?php echo htmlspecialchars($app['email']); ?></td>
                                    <td><?php echo htmlspecialchars($app['qualification']); ?></td>
                                    <td><?php echo htmlspecialchars($app['branch'] !== 'N/A'); ?></td>
                                    <td>
                                        <?php if ($app['resume']): ?>
                                            <a href="uploads/resumes/<?php echo htmlspecialchars($app['resume']); ?>" target="_blank" class="btn btn-primary">View Resume</a>
                                        <?php else: ?>
                                            No resume
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($app['applied_at'])); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $app['application_status'] === 'pending' ? 'pending' : 'approved'; ?>">
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
                    <p>No applications received yet for this position.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="js/main.js"></script>
</body>
</html>
