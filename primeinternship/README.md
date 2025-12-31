# PrimeInternship.com - Industry Immersion & Career Pathway Platform

## 🎯 Project Overview

PrimeInternship.com is a professional web platform designed to connect students with industry immersion opportunities. Unlike traditional job portals, this platform focuses on career clarity through real-world experience before degree commitment.

### Key Features
- ✅ Student Registration & Dashboard
- ✅ Employer Registration & Job Posting
- ✅ Comprehensive Admin Control Panel
- ✅ Job Approval Workflow
- ✅ Qualification & Branch-Based Filtering
- ✅ Resume Upload & Management
- ✅ Application Tracking
- ✅ Contact Form with Inquiry Management
- ✅ Responsive Design (Mobile, Tablet, Desktop)
- ✅ Secure Authentication & Authorization
- ✅ Professional UI with Navy Blue & Gold Theme

---

## 🚀 Quick Start Guide

### Prerequisites
- XAMPP/WAMP/LAMP (PHP 7.4+ and MySQL 5.7+)
- Web browser (Chrome, Firefox, Safari, Edge)
- Text editor (optional, for customization)

### Installation Steps

#### 1. **Download & Extract**
Extract the `primeinternship` folder to your web server directory:
- **XAMPP**: `C:\xampp\htdocs\primeinternship`
- **WAMP**: `C:\wamp64\www\primeinternship`
- **Linux**: `/var/www/html/primeinternship`

#### 2. **Create Database**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click "New" to create a database
3. Name it: `primeinternship_db`
4. Click "Import" tab
5. Choose file: `database.sql`
6. Click "Go" to import

**Alternative Method:**
```sql
-- Run these SQL commands in phpMyAdmin SQL tab
CREATE DATABASE primeinternship_db;
-- Then import the database.sql file
```

#### 3. **Configure Database Connection**
Open `php/config.php` and verify these settings:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Change if you have a password
define('DB_NAME', 'primeinternship_db');
```

#### 4. **Set Permissions**
Ensure the `uploads/resumes/` directory has write permissions:
```bash
chmod 755 uploads/resumes/
```

#### 5. **Access the Platform**
Open your browser and navigate to:
```
http://localhost/primeinternship/
```

---

## 👤 Default Login Credentials

### Admin Account
- **Email**: `admin@primeinternship.com`
- **Password**: `admin123`
- **IMPORTANT**: Change this password after first login!

### 🔧 Login Issues? 
If admin login fails, see **LOGIN_FIX_GUIDE.md** for complete debugging steps, or use the included **admin-reset.php** tool to reset the password.

**Quick Fix**: Access `http://localhost/primeinternship/admin-reset.php` to check and reset admin password.

### Test Accounts (Optional - uncomment in database.sql)
- **Student**: `student@test.com` / `student123`
- **Employer**: `employer@test.com` / `employer123`

---

## 📁 Project Structure

```
primeinternship/
├── assets/
│   └── images/
│       └── logo.png              # Prime Internship Logo
├── css/
│   └── style.css                 # Main stylesheet
├── js/
│   └── main.js                   # JavaScript functionality
├── php/
│   ├── config.php                # Database configuration
│   ├── register-handler.php     # Registration logic
│   ├── login-handler.php        # Login authentication
│   ├── logout.php               # Logout handler
│   ├── apply-job.php            # Job application handler
│   ├── post-job.php             # Job posting handler
│   ├── admin-job-action.php    # Admin job actions
│   ├── admin-user-action.php   # Admin user actions
│   └── contact-handler.php     # Contact form handler
├── uploads/
│   └── resumes/                 # Resume storage directory
├── index.php                    # Home page
├── about.php                    # About us page
├── programs.php                 # Programs page
├── contact.php                  # Contact page
├── register.php                 # Registration page
├── login.php                    # Login page
├── student-dashboard.php        # Student dashboard
├── employer-dashboard.php       # Employer dashboard
├── admin-dashboard.php          # Admin dashboard
├── view-applications.php        # Employer application viewer
├── database.sql                 # Database schema & data
└── README.md                    # This file
```

---

## 🔐 Security Features

1. **Password Hashing**: All passwords are hashed using PHP's `password_hash()` function
2. **SQL Injection Prevention**: Prepared statements used throughout
3. **XSS Protection**: Input sanitization with `htmlspecialchars()`
4. **Session Management**: Secure session-based authentication
5. **Role-Based Access Control**: Separate access levels for students, employers, and admin
6. **File Upload Validation**: Resume uploads restricted to PDF/DOC, max 5MB
7. **CSRF Protection**: Can be enhanced with tokens (recommended for production)

