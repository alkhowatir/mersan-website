<?php
/**
 * Small helper functions shared by every page.
 * No WordPress, no database — everything reads from data/site.php.
 */

function site_data(): array
{
    static $data = null;
    if ($data === null) {
        $data = require __DIR__ . '/../data/site.php';
    }
    return $data;
}

function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/**
 * Print the <title>, meta description/robots, canonical, Open Graph,
 * Twitter Card and JSON-LD structured data for the given page slug.
 * Reproduces what the SureRank plugin generated on the original WordPress site.
 */
function render_seo(string $slug): void
{
    $data   = site_data();
    $domain = rtrim($data['domain'], '/');
    $page   = $data['pages'][$slug];
    $url    = $domain . $page['path'];
    $title  = $page['title'];
    $desc   = $page['description'];

    echo "<title>" . h($title) . "</title>\n";
    echo '<link rel="canonical" href="' . h($url) . "\">\n";
    echo '<meta name="description" content="' . h($desc) . "\">\n";
    echo "<meta name=\"robots\" content=\"index, follow\">\n";
    echo '<meta property="og:url" content="' . h($url) . "\">\n";
    echo '<meta property="og:site_name" content="' . h($data['site_name']) . "\">\n";
    echo '<meta property="og:locale" content="' . h($data['locale']) . "\">\n";
    echo "<meta property=\"og:type\" content=\"website\">\n";
    echo '<meta property="og:title" content="' . h($title) . "\">\n";
    echo '<meta property="og:description" content="' . h($desc) . "\">\n";
    echo '<meta property="article:published_time" content="' . h($page['date_published']) . "\">\n";
    echo '<meta property="article:modified_time" content="' . h($page['date_modified']) . "\">\n";
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    echo '<meta name="twitter:title" content="' . h($title) . "\">\n";
    echo '<meta name="twitter:description" content="' . h($desc) . "\">\n";

    echo '<script type="application/ld+json">' . render_schema($slug) . "</script>\n";
}

/**
 * Build the JSON-LD @graph (WebSite, WebPage, Organization, BreadcrumbList,
 * SearchAction) exactly as the original SureRank output did.
 */
function render_schema(string $slug): string
{
    $data   = site_data();
    $domain = rtrim($data['domain'], '/');
    $page   = $data['pages'][$slug];
    $path   = $page['path'];
    $url    = $domain . $path; // no trailing slash, matching original output

    $graph = [];

    $graph[] = [
        '@type'           => 'WebSite',
        '@id'             => "$domain/#website",
        'name'            => $data['site_name'],
        'author'          => ['@id' => "$url#person"],
        'copyrightHolder' => ['@id' => "$url#person"],
        'url'             => "$domain/",
        'potentialAction' => ['@id' => "$domain/#searchaction"],
        'publisher'       => ['@id' => "$domain/#organization"],
    ];

    $webpage = [
        '@type'           => 'WebPage',
        '@id'             => "$url#webpage",
        'name'            => $page['name'],
        'author'          => ['@id' => "$url#person"],
        'inLanguage'      => $data['lang'],
        'url'             => $url,
    ];
    if ($page['breadcrumb']) {
        $webpage['breadcrumb'] = ['@id' => "$url#breadcrumblist"];
    }
    $webpage['contributor']     = ['@id' => "$url#person"];
    $webpage['copyrightHolder'] = ['@id' => "$url#person"];
    $webpage['datePublished']   = $page['date_published'];
    $webpage['dateModified']    = $page['date_modified'];
    $webpage['isPartOf']        = ['@id' => "$domain/#website"];
    $webpage['publisher']       = ['@id' => "$domain/#organization"];
    $graph[] = $webpage;

    $graph[] = [
        '@type'   => 'Organization',
        '@id'     => "$domain/#organization",
        'name'    => $data['site_name'],
        'founder' => [['@type' => 'Person', 'name' => 'admin']],
        'url'     => "$domain/",
    ];

    if ($page['breadcrumb']) {
        $items = [
            ['@type' => 'ListItem', 'position' => 1, 'item' => ['@id' => "$domain/", 'name' => 'Home']],
            ['@type' => 'ListItem', 'position' => 2, 'item' => ['@id' => $url . '/', 'name' => $page['name']]],
        ];
        $graph[] = [
            '@type'           => 'BreadcrumbList',
            'name'            => 'BreadcrumbList',
            '@id'             => "$url#breadcrumblist",
            'itemListElement' => $items,
        ];
    }

    $graph[] = [
        '@type'       => 'SearchAction',
        '@id'         => "$domain/#searchaction",
        'target'      => "$domain/?s={search_term_string}",
        'query-input' => 'required name=search_term_string',
    ];

    return json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

/**
 * Site logo. The live WordPress site has a logo image (visible in current
 * screenshots) that was added AFTER the database/file export this project
 * was built from — the asset does not exist anywhere in the supplied files.
 * Drop the real file in as assets/images/logo.svg (or .png) and it will
 * start rendering automatically; until then this preserves the same
 * accessible-but-imageless branding link the export actually contains.
 */
function render_logo(): void
{
    $data = site_data();
    $svg  = __DIR__ . '/../assets/images/logo.svg';
    $png  = __DIR__ . '/../assets/images/logo.png';
    $src  = null;
    if (is_file($svg)) {
        $src = '/assets/images/logo.svg';
    } elseif (is_file($png)) {
        $src = '/assets/images/logo.png';
    }

    echo '<span class="site-logo-img"><a aria-label="' . h($data['site_name']) . '" class="custom-logo-link transparent-custom-logo" href="/" itemprop="url" rel="home">';
    if ($src) {
        echo '<img src="' . h($src) . '" alt="' . h($data['site_name']) . '">';
    }
    echo '</a></span>';
}

/**
 * Render one <ul> of the main navigation menu, marking the current page active.
 * $id_suffix lets us render the same menu twice on a page (desktop + mobile)
 * with distinct element ids, exactly like the original theme markup.
 */
function render_nav(string $current_slug, string $ul_id, string $ul_class = 'main-header-menu ast-menu-shadow ast-nav-menu ast-flex  submenu-with-border stack-on-mobile'): void
{
    $data = site_data();
    echo '<ul id="' . h($ul_id) . '" class="' . h($ul_class) . '">';
    foreach ($data['nav'] as $item) {
        $active = $item['slug'] === $current_slug;
        $li_classes = 'menu-item menu-item-type-post_type menu-item-object-page';
        if ($item['slug'] === 'home') {
            $li_classes .= ' menu-item-home';
        }
        if ($active) {
            $li_classes .= ' current-menu-item page_item current_page_item';
        }
        $target = isset($item['target']) ? ' target="' . h($item['target']) . '"' : '';
        $aria   = $active ? ' aria-current="page"' : '';
        echo '<li class="' . h($li_classes) . '"><a' . $target . ' href="' . h($item['url']) . '"' . $aria . ' class="menu-link">' . h($item['label']) . '</a></li>';
    }
    echo '</ul>';
}
