# Repository Guidelines

## Project Structure & Module Organization

This is a standalone Arabic, RTL static website for **Mursan Facilities (مرسان المرافق)** built with standard HTML5, CSS3, and vanilla JavaScript with no framework, database, or build step. Public routes are served from directories with `index.html` files (`index.html`, `about/index.html`, `services/index.html`, `projects/index.html`, `contact-us/index.html`, and `404.html`). Shared CSS is in `assets/css/style.css` and JavaScript is in `assets/js/main.js`. Static media lives in `assets/images/`. Apache routing, caching, and security rules are defined in `.htaccess`.

## Build, Test, and Development Commands

No dependency installation or compilation is required.

```powershell
python -m http.server 8000 --bind 127.0.0.1
```
or
```powershell
php -S 127.0.0.1:8000
```

Runs a local development server from the repository root. Visit `http://127.0.0.1:8000/`.

## Coding Style & Naming Conventions

Use clean, semantic HTML5 tags and four-space indentation. Maintain CSS custom properties defined at `:root` in `assets/css/style.css`. Preserve UTF-8 Arabic content, RTL direction (`dir="rtl"` and `lang="ar"`), and bidirectional text isolation for phone numbers (`<bdi class="sc-ltr-num">`). Keep image and file names descriptive and lowercase kebab-case.

## Testing Guidelines

Verify affected routes, navigation, Arabic direction, images, SEO metadata, sitemap output, the 404 page, and form interactions at both desktop and mobile viewports.

## Security & Configuration Tips

Ensure `.htaccess` properly serves the custom 404 error page and security headers. All links should use HTTPS in production.
