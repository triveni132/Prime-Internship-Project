<?php
/**
 * PrimeInternship.com - Admin Password Reset & Debug Utility
 * 
 * USAGE: Place in root directory and access via browser
 * URL: http://localhost/primeinternship/admin-reset.php
 * 
 * SECURITY: DELETE THIS FILE AFTER USE!
 */

require_once 'php/config.php';

$message = '';
$error = '';

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        // Generate new hash
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update admin password
        $sql = "UPDATE users SET password = ? WHERE email = 'admin@primeinternship.com'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Admin password successfully updated!";
        } else {
            $error = "Failed to update password: " . mysqli_error($conn);
        }
    }
}

// Check admin account status
$sql = "SELECT id, name, email, role, status, password, created_at FROM users WHERE email = 'admin@primeinternship.com'";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

// Test password verification
$test_password = 'admin123';
$password_works = false;
if ($admin && $admin['password']) {
    $password_works = password_verify($test_password, $admin['password']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reset & Debug Tool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #1a365d; margin-bottom: 20px; }
        h2 { color: #2c5282; margin: 30px 0 15px; padding-bottom: 10px; border-bottom: 2px solid #d4af37; }
        .status { padding: 15px; border-radius: 5px; margin: 15px 0; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1a365d; color: white; }
        tr:hover { background: #f5f5f5; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; }
        input[type="password"], input[type="text"] { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { outline: none; border-color: #d4af37; }
        button { background: #1a365d; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        button:hover { background: #2c5282; }
        .code { background: #f4f4f4; padding: 15px; border-left: 4px solid #d4af37; font-family: monospace; overflow-x: auto; margin: 15px 0; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .badge-success { background: #28a745; color: white; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-warning { background: #ffc107; color: #333; }
        .delete-warning { background: #ff4444; color: white; padding: 20px; border-radius: 5px; margin-top: 30px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Admin Password Reset & Debug Utility</h1>
        
        <?php if ($message): ?>
            <div class="status success">✅ <?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="status error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <h2>📊 Current Admin Account Status</h2>
        
        <?php if ($admin): ?>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><strong>ID</strong></td>
                    <td><?php echo $admin['id']; ?></td>
                    <td><span class="badge badge-success">✓ Found</span></td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td><?php echo htmlspecialchars($admin['name']); ?></td>
                    <td><span class="badge badge-success">✓ OK</span></td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                    <td><span class="badge badge-success">✓ OK</span></td>
                </tr>
                <tr>
                    <td><strong>Role</strong></td>
                    <td><?php echo $admin['role']; ?></td>
                    <td><?php echo $admin['role'] === 'admin' ? '<span class="badge badge-success">✓ Admin</span>' : '<span class="badge badge-danger">✗ Wrong Role</span>'; ?></td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td><?php echo $admin['status']; ?></td>
                    <td><?php echo $admin['status'] === 'active' ? '<span class="badge badge-success">✓ Active</span>' : '<span class="badge badge-danger">✗ Blocked</span>'; ?></td>
                </tr>
                <tr>
                    <td><strong>Password Hash</strong></td>
                    <td><code><?php echo substr($admin['password'], 0, 40); ?>...</code></td>
                    <td><?php echo $password_works ? '<span class="badge badge-success">✓ Valid</span>' : '<span class="badge badge-danger">✗ Invalid</span>'; ?></td>
                </tr>
                <tr>
                    <td><strong>Created</strong></td>
                    <td><?php echo $admin['created_at']; ?></td>
                    <td><span class="badge badge-success">✓ OK</span></td>
                </tr>
            </table>

            <h2>🔐 Password Verification Test</h2>
            <div class="status <?php echo $password_works ? 'success' : 'error'; ?>">
                <?php if ($password_works): ?>
                    ✅ <strong>SUCCESS:</strong> Current password "admin123" works correctly!
                <?php else: ?>
                    ❌ <strong>FAILED:</strong> Current password "admin123" does NOT work!<br>
                    <small>This means the password hash in the database is incorrect.</small>
                <?php endif; ?>
            </div>

            <?php if (!$password_works): ?>
                <div class="status warning">
                    ⚠️ <strong>Issue Detected:</strong> The password hash doesn't match "admin123". Use the form below to reset it.
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="status error">
                ❌ <strong>CRITICAL ERROR:</strong> Admin account not found in database!<br>
                <small>The admin user does not exist. You need to import database.sql again.</small>
            </div>
        <?php endif; ?>

        <h2>🔄 Reset Admin Password</h2>
        <form method="POST">
            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="new_password" required minlength="6" placeholder="Enter new password (min 6 characters)">
            </div>
            
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required minlength="6" placeholder="Confirm new password">
            </div>
            
            <button type="submit" name="reset_password">🔄 Reset Admin Password</button>
        </form>

        <h2>🧪 Quick Test Login</h2>
        <div class="status info">
            After resetting the password, test login here:<br>
            <a href="login.php" style="color: #0c5460; font-weight: bold;">→ Go to Login Page</a>
        </div>

        <h2>📝 Manual SQL Fix (Alternative)</h2>
        <p>If you prefer to fix manually in phpMyAdmin, run this SQL:</p>
        <div class="code">
UPDATE users <br>
SET password = '$2y$10$7XQ0fhXQqLW9LgBLqKzGLOVGGpH7QkXlhqmPxz0DzoH4cQm5Xz7C2' <br>
WHERE email = 'admin@primeinternship.com';
        </div>
        <p><small>This sets the password to: <strong>admin123</strong></small></p>

        <h2>🔍 Debugging Checklist</h2>
        <table>
            <tr>
                <th>Check</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Database Connection</td>
                <td><span class="badge badge-success">✓ Connected</span></td>
                <td>-</td>
            </tr>
            <tr>
                <td>Admin Account Exists</td>
                <td><?php echo $admin ? '<span class="badge badge-success">✓ Found</span>' : '<span class="badge badge-danger">✗ Missing</span>'; ?></td>
                <td><?php echo $admin ? '-' : 'Re-import database.sql'; ?></td>
            </tr>
            <tr>
                <td>Password Hash Valid</td>
                <td><?php echo $password_works ? '<span class="badge badge-success">✓ Valid</span>' : '<span class="badge badge-danger">✗ Invalid</span>'; ?></td>
                <td><?php echo $password_works ? '-' : 'Use reset form above'; ?></td>
            </tr>
            <tr>
                <td>Account Active</td>
                <td><?php echo $admin && $admin['status'] === 'active' ? '<span class="badge badge-success">✓ Active</span>' : '<span class="badge badge-danger">✗ Blocked</span>'; ?></td>
                <td><?php echo $admin && $admin['status'] === 'active' ? '-' : 'Unblock in database'; ?></td>
            </tr>
            <tr>
                <td>Session Working</td>
                <td><?php echo session_status() === PHP_SESSION_ACTIVE ? '<span class="badge badge-success">✓ Active</span>' : '<span class="badge badge-danger">✗ Failed</span>'; ?></td>
                <td><?php echo session_status() === PHP_SESSION_ACTIVE ? '-' : 'Check PHP session config'; ?></td>
            </tr>
        </table>

        <div class="delete-warning">
            ⚠️ SECURITY WARNING: DELETE THIS FILE (admin-reset.php) AFTER FIXING THE ISSUE!
        </div>
    </div>
</body>
</html>
