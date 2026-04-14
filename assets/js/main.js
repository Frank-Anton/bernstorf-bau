/**
 * Bernstorf Bau - Main JavaScript
 */

(function () {
    'use strict';

    /* =========================================================================
       Mobile Menu
       ========================================================================= */

    const menuToggle = document.getElementById('menu-toggle');
    const mainNav = document.getElementById('main-nav');

    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function () {
            this.classList.toggle('active');
            mainNav.classList.toggle('active');
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
        });

        // Close menu when clicking a link
        mainNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                menuToggle.classList.remove('active');
                mainNav.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* =========================================================================
       Header Scroll Effect
       ========================================================================= */

    const header = document.getElementById('site-header');

    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.15)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.08)';
            }
        });
    }

    /* =========================================================================
       Hero Slider
       ========================================================================= */

    const heroSlides = document.querySelectorAll('.hero__slide');
    const heroDots = document.querySelectorAll('.hero__dot');

    if (heroSlides.length > 1) {
        let currentSlide = 0;
        let slideInterval;

        function goToSlide(index) {
            heroSlides[currentSlide].classList.remove('active');
            if (heroDots[currentSlide]) heroDots[currentSlide].classList.remove('active');

            currentSlide = index;

            heroSlides[currentSlide].classList.add('active');
            if (heroDots[currentSlide]) heroDots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide((currentSlide + 1) % heroSlides.length);
        }

        function startSlider() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopSlider() {
            clearInterval(slideInterval);
        }

        // Dot navigation
        heroDots.forEach(function (dot, index) {
            dot.addEventListener('click', function () {
                stopSlider();
                goToSlide(index);
                startSlider();
            });
        });

        startSlider();
    }

    /* =========================================================================
       Contact Form (AJAX)
       ========================================================================= */

    const contactForm = document.getElementById('bernstorf-contact-form');
    const formMessages = document.getElementById('contact-form-messages');

    if (contactForm && typeof bernstorf_ajax !== 'undefined') {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Wird gesendet...';
            submitBtn.disabled = true;

            const formData = new FormData(contactForm);
            formData.append('action', 'bernstorf_contact');

            fetch(bernstorf_ajax.ajax_url, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    if (formMessages) {
                        formMessages.innerHTML =
                            '<div class="form-message form-message--' +
                            (data.success ? 'success' : 'error') +
                            '">' +
                            escapeHtml(data.data.message) +
                            '</div>';
                    }

                    if (data.success) {
                        contactForm.reset();
                    }
                })
                .catch(function () {
                    if (formMessages) {
                        formMessages.innerHTML =
                            '<div class="form-message form-message--error">Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.</div>';
                    }
                })
                .finally(function () {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });
    }

    /* =========================================================================
       Scroll Animations (simple fade-in)
       ========================================================================= */

    const animateElements = document.querySelectorAll('.service-card, .project-card, .leistung-block, .about-teaser__image, .about-teaser__content');

    if (animateElements.length > 0 && 'IntersectionObserver' in window) {
        // Add initial hidden state
        animateElements.forEach(function (el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        const observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1 }
        );

        animateElements.forEach(function (el) {
            observer.observe(el);
        });
    }

    /* =========================================================================
       Image Slider (Leistungen-Seite)
       ========================================================================= */

    document.querySelectorAll('[data-slider]').forEach(function (slider) {
        const track = slider.querySelector('[data-slider-track]');
        const prevBtn = slider.querySelector('[data-slider-prev]');
        const nextBtn = slider.querySelector('[data-slider-next]');

        if (!track || !prevBtn || !nextBtn) return;

        function getScrollAmount() {
            const slide = track.querySelector('.image-slider__slide');
            if (!slide) return 200;
            const gap = parseFloat(getComputedStyle(track).gap) || 16;
            return slide.offsetWidth + gap;
        }

        function updateButtons() {
            const maxScroll = track.scrollWidth - track.clientWidth - 1;
            prevBtn.disabled = track.scrollLeft <= 0;
            nextBtn.disabled = track.scrollLeft >= maxScroll;
        }

        prevBtn.addEventListener('click', function () {
            track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', function () {
            track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        track.addEventListener('scroll', updateButtons, { passive: true });
        window.addEventListener('resize', updateButtons);
        updateButtons();
    });

    /* =========================================================================
       Anchor Highlight (wenn Leistungen-Seite per Anker angesprungen wird)
       ========================================================================= */

    function highlightAnchorTarget() {
        if (!window.location.hash) return;

        const target = document.querySelector(window.location.hash);
        if (!target || !target.classList.contains('leistung-block')) return;

        target.classList.add('leistung-block--highlight');
        setTimeout(function () {
            target.classList.remove('leistung-block--highlight');
        }, 2200);
    }

    window.addEventListener('load', highlightAnchorTarget);
    window.addEventListener('hashchange', highlightAnchorTarget);

    /* =========================================================================
       Utility: Escape HTML
       ========================================================================= */

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }
})();
