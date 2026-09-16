<?php
/**
 * Generates /sitemap.xml (via the .htaccess rewrite below).
 * Reads the same per-page metadata used for SEO tags, so it never drifts
 * out of sync with the pages themselves.
 */
require __DIR__ . '/includes/functions.php';
$d = site_data();
$domain = rtrim($d['domain'], '/');

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($d['pages'] as $page): ?>
	<url>
		<loc><?= h($domain . $page['path']) ?></loc>
		<lastmod><?= h(substr($page['date_modified'], 0, 10)) ?></lastmod>
	</url>
<?php endforeach; ?>
</urlset>
