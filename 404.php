<?php
http_response_code(404);
$page_slug = 'home'; // reuse home nav state; no dedicated nav item for 404
require __DIR__ . '/includes/functions.php';
$d = site_data();
?>
<!DOCTYPE html>
<html dir="<?= h($d['dir']) ?>" lang="<?= h($d['lang']) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>الصفحة غير موجودة - <?= h($d['site_name']) ?></title>
<meta name="robots" content="noindex, follow">
<link rel="stylesheet" href="/assets/vendor/themes/astra/assets/css/minified/main.min-rtl.css">
<link rel="stylesheet" href="/assets/css/theme.css">
<style>
.error-404-wrap{min-height:60vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:60px 20px;}
.error-404-wrap h1{font-size:6rem;margin:0;line-height:1;}
.error-404-wrap p{font-size:1.25rem;margin:20px 0;}
.error-404-wrap a{display:inline-block;margin-top:10px;padding:12px 28px;border-radius:6px;background:#222;color:#fff;text-decoration:none;}
</style>
</head>
<body class="rtl page-404">
<div class="hfeed site" id="page">
<?php include __DIR__ . '/includes/header-markup.php'; ?>
<div id="content" class="site-content">
<div class="ast-container">
<main class="error-404-wrap">
<h1>404</h1>
<p>عذرًا، الصفحة التي تبحث عنها غير موجودة.</p>
<a href="/">العودة إلى الصفحة الرئيسية</a>
</main>
</div>
</div>
<?php include __DIR__ . '/includes/footer-markup.php'; ?>
</div>
</body>
</html>
