/**
 * Skilled Cart (العربة الماهرة) — Main JavaScript
 * Handles mobile navigation, FAQ accordion, request form, and interactions.
 */

document.addEventListener('DOMContentLoaded', () => {
    // -------------------------------------------------------------------------
    // 1. Mobile Navigation Toggle & Drawer
    // -------------------------------------------------------------------------
    const navToggle = document.querySelector('.mobile-nav-toggle');
    const mobileDrawer = document.querySelector('.mobile-menu-drawer');

    if (navToggle && mobileDrawer) {
        navToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = mobileDrawer.classList.contains('open');
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        // Close when clicking any menu link
        mobileDrawer.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });

        // Close on clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileDrawer.contains(e.target) && !navToggle.contains(e.target)) {
                closeMobileMenu();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileDrawer.classList.contains('open')) {
                closeMobileMenu();
                navToggle.focus();
            }
        });
    }

    function openMobileMenu() {
        navToggle.classList.add('open');
        navToggle.setAttribute('aria-expanded', 'true');
        mobileDrawer.classList.add('open');
    }

    function closeMobileMenu() {
        navToggle.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        mobileDrawer.classList.remove('open');
    }

    // -------------------------------------------------------------------------
    // 2. Interactive FAQ Accordion
    // -------------------------------------------------------------------------
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const trigger = item.querySelector('.faq-trigger');
        if (!trigger) return;

        trigger.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close all items
            faqItems.forEach(i => {
                i.classList.remove('active');
                const t = i.querySelector('.faq-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            });

            // Open clicked item if it was closed
            if (!isActive) {
                item.classList.add('active');
                trigger.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // -------------------------------------------------------------------------
    // 3. Service Request Form Handler
    // -------------------------------------------------------------------------
    const requestForm = document.getElementById('request-form');
    const noticeSuccess = document.getElementById('rf-notice-success');
    const noticeError = document.getElementById('rf-notice-error');

    if (requestForm) {
        const nameInput = requestForm.querySelector('[name="name"]');
        const emailInput = requestForm.querySelector('[name="email"]');
        const peopleInput = requestForm.querySelector('[name="people"]');
        const messageInput = requestForm.querySelector('[name="message"]');

        const showNotice = (el) => {
            if (!el) return;
            el.removeAttribute('hidden');
            el.classList.add('is-visible');
            el.style.display = 'block';
        };

        const hideNotice = (el) => {
            if (!el) return;
            el.setAttribute('hidden', '');
            el.classList.remove('is-visible');
            el.style.display = 'none';
        };

        // Guarantee both notices are completely hidden on initial load
        hideNotice(noticeSuccess);
        hideNotice(noticeError);

        // Real-time clearance of invalid markers when user types
        [nameInput, emailInput, peopleInput, messageInput].forEach(input => {
            if (!input) return;
            input.addEventListener('input', () => {
                input.removeAttribute('aria-invalid');
                // Hide the error message once user starts typing/correcting
                if (noticeError && noticeError.classList.contains('is-visible')) {
                    hideNotice(noticeError);
                }
            });
        });

        const isValidEmail = (email) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        };

        requestForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = (nameInput?.value || '').trim();
            const email = (emailInput?.value || '').trim();
            const people = (peopleInput?.value || '').trim();
            const message = (messageInput?.value || '').trim();

            let firstInvalidInput = null;
            let errorMessage = '';

            // Validate name
            if (!name) {
                nameInput?.setAttribute('aria-invalid', 'true');
                if (!firstInvalidInput) firstInvalidInput = nameInput;
                errorMessage = 'الرجاء تعبئة جميع الحقول المطلوبة.';
            } else {
                nameInput?.removeAttribute('aria-invalid');
            }

            // Validate email
            if (!email) {
                emailInput?.setAttribute('aria-invalid', 'true');
                if (!firstInvalidInput) firstInvalidInput = emailInput;
                if (!errorMessage) errorMessage = 'الرجاء تعبئة جميع الحقول المطلوبة.';
            } else if (!isValidEmail(email)) {
                emailInput?.setAttribute('aria-invalid', 'true');
                if (!firstInvalidInput) firstInvalidInput = emailInput;
                if (!errorMessage) errorMessage = 'الرجاء إدخال بريد إلكتروني صحيح.';
            } else {
                emailInput?.removeAttribute('aria-invalid');
            }

            // Validate message
            if (!message) {
                messageInput?.setAttribute('aria-invalid', 'true');
                if (!firstInvalidInput) firstInvalidInput = messageInput;
                if (!errorMessage) errorMessage = 'الرجاء تعبئة جميع الحقول المطلوبة.';
            } else {
                messageInput?.removeAttribute('aria-invalid');
            }

            // If any error occurred, show only error notice and focus first invalid input
            if (errorMessage) {
                hideNotice(noticeSuccess);
                if (noticeError) {
                    noticeError.textContent = errorMessage;
                    showNotice(noticeError);
                    noticeError.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                }
                return;
            }

            // Submission is valid: show only green success notice
            hideNotice(noticeError);
            if (noticeSuccess) {
                showNotice(noticeSuccess);
                noticeSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            // Optional direct WhatsApp shortcut for instant communication
            const whatsappNumber = '966546196801';
            let waText = `طلب خدمة من الموقع:\n- الاسم: ${name}\n- البريد: ${email}`;
            if (people) waText += `\n- عدد الأشخاص: ${people}`;
            waText += `\n- التفاصيل: ${message}`;

            // Reset form fields
            requestForm.reset();
            [nameInput, emailInput, peopleInput, messageInput].forEach(input => {
                input?.removeAttribute('aria-invalid');
            });

            // Offer sending via WhatsApp if user wants immediate response
            console.log('Form submission prepared for WhatsApp:', waText);
        });
    }

    // -------------------------------------------------------------------------
    // 4. Partner Logos Continuous Marquee / Interaction
    // -------------------------------------------------------------------------
    const partnersSlider = document.querySelector('.partners-slider');
    if (partnersSlider && partnersSlider.children.length > 0) {
        // Can add auto-scroll or subtle animation if preferred
    }
});
