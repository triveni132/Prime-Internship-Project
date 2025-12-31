# 🚀 DEPLOYMENT CHECKLIST
## PrimeInternship.com - Production Deployment Guide

---

## ✅ PRE-DEPLOYMENT CHECKLIST

### 1. Security Configuration
- [ ] Change default admin password from `admin123`
- [ ] Update `php/config.php` with production database credentials
- [ ] Set strong database password
- [ ] Remove any test accounts from database
- [ ] Enable HTTPS redirect in `.htaccess`
- [ ] Set correct file permissions (755 for directories, 644 for files)
- [ ] Disable PHP error display (`display_errors = Off`)
- [ ] Enable PHP error logging (`log_errors = On`)
- [ ] Review and secure `.htaccess` rules

### 2. Database Setup
- [ ] Create production database
- [ ] Import `database.sql`
- [ ] Verify all tables created successfully
- [ ] Update admin password in database
- [ ] Remove test data (if any)
- [ ] Set up database backups
- [ ] Configure database user with minimum required privileges

### 3. File Configuration
- [ ] Update `BASE_URL` in `php/config.php`
- [ ] Verify logo is present in `assets/images/`
- [ ] Check all file paths are relative
- [ ] Test resume upload directory permissions
- [ ] Remove any development files
- [ ] Compress CSS and JS files (optional)

### 4. Server Configuration
- [ ] Install SSL certificate
- [ ] Configure domain DNS
- [ ] Set up email for contact forms
- [ ] Configure PHP settings (upload limits, execution time)
- [ ] Enable mod_rewrite (Apache)
- [ ] Set up cron jobs for maintenance (optional)
- [ ] Configure server caching

---

## 🔒 SECURITY HARDENING

### Essential Security Steps
```bash
# Set directory permissions
chmod 755 uploads/resumes/
chmod 644 php/config.php
chmod 644 .htaccess

# Protect sensitive files
# Add to .htaccess:
<FilesMatch "^(config\.php|database\.sql)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### PHP Configuration
```ini
# In php.ini or .htaccess:
display_errors = Off
log_errors = On
upload_max_filesize = 5M
post_max_size = 6M
max_execution_time = 300
session.cookie_httponly = On
session.cookie_secure = On  # If using HTTPS
```

### Database Security
```sql
-- Create dedicated database user
CREATE USER 'pi_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';
GRANT SELECT, INSERT, UPDATE, DELETE ON primeinternship_db.* TO 'pi_user'@'localhost';
FLUSH PRIVILEGES;
```

---

## 📝 PRODUCTION CONFIGURATION

### Update php/config.php
```php
<?php
// Production Database Settings
define('DB_HOST', 'localhost');  // or your DB host
define('DB_USER', 'pi_user');
define('DB_PASS', 'YOUR_STRONG_PASSWORD');
define('DB_NAME', 'primeinternship_db');
define('BASE_URL', 'https://yourdomain.com/');

// Error Reporting (Production)
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php_errors.log');
?>
```

### Update .htaccess (Enable HTTPS)
```apache
# Uncomment these lines:
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🧪 TESTING CHECKLIST

### Functionality Testing
- [ ] Homepage loads correctly
- [ ] All navigation links work
- [ ] Logo displays and links to home
- [ ] Student registration works
- [ ] Employer registration works
- [ ] Login/logout functionality works
- [ ] Admin can approve/reject jobs
- [ ] Job posting works
- [ ] Job application works
- [ ] Resume upload works
- [ ] Contact form submits successfully
- [ ] Email notifications work (if configured)

### Security Testing
- [ ] SQL injection attempts fail
- [ ] XSS attempts are sanitized
- [ ] Direct file access is blocked
- [ ] Session hijacking prevented
- [ ] HTTPS is enforced
- [ ] Unauthorized access blocked
- [ ] File upload restrictions work

### Performance Testing
- [ ] Page load time < 3 seconds
- [ ] Mobile responsive design works
- [ ] Images are optimized
- [ ] CSS/JS files load correctly
- [ ] Database queries are optimized

### Browser Testing
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🌐 DOMAIN & HOSTING SETUP

