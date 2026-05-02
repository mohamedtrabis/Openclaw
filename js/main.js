/**
 * Luxury Travel - Premium JavaScript
 * Enhanced interactions, animations, and smooth UX
 */

document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect with class toggle
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            this.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
        });
    }

    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function() {
            navLinks.classList.remove('active');
            if (mobileMenuBtn) {
                mobileMenuBtn.textContent = '☰';
            }
        });
    });

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

    // Smooth scrolling for anchor links with offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements with animation classes
    document.querySelectorAll('.animate-on-scroll, .fade-in, .card, .service-card').forEach(el => {
        el.classList.add('animate-on-scroll');
        observer.observe(el);
    });

    // Parallax effect for hero section
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
        });
    }

    // Add staggered animation delay to cards
    const cardGrids = document.querySelectorAll('.card-grid');
    cardGrids.forEach(grid => {
        const cards = grid.querySelectorAll('.card, .service-card');
        cards.forEach((card, index) => {
            card.style.transitionDelay = (index * 0.1) + 's';
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
