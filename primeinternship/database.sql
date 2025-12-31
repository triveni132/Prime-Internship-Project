-- PrimeInternship.com Database Setup
-- Industry Immersion & Career Pathway Platform

-- Create Database
CREATE DATABASE IF NOT EXISTS primeinternship_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE primeinternship_db;

-- Users Table (Main authentication table)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(191) NOT NULL,
    role ENUM('student', 'employer', 'admin') NOT NULL DEFAULT 'student',
    status ENUM('active', 'blocked') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Students Table (Extended student information)
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    qualification ENUM(
        'BTech-IT', 'BTech-CSE', 'BTech-ECE', 'BTech-Mechanical', 'BTech-Civil', 'BTech-Other',
        'BSc', 'BBA', 'BCA', 'MBA', 'MCA',
        '12th-Science', '12th-Arts', '12th-Commerce', '12th-Agriculture'
    ) NOT NULL,
    branch VARCHAR(100) DEFAULT NULL,
    resume VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_qualification (qualification),
    INDEX idx_branch (branch)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employers Table (Company information)
CREATE TABLE IF NOT EXISTS employers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(191) NOT NULL,
    company_details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_company_name (company_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs/Internships Table
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    title VARCHAR(191) NOT NULL,
    description TEXT NOT NULL,
    qualification ENUM(
        'BTech-IT', 'BTech-CSE', 'BTech-ECE', 'BTech-Mechanical', 'BTech-Civil', 'BTech-Other',
        'BSc', 'BBA', 'BCA', 'MBA', 'MCA',
        '12th-Science', '12th-Arts', '12th-Commerce', '12th-Agriculture'
    ) NOT NULL,
    branch VARCHAR(100) DEFAULT NULL,
    location VARCHAR(191),
    duration VARCHAR(100),
    stipend VARCHAR(100),
    skills_required TEXT,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_qualification (qualification),
    INDEX idx_branch (branch)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Applications Table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    student_id INT NOT NULL,
    application_status ENUM('pending', 'shortlisted', 'rejected', 'selected') NOT NULL DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_application (job_id, student_id),
    INDEX idx_job (job_id),
    INDEX idx_student (student_id),
    INDEX idx_status (application_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inquiries Table (Contact form submissions)
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191) NOT NULL,
    email VARCHAR(191) NOT NULL,
    phone VARCHAR(20),
    inquiry_type ENUM(
        'Career Counseling Request',
        'Corporate Partnership Inquiry',
        'Overseas Partner Collaboration',
        'General Inquiry'
    ) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'in_progress', 'resolved') NOT NULL DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_type (inquiry_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Admin Account
-- Password: admin123 (Please change after first login)
-- Hash generated using: password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users (name, email, password, role, status) VALUES 
('Admin', 'admin@primeinternship.com', '$2y$10$7XQ0fhXQqLW9LgBLqKzGLOVGGpH7QkXlhqmPxz0DzoH4cQm5Xz7C2', 'admin', 'active');

-- Sample Data (Optional - for testing)
-- Uncomment below to add sample data

-- Sample Student
-- Password: student123
/*
INSERT INTO users (name, email, password, role, status) VALUES 
('John Doe', 'student@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'active');

INSERT INTO students (user_id, qualification, branch) VALUES 
(LAST_INSERT_ID(), 'BTech-CSE', 'Computer Science');
*/

-- Sample Employer
-- Password: employer123
/*
INSERT INTO users (name, email, password, role, status) VALUES 
('Tech Corp', 'employer@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employer', 'active');

INSERT INTO employers (user_id, company_name, company_details) VALUES 
(LAST_INSERT_ID(), 'Tech Corp Ltd', 'Leading technology company specializing in software development');
*/
