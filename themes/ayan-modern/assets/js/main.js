/**
 * Ayan Modern Theme JavaScript
 * 
 * @package Ayan_Modern
 * @author Ayan Ozturk
 */

(function() {
    'use strict';

    // Mobile menu toggle
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const html = document.documentElement;
        const body = document.body;

        if (!menuToggle || !navigation) return;

        function openMenu() {
            navigation.classList.add('active');
            menuToggle.setAttribute('aria-expanded', 'true');
            const icon = menuToggle.querySelector('.menu-toggle-icon');
            if (icon) icon.classList.add('active');
            body.classList.add('nav-open');
        }

        function closeMenu() {
            navigation.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
            const icon = menuToggle.querySelector('.menu-toggle-icon');
            if (icon) icon.classList.remove('active');
            body.classList.remove('nav-open');
        }

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!navigation.contains(event.target) && !menuToggle.contains(event.target)) {
                closeMenu();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        // Close on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1025) {
                closeMenu();
            }
        });
    }

    // Smooth scrolling for anchor links
    function initSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // Lazy loading for images
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            const lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(img => imageObserver.observe(img));
        }
    }

    // Back to top button
    function initBackToTop() {
        const backToTop = document.createElement('button');
        backToTop.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
            </svg>
        `;
        backToTop.className = 'back-to-top';
        backToTop.setAttribute('aria-label', 'Back to top');
        document.body.appendChild(backToTop);

        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Scroll to top when clicked
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Search functionality
    function initSearch() {
        const searchForm = document.querySelector('.search-form');
        const searchField = document.querySelector('.search-field');
        
        if (searchForm && searchField) {
            searchForm.addEventListener('submit', function(e) {
                if (!searchField.value.trim()) {
                    e.preventDefault();
                    searchField.focus();
                }
            });
        }
    }

    // Newsletter form
    function initNewsletterForm() {
        const newsletterForm = document.querySelector('.newsletter-form');
        
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = this.querySelector('input[name="email"]').value;
                const submitBtn = this.querySelector('.newsletter-submit');
                const originalText = submitBtn.textContent;
                
                // Simple validation
                if (!email || !email.includes('@')) {
                    alert('Please enter a valid email address.');
                    return;
                }
                
                // Show loading state
                submitBtn.textContent = 'Subscribing...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    submitBtn.textContent = 'Subscribed!';
                    this.reset();
                    
                    setTimeout(() => {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }, 2000);
                }, 1000);
            });
        }
    }

    // Reading progress bar
    function initReadingProgress() {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            
            progressBar.style.width = scrollPercent + '%';
        });
    }

    // Initialize all functions when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initSmoothScrolling();
        initLazyLoading();
        initBackToTop();
        initSearch();
        initNewsletterForm();
        initReadingProgress();
    });

    // Initialize functions that need to run after window load
    window.addEventListener('load', function() {
        // Add any functions that need to run after all resources are loaded
    });

})();
