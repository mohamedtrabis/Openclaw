/**
 * Luxury Travel - Main JavaScript
 * Handles navbar, interactions and form logic
 */

document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.style.backgroundColor = 'rgba(26, 26, 46, 0.98)';
        } else {
            navbar.style.backgroundColor = '#1a1a2e';
        }
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }

    // Form validation for planning form
    const planForm = document.getElementById('plan-form');
    
    if (planForm) {
        planForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const destination = document.getElementById('destination').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            const budget = document.getElementById('budget').value;
            const travelers = document.getElementById('travelers').value;
            
            // Basic validation
            if (!destination || !startDate || !endDate || !budget || !travelers) {
                showAlert('Veuillez remplir tous les champs obligatoires', 'error');
                return;
            }
            
            if (new Date(startDate) >= new Date(endDate)) {
                showAlert('La date de fin doit être après la date de début', 'error');
                return;
            }
            
            // Submit form data
            submitPlanForm({
                destination,
                startDate,
                endDate,
                budget,
                travelers,
                preferences: getSelectedPreferences()
            });
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Card hover effects enhancement
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
    });
});

// Helper functions
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

function getSelectedPreferences() {
    const checkboxes = document.querySelectorAll('input[name="preferences[]"]:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

function submitPlanForm(data) {
    // In a real application, this would send data to the server
    console.log('Submitting plan:', data);
    
    // Show loading state
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Recherche en cours...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Redirect to results page
        window.location.href = 'resultats.php?' + new URLSearchParams(data);
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 1500);
}

// Animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe elements with animation class
document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});
