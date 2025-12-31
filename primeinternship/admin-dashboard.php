<?php
/**
 * PrimeInternship.com - Admin Dashboard
 */
require_once 'php/config.php';
check_role('admin');

// Fetch statistics
$stats = [];

// Total users
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role != 'admin'");
$stats['total_users'] = mysqli_fetch_assoc($result)['count'];

// Total students
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'student'");
$stats['total_students'] = mysqli_fetch_assoc($result)['count'];

// Total employers
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'employer'");
$stats['total_employers'] = mysqli_fetch_assoc($result)['count'];

// Pending jobs
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'pending'");
$stats['pending_jobs'] = mysqli_fetch_assoc($result)['count'];

// Approved jobs
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM jobs WHERE status = 'approved'");
$stats['approved_jobs'] = mysqli_fetch_assoc($result)['count'];

// Total applications
$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications");
$stats['total_applications'] = mysqli_fetch_assoc($result)['count'];

// Fetch pending jobs for approval
$pending_jobs = mysqli_query($conn, "SELECT j.*, u.name as company_name, e.company_details 
                                      FROM jobs j 
                                      JOIN users u ON j.employer_id = u.id 
                                      JOIN employers e ON u.id = e.user_id 
                                      WHERE j.status = 'pending' 
                                      ORDER BY j.created_at DESC");

// Fetch all jobs
$all_jobs = mysqli_query($conn, "SELECT j.*, u.name as company_name 
                                  FROM jobs j 
                                  JOIN users u ON j.employer_id = u.id 
                                  ORDER BY j.created_at DESC");

// Fetch all students
$all_students = mysqli_query($conn, "SELECT u.*, s.qualification, s.branch, s.resume 
                                      FROM users u 
                                      LEFT JOIN students s ON u.id = s.user_id 
                                      WHERE u.role = 'student' 
                                      ORDER BY u.created_at DESC");

// Fetch all employers
$all_employers = mysqli_query($conn, "SELECT u.*, e.company_name, e.company_details 
                                       FROM users u 
                                       LEFT JOIN employers e ON u.id = e.user_id 
                                       WHERE u.role = 'employer' 
                                       ORDER BY u.created_at DESC");

// Fetch inquiries
$inquiries = mysqli_query($conn, "SELECT * FROM inquiries ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PrimeInternship</title>
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
                <li><a href="admin-dashboard.php" class="nav-link active">Admin Dashboard</a></li>
                <li><span class="nav-link" style="color: var(--accent-gold);">⚡ Admin</span></li>
                <li><a href="php/logout.php" class="btn btn-danger">Logout</a></li>
            </ul>
            <button class="mobile-menu-toggle">☰</button>
        </nav>
    </header>

    <div class="dashboard">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#overview" class="sidebar-link active">📊 Overview</a></li>
                <li><a href="#pending-jobs" class="sidebar-link">⏳ Pending Jobs (<?php echo $stats['pending_jobs']; ?>)</a></li>
                <li><a href="#all-jobs" class="sidebar-link">📋 All Jobs</a></li>
                <li><a href="#students" class="sidebar-link">👨‍🎓 Students</a></li>
                <li><a href="#employers" class="sidebar-link">🏢 Employers</a></li>
                <li><a href="#inquiries" class="sidebar-link">📧 Inquiries</a></li>
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
                <h1>Admin Dashboard</h1>
                <p>Complete control & management system</p>
            </div>

            <!-- Overview Section -->
            <section id="overview" class="mb-3">
                <h2>Platform Overview</h2>
                <div class="card-grid">
                    <div class="card">
                        <div class="card-icon">👥</div>
                        <h3><?php echo $stats['total_users']; ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">👨‍🎓</div>
                        <h3><?php echo $stats['total_students']; ?></h3>
                        <p>Students</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">🏢</div>
                        <h3><?php echo $stats['total_employers']; ?></h3>
                        <p>Employers</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">⏳</div>
                        <h3><?php echo $stats['pending_jobs']; ?></h3>
                        <p>Pending Jobs</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">✅</div>
                        <h3><?php echo $stats['approved_jobs']; ?></h3>
                        <p>Approved Jobs</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">📝</div>
                        <h3><?php echo $stats['total_applications']; ?></h3>
                        <p>Total Applications</p>
                    </div>
                </div>
            </section>

            <!-- Pending Jobs Section -->
            <section id="pending-jobs" class="mb-3">
                <h2>Pending Job Approvals (<?php echo $stats['pending_jobs']; ?>)</h2>
                
                <?php if (mysqli_num_rows($pending_jobs) > 0): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company</th>
                                    <th>Title</th>
                                    <th>Qualification</th>
                                    <th>Location</th>
                                    <th>Posted On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($job = mysqli_fetch_assoc($pending_jobs)): ?>
                                    <tr>
                                        <td><?php echo $job['id']; ?></td>
                                        <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                                        <td><?php echo htmlspecialchars($job['qualification']); ?></td>
                                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($job['created_at'])); ?></td>
                                        <td>
                                            <form action="php/admin-job-action.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                            <form action="php/admin-job-action.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to reject this job posting?">Reject</button>
                                            </form>
                                           <!-- <a href="view-job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">Details</a>-->
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>No pending job approvals at the moment.</p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- All Jobs Section -->
            <section id="all-jobs" class="mb-3">
                <h2>All Job Postings</h2>
                <input type="text" class="form-control table-search mb-2" placeholder="Search jobs...">
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Title</th>
                                <th>Qualification</th>
                                <th>Status</th>
                                <th>Applications</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($job = mysqli_fetch_assoc($all_jobs)): 
                                $count_sql = "SELECT COUNT(*) as count FROM applications WHERE job_id = ?";
                                $count_stmt = mysqli_prepare($conn, $count_sql);
                                mysqli_stmt_bind_param($count_stmt, "i", $job['id']);
                                mysqli_stmt_execute($count_stmt);
                                $app_count = mysqli_fetch_assoc(mysqli_stmt_get_result($count_stmt))['count'];
                            ?>
                                <tr>
                                    <td><?php echo $job['id']; ?></td>
                                    <td><?php echo htmlspecialchars($job['company_name']); ?></td>
                                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                                    <td><?php echo htmlspecialchars($job['qualification']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $job['status'] === 'approved' ? 'approved' : ($job['status'] === 'rejected' ? 'rejected' : 'pending'); ?>">
                                            <?php echo ucfirst($job['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $app_count; ?></td>
                                    <td>
                                        <form action="php/admin-job-action.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-danger" data-confirm="Are you sure you want to delete this job posting?">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Students Section -->
            <section id="students" class="mb-3">
                <h2>All Students (<?php echo $stats['total_students']; ?>)</h2>
                <input type="text" class="form-control table-search mb-2" placeholder="Search students...">
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Qualification</th>
                                <th>Branch</th>
                                <th>Resume</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($student = mysqli_fetch_assoc($all_students)): ?>
                                <tr>
                                    <td><?php echo $student['id']; ?></td>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td>
    <?php echo htmlspecialchars(isset($student['qualification']) && $student['qualification'] !== '' ? $student['qualification'] : 'N/A'); ?>
</td>
<td>
    <?php echo htmlspecialchars(isset($student['branch']) && $student['branch'] !== '' ? $student['branch'] : 'N/A'); ?>
</td>
<td>
                                        <?php if ($student['resume']): ?>
                                            <a href="uploads/resumes/<?php echo htmlspecialchars($student['resume']); ?>" target="_blank" class="btn btn-primary">View</a>
                                        <?php else: ?>
                                            No resume
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $student['status'] === 'active' ? 'approved' : 'rejected'; ?>">
                                            <?php echo ucfirst($student['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="php/admin-user-action.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $student['id']; ?>">
                                            <input type="hidden" name="action" value="<?php echo $student['status'] === 'active' ? 'block' : 'unblock'; ?>">
                                            <button type="submit" class="btn <?php echo $student['status'] === 'active' ? 'btn-warning' : 'btn-success'; ?>">
                                                <?php echo $student['status'] === 'active' ? 'Block' : 'Unblock'; ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Employers Section -->
            <section id="employers" class="mb-3">
                <h2>All Employers (<?php echo $stats['total_employers']; ?>)</h2>
                <input type="text" class="form-control table-search mb-2" placeholder="Search employers...">
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contact Person</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($employer = mysqli_fetch_assoc($all_employers)): ?>
                                <tr>
                                    <td><?php echo $employer['id']; ?></td>
                                    <td><?php echo htmlspecialchars($employer['name']); ?></td>
                                    <td><?php echo htmlspecialchars($employer['company_name'] !== 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($employer['email']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $employer['status'] === 'active' ? 'approved' : 'rejected'; ?>">
                                            <?php echo ucfirst($employer['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="php/admin-user-action.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $employer['id']; ?>">
                                            <input type="hidden" name="action" value="<?php echo $employer['status'] === 'active' ? 'block' : 'unblock'; ?>">
                                            <button type="submit" class="btn <?php echo $employer['status'] === 'active' ? 'btn-warning' : 'btn-success'; ?>">
                                                <?php echo $employer['status'] === 'active' ? 'Block' : 'Unblock'; ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Inquiries Section -->
            <section id="inquiries">
                <h2>Contact Form Inquiries</h2>
                
                <?php if (mysqli_num_rows($inquiries) > 0): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($inquiry = mysqli_fetch_assoc($inquiries)): ?>
                                    <tr>
                                        <td><?php echo $inquiry['id']; ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['name']); ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['email']); ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['inquiry_type']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($inquiry['message'], 0, 50)) . '...'; ?></td>
                                        <td><?php echo date('d M Y', strtotime($inquiry['created_at'])); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo $inquiry['status'] === 'new' ? 'pending' : 'approved'; ?>">
                                                <?php echo ucfirst($inquiry['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>No inquiries received yet.</p>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
