/**
 * PrimeInternship.com - Main JavaScript
 * Professional Industry Immersion & Career Pathway Platform
 */

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.navbar')) {
            navMenu?.classList.remove('active');
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f56565';
                } else {
                    field.style.borderColor = '#e2e8f0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    });
    
    // Email validation
    const emailFields = document.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        field.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.style.borderColor = '#f56565';
            } else {
                this.style.borderColor = '#e2e8f0';
            }
        });
    });
    
    // File upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!allowedTypes.includes(file.type)) {
                    alert('Only PDF and DOC files are allowed');
                    this.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }
            }
        });
    });
    
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm(this.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });
    
    // Dynamic branch field based on qualification
    const qualificationSelect = document.querySelector('select[name="qualification"]');
    const branchField = document.querySelector('.branch-field');
    
    if (qualificationSelect && branchField) {
        qualificationSelect.addEventListener('change', function() {
            const value = this.value;
            if (value.startsWith('BTech')) {
                branchField.style.display = 'block';
            } else {
                branchField.style.display = 'none';
            }
        });
        
        // Trigger on page load
        qualificationSelect.dispatchEvent(new Event('change'));
    }
    
    // Table search functionality
    const searchInputs = document.querySelectorAll('.table-search');
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const table = this.closest('.table-container').querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
    
    // Password strength indicator
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        if (input.name === 'password' && !input.name.includes('confirm')) {
            const indicator = document.createElement('div');
            indicator.className = 'password-strength';
            input.parentNode.appendChild(indicator);
            
            input.addEventListener('input', function() {
                const value = this.value;
                let strength = 0;
                
                if (value.length >= 8) strength++;
                if (/[a-z]/.test(value)) strength++;
                if (/[A-Z]/.test(value)) strength++;
                if (/[0-9]/.test(value)) strength++;
                if (/[^a-zA-Z0-9]/.test(value)) strength++;
                
                const messages = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                const colors = ['#f56565', '#ed8936', '#ecc94b', '#48bb78', '#38a169'];
                
                if (value.length > 0) {
                    indicator.textContent = `Password Strength: ${messages[strength - 1] || 'Very Weak'}`;
                    indicator.style.color = colors[strength - 1] || colors[0];
                    indicator.style.fontSize = '0.875rem';
                    indicator.style.marginTop = '0.5rem';
                } else {
                    indicator.textContent = '';
                }
            });
        }
    });
});

// AJAX form submission helper
function submitForm(formId, url, callback) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (callback) callback(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

// Show loading spinner
function showLoading() {
    const loader = document.createElement('div');
    loader.id = 'loading-spinner';
    loader.innerHTML = '<div style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(26,54,93,0.9);color:white;padding:2rem;border-radius:10px;z-index:9999;">Loading...</div>';
    document.body.appendChild(loader);
}

// Hide loading spinner
function hideLoading() {
    const loader = document.getElementById('loading-spinner');
    if (loader) loader.remove();
}

// Format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-IN', options);
}

// Scroll to top button
window.addEventListener('scroll', function() {
    let scrollBtn = document.getElementById('scroll-top');
    
    if (!scrollBtn) {
        scrollBtn = document.createElement('button');
        scrollBtn.id = 'scroll-top';
        scrollBtn.innerHTML = '↑';
        scrollBtn.style.cssText = 'position:fixed;bottom:20px;right:20px;background:#1a365d;color:white;border:none;border-radius:50%;width:50px;height:50px;font-size:1.5rem;cursor:pointer;display:none;z-index:999;box-shadow:0 4px 6px rgba(0,0,0,0.1);transition:all 0.3s ease;';
        document.body.appendChild(scrollBtn);
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    if (window.pageYOffset > 300) {
        scrollBtn.style.display = 'block';
    } else {
        scrollBtn.style.display = 'none';
    }
});

// Print function for resumes
function printResume(url) {
    window.open(url, '_blank');
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}

console.log('PrimeInternship.com - System loaded successfully');
