/**
 * Bharat SEO - Main JavaScript
 * Lightweight, no dependencies
 */

(function() {
    'use strict';

    // --- Header Scroll Effect ---
    const header = document.getElementById('site-header');
    let lastScroll = 0;

    function handleHeaderScroll() {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        lastScroll = currentScroll;
    }

    window.addEventListener('scroll', handleHeaderScroll, { passive: true });

    // --- Mobile Navigation ---
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileNavClose = document.getElementById('mobile-nav-close');
    let overlay = null;

    function openMobileNav() {
        mobileNav.classList.add('open');
        mobileNav.setAttribute('aria-hidden', 'false');
        mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';

        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'mobile-nav-overlay';
            document.body.appendChild(overlay);
            overlay.addEventListener('click', closeMobileNav);
        }
        setTimeout(() => overlay.classList.add('active'), 10);
    }

    function closeMobileNav() {
        mobileNav.classList.remove('open');
        mobileNav.setAttribute('aria-hidden', 'true');
        mobileToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';

        if (overlay) {
            overlay.classList.remove('active');
        }
    }

    if (mobileToggle) mobileToggle.addEventListener('click', openMobileNav);
    if (mobileNavClose) mobileNavClose.addEventListener('click', closeMobileNav);

    // Close on link click
    document.querySelectorAll('.mobile-nav-list a').forEach(link => {
        link.addEventListener('click', closeMobileNav);
    });

    // --- FAQ Accordion ---
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.parentElement;
            const isOpen = item.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-item.open').forEach(openItem => {
                openItem.classList.remove('open');
            });

            // Toggle current
            if (!isOpen) {
                item.classList.add('open');
            }
        });
    });

    // --- Scroll Animations ---
    function initScrollAnimations() {
        const elements = document.querySelectorAll('.fade-up');
        if (!elements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(el => observer.observe(el));
    }

    // Check for reduced motion preference
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        initScrollAnimations();
    } else {
        // Show all elements immediately
        document.querySelectorAll('.fade-up').forEach(el => {
            el.classList.add('visible');
        });
    }

    // --- Form Validation ---
    document.querySelectorAll('form[data-validate]').forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                field.classList.remove('error');
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('error');
                    field.style.borderColor = '#FF3B30';
                } else {
                    field.style.borderColor = '';
                }
            });

            // Email validation
            const emailField = form.querySelector('[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    valid = false;
                    emailField.style.borderColor = '#FF3B30';
                }
            }

            // Phone validation (Indian)
            const phoneField = form.querySelector('[name="phone"]');
            if (phoneField && phoneField.value) {
                const phoneClean = phoneField.value.replace(/[\s\-\+]/g, '');
                if (phoneClean.length < 10) {
                    valid = false;
                    phoneField.style.borderColor = '#FF3B30';
                }
            }

            if (!valid) {
                e.preventDefault();
                const firstError = form.querySelector('[style*="FF3B30"]');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    });

    // --- Portfolio Filter ---
    const filterBtns = document.querySelectorAll('.filter-btn');
    if (filterBtns.length) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('[data-category]').forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // --- Smooth scroll for anchor links ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
