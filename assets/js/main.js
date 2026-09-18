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
        requestForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = (requestForm.querySelector('[name="name"]')?.value || '').trim();
            const email = (requestForm.querySelector('[name="email"]')?.value || '').trim();
            const people = (requestForm.querySelector('[name="people"]')?.value || '').trim();
            const message = (requestForm.querySelector('[name="message"]')?.value || '').trim();

            if (!name || !email || !message) {
                if (noticeError) {
                    noticeError.textContent = 'الرجاء تعبئة جميع الحقول المطلوبة.';
                    noticeError.style.display = 'block';
                }
                if (noticeSuccess) noticeSuccess.style.display = 'none';
                return;
            }

            // Hide error notice if visible
            if (noticeError) noticeError.style.display = 'none';

            // Show success notice
            if (noticeSuccess) {
                noticeSuccess.style.display = 'block';
                noticeSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            // Optional direct WhatsApp shortcut for instant communication
            const whatsappNumber = '966546196801';
            let waText = `طلب خدمة من الموقع:\n- الاسم: ${name}\n- البريد: ${email}`;
            if (people) waText += `\n- عدد الأشخاص: ${people}`;
            waText += `\n- التفاصيل: ${message}`;

            // Reset form fields
            requestForm.reset();

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
