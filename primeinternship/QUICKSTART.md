# 🚀 QUICK START GUIDE
## Get PrimeInternship.com Running in 5 Minutes!

---

## ⚡ FASTEST WAY TO RUN

### For XAMPP Users (Most Common):

1. **Copy Project**
   - Copy the `primeinternship` folder to: `C:\xampp\htdocs\`

2. **Import Database**
   - Open: `http://localhost/phpmyadmin`
   - Click "New" → Name it `primeinternship_db` → Create
   - Select the database → Import → Choose `database.sql` → Go

3. **Access Website**
   - Open browser: `http://localhost/primeinternship/`

4. **Login as Admin**
   - Email: `admin@primeinternship.com`
   - Password: `admin123`

**DONE! 🎉**

---

## 🔑 DEFAULT ACCOUNTS

### Admin (Full Control)
```
Email: admin@primeinternship.com
Password: admin123
```

### Test Student (Optional - Create Manually)
```
Register at: http://localhost/primeinternship/register.php
Select: Student
Fill in details and register
```

### Test Employer (Optional - Create Manually)
```
Register at: http://localhost/primeinternship/register.php?type=employer
Select: Employer
Fill in company details and register
```

---

## 📂 WHERE TO PUT FILES

### Windows (XAMPP)
```
C:\xampp\htdocs\primeinternship\
```

### Mac (MAMP)
```
/Applications/MAMP/htdocs/primeinternship/
```

### Linux (LAMP)
```
/var/www/html/primeinternship/
```

---

## ⚙️ CONFIGURATION (Only If Needed)

### Database Settings
File: `php/config.php`

```php
define('DB_HOST', 'localhost');      // Usually don't change
define('DB_USER', 'root');            // Change if different
define('DB_PASS', '');                 // Add password if set
define('DB_NAME', 'primeinternship_db'); // Must match database name
```

**Most users with XAMPP default installation won't need to change anything!**

---

## ✅ VERIFICATION STEPS

After setup, check these:

1. ✅ Homepage loads: `http://localhost/primeinternship/`
2. ✅ Logo displays at top-left
3. ✅ Can login as admin
4. ✅ Can register as student
5. ✅ Can register as employer

---

## 🎯 TESTING THE COMPLETE FLOW

### Complete Test (5 minutes):

**Step 1: Register as Employer**
1. Go to Register → Select Employer
2. Fill form:
   - Name: John Doe
   - Company: Tech Corp
   - Email: test.employer@example.com
   - Password: test123
3. Submit → You'll see Employer Dashboard

**Step 2: Post a Job**
1. Fill the job posting form
2. Submit → Wait for approval message

**Step 3: Login as Admin**
1. Logout → Login with admin credentials
2. Go to "Pending Jobs" section
3. Click "Approve" on your test job

**Step 4: Register as Student**
1. Logout → Register as Student
2. Fill form with:
   - Qualification matching the job you posted
   - Upload a sample PDF resume

**Step 5: Apply for Job**
1. You'll see the approved job
2. Click "Apply Now"
3. Check "My Applications" tab

**Step 6: View Application (as Employer)**
1. Logout → Login as Employer
2. Go to "My Postings"
3. Click "View" on your job
4. See the student application with resume link

---

## 🛠️ TROUBLESHOOTING (Quick Fixes)

### Problem: Can't access localhost
**Fix**: Start Apache and MySQL in XAMPP Control Panel

### Problem: Database connection error
**Fix**: 
1. Make sure MySQL is running in XAMPP
2. Check database name is `primeinternship_db`
3. Verify it's imported in phpMyAdmin

### Problem: Blank page
**Fix**: Clear browser cache, refresh page

### Problem: Logo not showing
**Fix**: Verify `assets/images/logo.png` exists

### Problem: Can't upload resume
**Fix**: Make sure `uploads/resumes/` folder exists

---

## 📱 FEATURES TO TEST

- ✅ Student Registration & Login
- ✅ Employer Registration & Login
- ✅ Admin Dashboard (approve/reject jobs)
- ✅ Post Internship Opportunity
- ✅ Browse & Apply for Jobs
- ✅ View Applications & Resumes
- ✅ Contact Form
- ✅ Responsive Design (try on phone)

---

## 🌟 WHAT'S INCLUDED

- **5 Complete Pages**: Home, About, Programs, Contact, Login/Register
- **3 Dashboards**: Student, Employer, Admin
- **Security**: Password hashing, SQL injection prevention, XSS protection
- **Professional UI**: Navy blue & gold theme, responsive design
- **File Upload**: Resume management system
- **Filtering**: Qualification-based job matching
- **Role-Based Access**: Separate permissions for each user type

---

## 🔐 SECURITY NOTES

**IMPORTANT**: After testing, change the admin password!

1. Login as admin
2. (Future feature - or manually update in database)

For manual password change:
```sql
-- In phpMyAdmin, run this SQL:
UPDATE users 
SET password = '$2y$10$YOUR_HASHED_PASSWORD' 
WHERE email = 'admin@primeinternship.com';
```

---

## 📞 NEED HELP?

1. Check `README.md` for detailed information
2. See `INSTALLATION.md` for complete setup guide
3. Check browser console for errors (F12)
4. Look at `php/php_error.log` for PHP errors

---

## 🎉 YOU'RE ALL SET!

Your PrimeInternship.com platform is ready to use!

**Next Steps:**
1. Customize content to your needs
2. Add your own logo (optional)
3. Modify colors in `css/style.css` (optional)
4. Add more internship opportunities
5. Deploy to live server when ready

---

**Quick Start Version**: 1.0  
**Platform**: PrimeInternship.com  
**Ready Time**: ~5 minutes ⚡
