(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var revealSelector = [
        '.elementor-widget-image-box',
        '.elementor-widget-icon-box',
        '.elementor-widget-hfe-infocard',
        '.elementor-counter',
        '.elementor-accordion-item',
        '.request-form'
    ].join(',');
    var revealItems = Array.prototype.slice.call(document.querySelectorAll(revealSelector));

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
        return;
    }

    revealItems.forEach(function (item, index) {
        item.classList.add('sc-reveal');
        item.style.setProperty('--sc-delay', String(index % 3 * 70) + 'ms');
    });

    var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -6% 0px'
    });

    revealItems.forEach(function (item) {
        revealObserver.observe(item);
    });
}());
