/**
 * Mursan Facilities (مرسان المرافق) — Main JavaScript
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
    // 3. Service Request Form Handler (Web3Forms API)
    // -------------------------------------------------------------------------
    // Works for both homepage (#request-form) and contact page (#contact-request-form)
    const WEB3FORMS_ENDPOINT = 'https://api.web3forms.com/submit';
    const REQUEST_TIMEOUT_MS = 15000; // 15-second timeout

    /**
     * Initialize a form with validation and Web3Forms submission.
     * @param {string} formId        — The form element ID
     * @param {string} successId     — The success notice element ID
     * @param {string} errorId       — The error notice element ID
     */
    function initRequestForm(formId, successId, errorId) {
        const form = document.getElementById(formId);
        const noticeSuccess = document.getElementById(successId);
        const noticeError = document.getElementById(errorId);

        if (!form) return;

        const nameInput = form.querySelector('[name="name"]');
        const emailInput = form.querySelector('[name="email"]');
        const siteTypeInput = form.querySelector('[name="site_type"]');
        const messageInput = form.querySelector('[name="message"]');
        const accessKeyInput = form.querySelector('[name="access_key"]');
        const submitBtn = form.querySelector('[type="submit"]');

        // Double-submit guard
        let isSubmitting = false;

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

        const showError = (msg) => {
            hideNotice(noticeSuccess);
            if (noticeError) {
                noticeError.textContent = msg;
                showNotice(noticeError);
                noticeError.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        };

        // Guarantee both notices are completely hidden on initial load
        hideNotice(noticeSuccess);
        hideNotice(noticeError);

        // Clear invalid markers as the user corrects a field
        [nameInput, emailInput, siteTypeInput, messageInput].forEach(input => {
            if (!input) return;
            input.addEventListener('input', () => {
                input.removeAttribute('aria-invalid');
                if (noticeError && noticeError.classList.contains('is-visible')) {
                    hideNotice(noticeError);
                }
            });
        });

        const isValidEmail = (email) => {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Double-submit guard: block overlapping requests
            if (isSubmitting) return;

            const name = (nameInput?.value || '').trim();
            const email = (emailInput?.value || '').trim();
            const siteType = (siteTypeInput?.value || '').trim();
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
                showError(errorMessage);
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                }
                return;
            }

            // If Web3Forms key is not yet provisioned, provide direct WhatsApp/Email dispatch
            const accessKey = (accessKeyInput?.value || '').trim();
            if (!accessKey || accessKey.startsWith('PENDING_')) {
                const lines = [
                    `طلب خدمة جديد — مرسان المرافق`,
                    `الاسم: ${name}`,
                    `البريد الإلكتروني: ${email}`,
                    siteType ? `نوع الموقع أو المنشأة: ${siteType}` : null,
                    `تفاصيل الطلب: ${message}`
                ].filter(Boolean).join('\n');

                const waUrl = `https://wa.me/966501654936?text=${encodeURIComponent(lines)}`;
                const mailUrl = `mailto:Info@marsanfm.com?subject=${encodeURIComponent('طلب خدمة جديد — مرسان المرافق')}&body=${encodeURIComponent(lines)}`;

                if (noticeSuccess) {
                    noticeSuccess.innerHTML = '';
                    const msgSpan = document.createElement('span');
                    msgSpan.textContent = 'تم تجهيز بيانات طلبك بنجاح. أرسله مباشرة عبر ';
                    const waLink = document.createElement('a');
                    waLink.href = waUrl;
                    waLink.target = '_blank';
                    waLink.rel = 'noopener noreferrer';
                    waLink.textContent = 'واتساب';
                    waLink.style.textDecoration = 'underline';
                    const sep = document.createTextNode(' أو ');
                    const mailLink = document.createElement('a');
                    mailLink.href = mailUrl;
                    mailLink.textContent = 'البريد الإلكتروني';
                    mailLink.style.textDecoration = 'underline';
                    noticeSuccess.append(msgSpan, waLink, sep, mailLink, document.createTextNode('.'));
                    showNotice(noticeSuccess);
                    noticeSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
                form.reset();
                [nameInput, emailInput, siteTypeInput, messageInput].forEach(input => {
                    input?.removeAttribute('aria-invalid');
                });
                return;
            }

            // --- Send via Web3Forms API ---
            hideNotice(noticeError);
            hideNotice(noticeSuccess);
            isSubmitting = true;

            // Show loading state on button
            const originalBtnText = submitBtn?.textContent;
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'جاري الإرسال...';
            }

            // Timeout controller
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), REQUEST_TIMEOUT_MS);

            try {
                const formData = new FormData(form);
                const payload = Object.fromEntries(formData);

                const response = await fetch(WEB3FORMS_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload),
                    signal: controller.signal
                });

                clearTimeout(timeoutId);
                const result = await response.json();

                if (response.ok && result.success) {
                    // Success
                    showNotice(noticeSuccess);
                    noticeSuccess?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                    // Reset form fields
                    form.reset();
                    [nameInput, emailInput, siteTypeInput, messageInput].forEach(input => {
                        input?.removeAttribute('aria-invalid');
                    });
                } else {
                    const apiMessage = result?.message || result?.body?.message;
                    const errorMessage = apiMessage
                        ? `تعذر إرسال الطلب: ${apiMessage}`
                        : 'حدث خطأ أثناء الإرسال. يرجى المحاولة مرة أخرى.';

                    console.error('Web3Forms submission failed:', response.status, result);
                    showError(errorMessage);
                }
            } catch (err) {
                clearTimeout(timeoutId);

                if (err.name === 'AbortError') {
                    // Request timed out
                    showError('انتهت مهلة الإرسال. يرجى التحقق من اتصالك بالإنترنت والمحاولة مرة أخرى.');
                } else {
                    // Network / fetch error
                    showError('حدث خطأ في الاتصال. يرجى التحقق من اتصالك بالإنترنت والمحاولة مرة أخرى.');
                }
                console.error('Form submission error:', err);
            } finally {
                // Restore button state
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            }
        });
    }

    // Initialize homepage form
    initRequestForm('request-form', 'rf-notice-success', 'rf-notice-error');

    // Initialize contact page form
    initRequestForm('contact-request-form', 'crf-notice-success', 'crf-notice-error');

    // -------------------------------------------------------------------------
    // 4. Partner Logos Continuous Marquee / Interaction
    // -------------------------------------------------------------------------
    const partnersSlider = document.querySelector('.partners-slider');
    if (partnersSlider && partnersSlider.children.length > 0) {
        // Can add auto-scroll or subtle animation if preferred
    }
});
