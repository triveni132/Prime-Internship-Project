# INSTALLATION GUIDE
## PrimeInternship.com - Complete Setup Instructions

---

## 📋 Table of Contents
1. System Requirements
2. Local Development Setup (XAMPP)
3. Database Configuration
4. Testing the Application
5. Production Deployment
6. Common Issues & Solutions

---

## 1. SYSTEM REQUIREMENTS

### Minimum Requirements
- **Web Server**: Apache 2.4+
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Browser**: Modern browser (Chrome, Firefox, Safari, Edge)
- **Disk Space**: 50 MB minimum
- **RAM**: 512 MB minimum

### Recommended Software
- **XAMPP**: 8.0+ (includes Apache, PHP, MySQL)
- **Alternative**: WAMP, LAMP, or MAMP

---

## 2. LOCAL DEVELOPMENT SETUP (XAMPP)

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP to default location (C:\xampp on Windows)
3. Start XAMPP Control Panel
4. Start "Apache" and "MySQL" modules

### Step 2: Extract Project Files
1. Extract the primeinternship folder
2. Copy it to: `C:\xampp\htdocs\primeinternship`
3. Verify folder structure:
   ```
   C:\xampp\htdocs\primeinternship\
   ├── assets/
   ├── css/
   ├── js/
   ├── php/
   ├── uploads/
   ├── index.php
   └── database.sql
   ```

### Step 3: Set Folder Permissions
**Windows**: Right-click `uploads/resumes` → Properties → Security → Edit → Add write permissions

**Linux/Mac**:
```bash
chmod 755 uploads/resumes/
chmod 644 php/config.php
```

---

## 3. DATABASE CONFIGURATION

### Method 1: Using phpMyAdmin (Recommended)

1. **Access phpMyAdmin**
   - Open browser: `http://localhost/phpmyadmin`
   - Username: `root`
   - Password: (leave blank by default)

2. **Create Database**
   - Click "New" in left sidebar
   - Database name: `primeinternship_db`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

3. **Import Tables**
   - Select `primeinternship_db` database
   - Click "Import" tab
   - Click "Choose File"
   - Select `database.sql` from project folder
   - Click "Go" at bottom
   - Wait for "Import has been successfully finished" message

4. **Verify Import**
   - Click on `primeinternship_db`
   - You should see these tables:
     - users
     - students
     - employers
     - jobs
     - applications
     - inquiries

### Method 2: Using MySQL Command Line

```bash
# Open MySQL command line
mysql -u root -p

# Create database
CREATE DATABASE primeinternship_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Exit MySQL
exit;

# Import SQL file
mysql -u root -p primeinternship_db < C:\xampp\htdocs\primeinternship\database.sql
```

### Configure Database Connection

1. Open `php/config.php` in text editor
2. Verify these settings:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Add your MySQL password if set
define('DB_NAME', 'primeinternship_db');
```

3. **If using custom MySQL password**:
```php
define('DB_PASS', 'your_mysql_password');
```

---

## 4. TESTING THE APPLICATION

### Step 1: Access Homepage
1. Open browser
2. Navigate to: `http://localhost/primeinternship/`
3. You should see the PrimeInternship homepage

### Step 2: Test Admin Login
1. Click "Login" button
2. Enter credentials:
   - **Email**: `admin@primeinternship.com`
   - **Password**: `admin123`
3. Click "Login"
4. You should be redirected to Admin Dashboard

### Step 3: Test Student Registration
1. Logout from admin
2. Click "Register" → Select "Student"
3. Fill in the form:
   - Name: Test Student
   - Email: student@test.com
   - Password: test123
   - Qualification: BTech-CSE
   - Branch: Computer Science
4. Upload a sample resume (PDF)
5. Click "Register"
6. You should see Student Dashboard

### Step 4: Test Employer Registration
1. Logout
2. Click "Register" → Select "Employer"
3. Fill in the form:
   - Name: Test Company Representative
   - Company Name: Tech Corp
   - Email: employer@test.com
   - Password: test123
   - Description: Sample tech company
4. Click "Register"
5. You should see Employer Dashboard

### Step 5: Test Job Posting Flow
1. As Employer, post a new internship
2. Login as Admin
3. Go to "Pending Jobs" section
4. Approve the job posting
5. Logout and login as Student
6. You should see the approved job
7. Click "Apply Now"
8. Verify application appears in "My Applications"

### Step 6: Test Contact Form
1. Navigate to Contact page
2. Fill in the form
3. Submit
4. Login as Admin
5. Check "Inquiries" section
6. Verify inquiry is recorded

---

## 5. PRODUCTION DEPLOYMENT

### For cPanel Hosting

