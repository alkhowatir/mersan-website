# العربة الماهرة — Standalone PHP Site

Converted from WordPress (Astra + Elementor + Elementor Pro) to plain PHP.
No WordPress core, no plugins, no database required.

## Deploy

1. Upload the entire contents of this folder to `public_html` (or your web root).
2. Make sure `mod_rewrite`, `mod_headers`, `mod_deflate`, `mod_expires` are enabled
   (all standard on shared Apache hosting). If `.htaccess` overrides are disabled,
   ask your host to allow `AllowOverride All` for this directory.
3. Point your domain's DNS/vhost at this folder. That's it — no build step, no
   composer, no database setup.

## Structure

- `index.php`, `about/`, `services/`, `projects/`, `contact-us/` — one folder
  per page, each containing an `index.php`, so the public URLs are exactly the
  same as the original WordPress site (e.g. `/about/`, `/services/`).
- `includes/` — shared header/footer markup, SEO/schema helpers, and the actual
  page content (`includes/content/*.php`). Blocked from direct web access.
- `data/site.php` — **single place to edit** the site name, contact details,
  social links, nav menu, and per-page SEO text. Blocked from direct web access.
- `assets/vendor/` — the real Astra + Elementor + Elementor Pro + Font Awesome
  CSS/JS/fonts the site actually uses (only the files that are actually loaded —
  everything else from the original plugins/theme was left out).
- `assets/images/` — the real images used on the site, with ASCII-safe
  filenames (e.g. `golf-cart-sales.jpg`, `motion-bg-01.png`,
  `partner-logo-1.svg`) instead of the original WordPress upload paths/names.
- `assets/css/theme.css` and `assets/css/elementor-generated.css` — the theme's
  and Elementor's compiled styles (pulled from a real render of your site, not
  reconstructed by hand, so visual fidelity should be exact).
- `sitemap.php` — generates `/sitemap.xml` from the same data used for SEO tags.
- `404.php`, `robots.txt`, `.htaccess` — error page, crawl rules, rewrite/security/caching rules.

## Notes on what was and wasn't carried over

- **Language:** the live site is single-language Arabic (RTL). There's no
  Polylang/WPML and no English version anywhere in the export, so no bilingual
  structure was built.
- **Contact form:** recovered from the database (WPForms "Simple Contact Form",
  form_id 8) and rebuilt as a real PHP form on the Home page's "اطلب خدمتك"
  section — fields, placeholders, order, and styling were verified pixel-by-pixel
  against a real screenshot of the original site. It validates input, has a
  honeypot spam trap, and emails submissions to the address in `data/site.php`.
  PHP's `mail()` requires a configured MTA/sendmail on your host to actually
  deliver — test after deploying.
- **Nav quirk preserved on purpose:** the "الرئيسية" (Home) menu link opens in
  a new tab (`target="_blank"`) — that's how it was configured on the original
  site, so it was kept as-is rather than "fixed."
- **Projects page:** exists at `/projects/` and is in the sitemap, but (as on
  the original site) isn't linked from the main navigation.
- **SEO/schema:** title, meta description, canonical, Open Graph, Twitter Card,
  and JSON-LD (WebSite/WebPage/Organization/Breadcrumb/SearchAction) were
  reproduced to match what the SureRank plugin generated, with the domain
  swapped to `https://skilledcart.com`.
- **Logo:** the live site currently shows a real "Skilled Cart" logo image in
  the header. It does not exist anywhere in the supplied export — not in the
  uploads folder, not in the separate Aug-23 site backup, and the database's
  `custom_logo`/`site_logo` options still point at attachment #24, which is a
  leftover starter-template placeholder (`logo-urban-nest.png`), not the real
  logo. The real logo file was evidently added on the live site after this
  export was taken. `includes/functions.php` has a `render_logo()` helper
  that will automatically start rendering the real logo the moment you drop
  the file in as `assets/images/logo.svg` or `assets/images/logo.png` — no
  other code changes needed.
- Fonts (Cairo/Roboto/Open Sans/Montserrat) are loaded from Google Fonts, same
  as the original site.
- The FAQ's first question is pre-opened and the four stat counters show
  their final values immediately (no JS-dependent animation), matching what
  the original site actually displays on load — done with plain HTML/CSS plus
  a small dependency-free JS click-handler for the accordion, not Elementor's
  runtime.

## If you spot a visual difference

Everything here was built from a real, working render of the site (I actually
ran WordPress + Elementor against your database in a sandbox to get pixel-exact
HTML/CSS, rather than reverse-engineering Elementor's JSON by hand), and then
corrected against real screenshots of the live site pixel-by-pixel. If anything
still looks off after you upload it, it's most likely either the missing logo
(see above) or genuine content drift on the live site since this export was
taken — check the browser console/network tab for a 404 and let me know.
