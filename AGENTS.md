# Repository Guidelines

## Project Structure & Module Organization

This is a standalone Arabic, RTL PHP site with no framework, database, or build step. Public routes have entry points such as `index.php`, `about/index.php`, and `services/index.php`. Shared scaffolding and helpers live in `includes/`; page markup is under `includes/content/`. Keep contact details, navigation, social links, and SEO metadata in `data/site.php` rather than duplicating them. Static files belong in `assets/`. Apache routing, caching, and security rules are defined in `.htaccess`.

## Build, Test, and Development Commands

No dependency installation or compilation is required.

```powershell
php -S 127.0.0.1:8000
```

Runs a local development server from the repository root. Visit `http://127.0.0.1:8000/`; note that PHP's built-in server does not apply `.htaccess` rewrites.

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

Checks every PHP file for syntax errors. Before deployment, also test the site under Apache so rewrites, security headers, compression, and `/sitemap.xml` behave as configured.

## Coding Style & Naming Conventions

Use four-space indentation in PHP and follow the existing brace style. Add scalar parameter and return types where practical. Name functions and array keys in `snake_case`, page directories in lowercase kebab-case, and image/CSS files descriptively (for example, `golf-cart-rental.jpg`). Escape dynamic HTML with the existing `h()` helper. Preserve UTF-8 Arabic content and RTL behavior. Avoid editing minified or vendored assets unless replacing their upstream source.

## Testing Guidelines

There is no automated test framework or coverage requirement. Every change must pass PHP linting and receive manual browser checks at desktop and mobile widths. Verify affected routes, navigation, Arabic direction, images, SEO metadata, sitemap output, the 404 page, and form validation. For form changes, confirm invalid input is rejected and user input remains escaped.

## Commit & Pull Request Guidelines

The history currently contains only `first commit`, so no established convention exists. Use short, imperative commit subjects such as `Fix mobile navigation spacing`. Keep commits focused. Pull requests should explain the user-visible change, list tested routes and commands, link relevant issues, and include before/after screenshots for visual work. Call out changes to `.htaccess`, contact handling, canonical URLs, or deployment configuration explicitly.

## Security & Configuration Tips

Do not commit credentials or server-specific secrets. Treat `data/site.php` as public configuration. Keep form validation, the honeypot, and output escaping intact, and test email delivery only on a host with a configured PHP mail transport.
