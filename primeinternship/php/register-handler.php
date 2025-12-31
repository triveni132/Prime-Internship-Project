<?php
/**
 * PrimeInternship.com - Registration Handler
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../register.php');
}

$type = clean_input($_POST['type']);
$name = clean_input($_POST['name']);
$email = clean_input($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validation
$errors = [];

// Check if passwords match
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match";
}

// Check password length
if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters long";
}

// Check if email already exists
$check_email = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $check_email);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $errors[] = "Email already registered";
}

// If there are errors, redirect back
if (!empty($errors)) {
    $_SESSION['error'] = implode(', ', $errors);
    redirect('../register.php?type=' . $type);
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Begin transaction
mysqli_begin_transaction($conn);

try {
    if ($type === 'student') {
        // Student Registration
        $qualification = clean_input($_POST['qualification']);
        $branch = isset($_POST['branch']) ? clean_input($_POST['branch']) : NULL;
        
        // Insert into users table
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to create user account");
        }
        
        $user_id = mysqli_insert_id($conn);
        
        // Handle resume upload
        $resume_path = NULL;
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['resume'];
            $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (in_array($file['type'], $allowed_types) && $file['size'] <= 5242880) { // 5MB
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = 'resume_' . $user_id . '_' . time() . '.' . $file_extension;
                $upload_path = '../' . RESUME_UPLOAD_DIR . $new_filename;
                
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $resume_path = $new_filename;
                }
            }
        }
        
        // Insert into students table
        $sql = "INSERT INTO students (user_id, qualification, branch, resume) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $user_id, $qualification, $branch, $resume_path);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to create student profile");
        }
        
        mysqli_commit($conn);
        
        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'student';
        $_SESSION['success'] = "Registration successful! Welcome to PrimeInternship.";
        
        redirect('../student-dashboard.php');
        
    } elseif ($type === 'employer') {
        // Employer Registration
        $company_name = clean_input($_POST['company_name']);
        $company_details = clean_input($_POST['company_details']);
        
        // Insert into users table
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'employer')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to create user account");
        }
        
        $user_id = mysqli_insert_id($conn);
        
        // Insert into employers table
        $sql = "INSERT INTO employers (user_id, company_name, company_details) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $company_name, $company_details);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to create employer profile");
        }
        
        mysqli_commit($conn);
        
        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'employer';
        $_SESSION['company_name'] = $company_name;
        $_SESSION['success'] = "Registration successful! Welcome to PrimeInternship.";
        
        redirect('../employer-dashboard.php');
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    $_SESSION['error'] = $e->getMessage();
    redirect('../register.php?type=' . $type);
}
?>
