<?php
/**
 * PrimeInternship.com - Employer Dashboard
 */
require_once 'php/config.php';
check_role('employer');

// Fetch employer jobs
$sql = "SELECT j.* FROM jobs j WHERE j.employer_id = ? ORDER BY j.created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$jobs = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - PrimeInternship</title>
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
                <li><a href="employer-dashboard.php" class="nav-link active">Dashboard</a></li>
                <li><span class="nav-link" style="color: var(--accent-gold);">🏢 <?php echo htmlspecialchars($_SESSION['company_name']); ?></span></li>
                <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#post-job" class="sidebar-link active">➕ Post Opportunity</a></li>
                <li><a href="#my-jobs" class="sidebar-link">📋 My Postings</a></li>
                <li><a href="#applications" class="sidebar-link">👥 Applications</a></li>
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
                <h1>Employer Dashboard</h1>
                <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['company_name']); ?></strong></p>
            </div>

            <!-- Post Job Section -->
            <section id="post-job" class="mb-3">
                <h2>Post New Internship Opportunity</h2>
                <div class="card">
                    <form action="php/post-job.php" method="POST">
                        <div class="form-group">
                            <label class="form-label">Position Title *</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., Software Development Intern">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-control" required rows="5" placeholder="Describe the internship role, responsibilities, and learning outcomes..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Required Qualification *</label>
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
                            <label class="form-label">Specific Branch (Optional)</label>
                            <input type="text" name="branch" class="form-control" placeholder="Leave blank for all branches">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control" required placeholder="e.g., Mumbai, Remote, Hybrid">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Duration *</label>
                            <input type="text" name="duration" class="form-control" required placeholder="e.g., 3 months, 6 weeks">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Stipend *</label>
                            <input type="text" name="stipend" class="form-control" required placeholder="e.g., ₹10,000/month, Unpaid">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Skills Required</label>
                            <input type="text" name="skills_required" class="form-control" placeholder="e.g., Python, Communication, MS Excel">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit for Approval</button>
                        <p class="mt-2" style="color: #718096; font-size: 0.875rem;">
                            ℹ️ Your posting will be reviewed by admin before being visible to students
                        </p>
                    </form>
                </div>
            </section>

            <!-- My Jobs Section -->
            <section id="my-jobs" class="mb-3">
                <h2>My Posted Opportunities</h2>
                
                <?php if (mysqli_num_rows($jobs) > 0): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Qualification</th>
                                    <th>Location</th>
                                    <th>Posted On</th>
                                    <th>Status</th>
                                    <th>Applications</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($job = mysqli_fetch_assoc($jobs)): 
                                    // Count applications
                                    $count_sql = "SELECT COUNT(*) as count FROM applications WHERE job_id = ?";
                                    $count_stmt = mysqli_prepare($conn, $count_sql);
                                    mysqli_stmt_bind_param($count_stmt, "i", $job['id']);
                                    mysqli_stmt_execute($count_stmt);
                                    $count_result = mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt));
                                    $app_count = $count_result['count'];
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                                        <td><?php echo htmlspecialchars($job['qualification']); ?></td>
                                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($job['created_at'])); ?></td>
                                        <td>
                                            <?php
                                            $status_class = [
                                                'pending' => 'badge-pending',
                                                'approved' => 'badge-approved',
                                                'rejected' => 'badge-rejected'
                                            ];
                                            ?>
                                            <span class="badge <?php echo $status_class[$job['status']]; ?>">
                                                <?php echo ucfirst($job['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $app_count; ?> applications</td>
                                        <td>
                                            <a href="view-applications.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>You haven't posted any opportunities yet. Use the form above to post your first opportunity!</p>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