---

## 💼 User Workflows

### Student Workflow
1. Register with qualification and branch details
2. Upload resume (optional)
3. Browse approved internship opportunities matching their qualification
4. Apply for relevant positions
5. Track application status

### Employer Workflow
1. Register with company details
2. Post internship opportunities
3. Wait for admin approval
4. View approved postings
5. Review student applications with resumes

### Admin Workflow
1. Monitor platform statistics
2. Review and approve/reject job postings
3. Manage students and employers (block/unblock)
4. View all applications
5. Handle contact form inquiries

---

## 🎨 Customization Guide

### Changing Colors
Edit `css/style.css` and modify CSS variables:
```css
:root {
    --primary-navy: #1a365d;
    --accent-gold: #d4af37;
    /* Modify these colors */
}
```

### Changing Logo
Replace `assets/images/logo.png` with your logo (maintain transparent background)

### Adding Qualifications
1. Edit the dropdown in `register.php` and `employer-dashboard.php`
2. Update the ENUM in `database.sql`
3. Run ALTER TABLE query:
```sql
ALTER TABLE students MODIFY qualification ENUM('...', 'NewQualification');
ALTER TABLE jobs MODIFY qualification ENUM('...', 'NewQualification');
```

---

## 🌐 Deployment to Live Server

### Steps for Production Deployment

1. **Upload Files**
   - Upload all files via FTP/cPanel File Manager
   - Maintain the directory structure

2. **Create Database**
   - Create MySQL database via cPanel
   - Import `database.sql`

3. **Update Configuration**
   ```php
   // php/config.php
   define('DB_HOST', 'your-server-host');
   define('DB_USER', 'your-db-username');
   define('DB_PASS', 'your-db-password');
   define('DB_NAME', 'your-db-name');
   define('BASE_URL', 'https://yourdomain.com/');
   ```

4. **Set Permissions**
   ```bash
   chmod 755 uploads/resumes/
   ```

5. **SSL Certificate**
   - Install SSL certificate (Let's Encrypt recommended)
   - Update BASE_URL to use HTTPS

6. **Security Hardening**
   - Change default admin password
   - Disable directory browsing
   - Add `.htaccess` security rules
   - Enable error logging (disable display_errors)

### Recommended .htaccess Rules
```apache
# Prevent directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "^(config\.php|database\.sql)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Force HTTPS (if SSL installed)
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🔧 Troubleshooting

### Issue: "Connection failed" error
**Solution**: Check database credentials in `php/config.php`

### Issue: Resume upload not working
**Solution**: 
1. Check folder permissions: `chmod 755 uploads/resumes/`
2. Verify PHP upload settings in `php.ini`:
   ```ini
   upload_max_filesize = 5M
   post_max_size = 6M
   ```

### Issue: Session errors
**Solution**: Ensure PHP session directory has write permissions

### Issue: Logo not displaying
**Solution**: Verify logo.png is in `assets/images/` directory

### Issue: Email not in correct format
**Solution**: Clear browser cache and check email input validation

---

## 📊 Database Schema

### Main Tables
- **users**: Central user authentication
- **students**: Extended student information
- **employers**: Company details
- **jobs**: Internship postings
- **applications**: Job applications
- **inquiries**: Contact form submissions

### Key Relationships
- Users → Students/Employers (1:1)
- Jobs → Users (Many:1)
- Applications → Jobs & Students (Many:1)

---

## 🎯 Features Checklist

- [x] Student Registration with Qualification
- [x] Employer Registration with Company Details
- [x] Admin Dashboard with Full Control
- [x] Job Posting with Admin Approval
- [x] Qualification-Based Job Filtering
- [x] Resume Upload & Download
- [x] Application Tracking System
- [x] Contact Form with Inquiry Types
- [x] Responsive Design
- [x] Secure Authentication
- [x] Role-Based Access Control
- [x] Professional UI Design
- [x] Mobile-Friendly Navigation

---

## 📝 Future Enhancements (Optional)

- Email notifications for applications
- Advanced search and filters
- Student profile editing
- Employer verification system
- Chat/messaging between students and employers
- Analytics and reporting dashboard
- Multi-language support
- API integration for job boards

---

## 🤝 Support & Contact

For technical support or inquiries:
- **Email**: info@primeinternship.com
- **Website**: www.primeinternship.com

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## ✨ Credits

**Developed by**: PrimeInternship Team  
**Version**: 1.0.0  
**Last Updated**: December 2024  
**Built with**: PHP, MySQL, HTML5, CSS3, JavaScript

---

**Note**: This README assumes XAMPP/localhost setup. Adjust paths and configurations according to your environment.
