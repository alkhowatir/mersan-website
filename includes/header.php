<?php
/**
 * Top of every page: <!DOCTYPE>, <head> (SEO + assets), and the opening
 * page wrapper + site header. Each page template sets $page_slug before
 * including this file.
 */
require_once __DIR__ . '/functions.php';
$d = site_data();
?>
<!DOCTYPE html>
<html dir="<?= h($d['dir']) ?>" lang="<?= h($d['lang']) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php render_seo($page_slug); ?>

<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Montserrat:700|Cairo:400,500,700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap">

<link rel="stylesheet" href="/assets/vendor/themes/astra/assets/css/minified/main.min-rtl.css">
<link rel="stylesheet" href="/assets/css/theme.css">
<link rel="stylesheet" href="/assets/vendor/plugins/header-footer-elementor/inc/widgets-css/frontend.css">
<link rel="stylesheet" href="/assets/vendor/plugins/header-footer-elementor/assets/css/header-footer-elementor.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/frontend.min.css">
<link rel="stylesheet" href="/assets/css/elementor-generated.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/font-awesome/css/all.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/font-awesome/css/v4-shims.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-heading-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-divider-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/animations/styles/fadeIn.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-counter-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-image-box-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-icon-box-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-icon-list-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-icon-list.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-accordion-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-social-icons.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-google_maps-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/widget-image-carousel-rtl.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/css/conditionals/e-swiper.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/swiper/v8/css/swiper.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/font-awesome/css/brands.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/font-awesome/css/fontawesome.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor/assets/lib/font-awesome/css/solid.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor-pro/assets/css/widget-blockquote.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor-pro/assets/css/widget-mega-menu.min.css">
<link rel="stylesheet" href="/assets/vendor/plugins/elementor-pro/assets/css/widget-nav-menu.min.css">
<link rel="stylesheet" href="/assets/css/responsive-fixes.css">
</head>

<body class="rtl <?= h($d['pages'][$page_slug]['body_class']) ?>">
<script>
(function(){if(window.matchMedia('(max-width:921.99px)').matches){document.body.classList.add('ast-header-break-point');document.body.classList.remove('ast-desktop');}})();
</script>
<div id="surecookie-public-root"></div>
<a class="skip-link screen-reader-text" href="#content">تخطي إلى المحتوى</a>
<div class="hfeed site" id="page">
<?php include __DIR__ . '/header-markup.php'; ?>
<!-- #masthead -->
<div id="content" class="site-content">
<div class="ast-container">
<div id="primary" class="content-area primary">
<main id="main" class="site-main">
