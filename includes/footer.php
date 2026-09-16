<?php $d = site_data(); ?>
</main><!-- #main -->
</div><!-- #primary -->
</div><!-- ast-container -->
</div><!-- #content -->
<?php include __DIR__ . '/footer-markup.php'; ?>
</div><!-- #page -->

<script src="/assets/vendor/wp-includes/js/jquery/jquery.min.js"></script>
<script src="/assets/vendor/wp-includes/js/jquery/jquery-migrate.min.js"></script>
<script src="/assets/vendor/plugins/elementor/assets/lib/font-awesome/js/v4-shims.min.js"></script>
<script src="/assets/vendor/themes/astra/assets/js/minified/frontend.min.js"></script>
<script src="/assets/vendor/plugins/elementor/assets/js/webpack.runtime.min.js"></script>
<script src="/assets/vendor/plugins/elementor/assets/js/frontend-modules.min.js"></script>
<script>jQuery.uiBackCompat = true;</script>
<script src="/assets/vendor/wp-includes/js/jquery/ui/core.min.js"></script>
<script>
var elementorFrontendConfig = {"environmentMode":{"edit":false},"i18n":{"shareOnFacebook":"شارك على فيسبوك","shareOnX":"Share on X","pinIt":"ثبتها ","download":"تحميل","downloadImage":"تنزيل الصورة","fullscreen":"عرض شاشة كاملة","zoom":"تكبير","share":"مشاركة","playVideo":"تشغيل الفيديو","previous":"السابق","next":"التالي","close":"إغلاق"},"is_rtl":true,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true}}},"version":"4.2.2","is_static":false,"urls":{"assets":"/assets/vendor/plugins/elementor/assets/"},"swiperClass":"swiper","settings":{"page":[],"editorPreferences":[]},"kit":{"active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":0,"title":"","excerpt":"","featuredImage":false}};
</script>
<script src="/assets/vendor/plugins/elementor/assets/js/frontend.min.js"></script>
<script src="/assets/vendor/plugins/elementor/assets/lib/jquery-numerator/jquery-numerator.min.js"></script>
<?php if ($page_slug === 'projects'): ?>
<script src="/assets/vendor/plugins/elementor/assets/lib/swiper/v8/swiper.min.js"></script>
<?php endif; ?>
<script src="/assets/vendor/plugins/surecookie/build/public.js"></script>
<script src="/assets/vendor/plugins/elementor-pro/assets/js/webpack-pro.runtime.min.js"></script>
<script>
var ElementorProFrontendConfig = {"urls":{"assets":"/assets/vendor/plugins/elementor-pro/assets/"},"settings":{"lazy_load_background_images":true},"popup":{"hasPopUps":false}};
</script>
<script src="/assets/vendor/plugins/elementor-pro/assets/js/frontend.min.js"></script>
<script src="/assets/vendor/plugins/elementor-pro/assets/js/elements-handlers.min.js"></script>
<script>
// Belt-and-braces: close the mobile nav panel after a link is chosen.
// Astra's own frontend.min.js already drives open/close + Escape + focus
// trapping; this just guarantees the toggled/open state never survives
// a click on an actual nav link (e.g. bfcache restores after using the
// browser back button).
document.addEventListener('DOMContentLoaded', function () {
    var mobileNav = document.getElementById('ast-mobile-site-navigation');
    var toggleBtn = document.querySelector('.ast-mobile-header-wrap .menu-toggle.main-header-menu-toggle');
    if (!mobileNav || !toggleBtn) { return; }
    mobileNav.querySelectorAll('a.menu-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (toggleBtn.classList.contains('toggled') || toggleBtn.getAttribute('aria-expanded') === 'true') {
                toggleBtn.click();
            }
        });
    });
});
</script>
<script>
// Lightweight FAQ accordion (first item is pre-opened server-side; this just
// handles clicks — no dependency on Elementor's own JS runtime).
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.elementor-accordion').forEach(function (accordion) {
        accordion.querySelectorAll('.elementor-tab-title').forEach(function (title) {
            title.addEventListener('click', function () {
                var isOpen = title.classList.contains('elementor-active');
                accordion.querySelectorAll('.elementor-tab-title').forEach(function (t) {
                    t.classList.remove('elementor-active');
                    t.setAttribute('aria-expanded', 'false');
                    var c = document.getElementById(t.getAttribute('aria-controls'));
                    if (c) { c.style.display = 'none'; }
                });
                if (!isOpen) {
                    title.classList.add('elementor-active');
                    title.setAttribute('aria-expanded', 'true');
                    var content = document.getElementById(title.getAttribute('aria-controls'));
                    if (content) { content.style.display = 'block'; }
                }
            });
        });
    });
});
</script>
<script>
( () => {
    const lazyloadRunObserver = () => {
        const lazyloadBackgrounds = document.querySelectorAll( `.e-con.e-parent:not(.e-lazyloaded)` );
        const lazyloadBackgroundObserver = new IntersectionObserver( ( entries ) => {
            entries.forEach( ( entry ) => {
                if ( entry.isIntersecting ) {
                    let lazyloadBackground = entry.target;
                    if( lazyloadBackground ) {
                        lazyloadBackground.classList.add( 'e-lazyloaded' );
                    }
                    lazyloadBackgroundObserver.unobserve( entry.target );
                }
            });
        }, { rootMargin: '200px 0px 200px 0px' } );
        lazyloadBackgrounds.forEach( ( lazyloadBackground ) => {
            lazyloadBackgroundObserver.observe( lazyloadBackground );
        } );
    };
    document.addEventListener( 'DOMContentLoaded', lazyloadRunObserver );
} )();
</script>
</body>
</html>