#### Step 1: Upload Files
1. Login to cPanel
2. Open "File Manager"
3. Navigate to `public_html` directory
4. Upload primeinternship folder
5. Extract if uploaded as ZIP

#### Step 2: Create Database
1. In cPanel, open "MySQL Databases"
2. Create new database: `username_primeinternship`
3. Create MySQL user with strong password
4. Add user to database with ALL PRIVILEGES
5. Note down:
   - Database name
   - Database username
   - Database password

#### Step 3: Import Database
1. Open phpMyAdmin from cPanel
2. Select your database
3. Click "Import"
4. Upload `database.sql`
5. Click "Go"

#### Step 4: Update Configuration
1. Edit `php/config.php`:
```php
define('DB_HOST', 'localhost');  // Usually localhost
define('DB_USER', 'username_dbuser');
define('DB_PASS', 'your_secure_password');
define('DB_NAME', 'username_primeinternship');
define('BASE_URL', 'https://yourdomain.com/');
```

#### Step 5: Set Permissions
1. Set `uploads/resumes/` to 755
2. Set `php/config.php` to 644

#### Step 6: Install SSL Certificate
1. In cPanel, go to "SSL/TLS Status"
2. Install Let's Encrypt SSL (free)
3. Enable "Force HTTPS Redirect"

#### Step 7: Update .htaccess
Uncomment HTTPS redirect lines in `.htaccess`:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

#### Step 8: Security Checklist
- [ ] Change default admin password
- [ ] Remove test accounts
- [ ] Disable PHP error display
- [ ] Enable PHP error logging
- [ ] Set secure file permissions
- [ ] Configure backup system
- [ ] Add CAPTCHA to contact form (recommended)

---

## 6. COMMON ISSUES & SOLUTIONS

### Issue: "Connection failed" Error

**Cause**: Incorrect database credentials

**Solution**:
1. Verify database exists in phpMyAdmin
2. Check credentials in `php/config.php`
3. Ensure MySQL service is running

### Issue: Blank Page After Login

**Cause**: PHP errors or session issues

**Solution**:
1. Enable error reporting temporarily:
   ```php
   // Add to top of config.php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```
2. Check if sessions folder has write permissions
3. Clear browser cookies and cache

### Issue: Resume Upload Not Working

**Cause**: Folder permissions or PHP settings

**Solution**:
1. Check folder permissions: `chmod 755 uploads/resumes/`
2. Verify PHP settings in `php.ini`:
   ```ini
   upload_max_filesize = 5M
   post_max_size = 6M
   file_uploads = On
   ```
3. Restart Apache after changes

### Issue: Logo Not Displaying

**Cause**: Incorrect path or missing file

**Solution**:
1. Verify logo.png exists in `assets/images/`
2. Check file permissions (644)
3. Clear browser cache
4. Check browser console for 404 errors

### Issue: CSS Not Loading

**Cause**: Incorrect paths or server configuration

**Solution**:
1. Verify `css/style.css` exists
2. Check path in HTML: `/primeinternship/css/style.css`
3. Clear browser cache
4. Check .htaccess file

### Issue: Email Validation Not Working

**Cause**: JavaScript errors

**Solution**:
1. Check browser console for errors
2. Verify `js/main.js` is loaded
3. Ensure jQuery/JavaScript is enabled

### Issue: 404 Error on All Pages

**Cause**: Apache mod_rewrite not enabled

**Solution**:
1. Enable mod_rewrite in Apache
2. Check .htaccess is present
3. Verify AllowOverride in Apache config

---

## 🔍 VERIFICATION CHECKLIST

After installation, verify these items:

- [ ] Homepage loads correctly
- [ ] Logo displays properly
- [ ] All navigation links work
- [ ] Admin can login
- [ ] Student registration works
- [ ] Employer registration works
- [ ] Job posting works
- [ ] Admin can approve jobs
- [ ] Students can apply for jobs
- [ ] Resume upload works
- [ ] Contact form works
- [ ] Responsive design works on mobile
- [ ] All CSS styles load
- [ ] JavaScript functions work

---

## 📞 SUPPORT

If you encounter issues not covered in this guide:

1. Check PHP error logs: `xampp/php/logs/php_error_log`
2. Check Apache error logs: `xampp/apache/logs/error.log`
3. Enable error reporting temporarily for debugging
4. Clear all caches (browser, PHP, server)
5. Contact support: info@primeinternship.com

---

## 📝 NOTES

- Always backup database before making changes
- Keep PHP and MySQL updated
- Change default passwords immediately
- Use strong passwords in production
- Regular security audits recommended
- Keep file permissions secure
- Monitor error logs regularly

---

**Installation Guide Version**: 1.0  
**Last Updated**: December 2024  
**Compatible With**: PHP 7.4+, MySQL 5.7+