### DNS Configuration
```
A Record: @ → Your Server IP
CNAME: www → yourdomain.com
```

### SSL Certificate (Let's Encrypt)
```bash
# Using Certbot (if available)
certbot --apache -d yourdomain.com -d www.yourdomain.com

# Or use cPanel AutoSSL
# Or manual SSL certificate installation
```

---

## 📊 MONITORING & MAINTENANCE

### Daily Tasks
- [ ] Check error logs
- [ ] Monitor server resources
- [ ] Review new user registrations

### Weekly Tasks
- [ ] Backup database
- [ ] Review pending job approvals
- [ ] Check contact form inquiries
- [ ] Monitor application volume

### Monthly Tasks
- [ ] Update PHP and MySQL (if needed)
- [ ] Review security logs
- [ ] Optimize database
- [ ] Clear old log files
- [ ] Test backup restoration

---

## 🔧 POST-DEPLOYMENT

### Immediate Actions
1. Test all functionality end-to-end
2. Register test student account
3. Register test employer account
4. Post and approve test job
5. Submit test application
6. Test contact form
7. Verify email notifications (if configured)
8. Check mobile responsiveness
9. Test on different browsers
10. Monitor error logs

### First Week Actions
- [ ] Monitor user registrations
- [ ] Assist users with any issues
- [ ] Collect feedback
- [ ] Fine-tune performance
- [ ] Address any bugs

---

## 📋 BACKUP STRATEGY

### Database Backup
```bash
# Automated daily backup
mysqldump -u pi_user -p primeinternship_db > backup_$(date +%Y%m%d).sql

# Via cPanel
# Use cPanel Backup Wizard for automated backups
```

### File Backup
- Backup entire `primeinternship` directory weekly
- Special attention to `uploads/resumes/` folder
- Keep at least 3 backup copies
- Store backups off-site or in cloud

---

## 🚨 EMERGENCY PROCEDURES

### Site Down
1. Check Apache/MySQL status
2. Review error logs
3. Verify database connection
4. Check disk space
5. Restore from backup if needed

### Database Corruption
1. Stop Apache
2. Restore from latest backup
3. Verify data integrity
4. Restart services
5. Test all functionality

### Security Breach
1. Take site offline immediately
2. Change all passwords
3. Review access logs
4. Identify vulnerability
5. Patch security hole
6. Restore from clean backup
7. Notify users if needed

---

## 📞 SUPPORT RESOURCES

### Documentation
- `README.md` - Complete project overview
- `INSTALLATION.md` - Detailed setup guide
- `QUICKSTART.md` - Quick 5-minute setup

### Log Locations
- Apache Error Log: `/var/log/apache2/error.log`
- PHP Error Log: `/path/to/php_errors.log`
- MySQL Error Log: `/var/log/mysql/error.log`

### Helpful Commands
```bash
# Check Apache status
systemctl status apache2

# Check MySQL status
systemctl status mysql

# View recent errors
tail -f /var/log/apache2/error.log

# Test PHP
php -v

# Check disk space
df -h
```

---

## ✨ OPTIONAL ENHANCEMENTS

### Email Notifications
- Configure SMTP for contact form
- Send confirmation emails to users
- Notify admin of new registrations

### Analytics
- Add Google Analytics
- Track user behavior
- Monitor conversion rates

### SEO Optimization
- Add meta descriptions
- Implement Open Graph tags
- Create XML sitemap
- Submit to search engines

### Performance Optimization
- Enable Gzip compression
- Implement browser caching
- Use CDN for static assets
- Optimize database queries

---

## 📝 DEPLOYMENT SIGN-OFF

Once all items are checked:

**Deployed By**: _________________  
**Date**: _________________  
**Version**: 1.0.0  
**Status**: ☐ Development  ☐ Staging  ☐ Production

**Verified By**: _________________  
**Date**: _________________

---

**Notes**:
- Keep this checklist for future deployments
- Document any custom changes
- Update checklist as needed
- Review after each deployment

---

**Deployment Checklist Version**: 1.0  
**Last Updated**: December 2024  
**Platform**: PrimeInternship.com
