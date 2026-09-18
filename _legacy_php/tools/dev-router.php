<?php

declare(strict_types=1);

$project_root = dirname(__DIR__);
$request_path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if (!is_string($request_path)) {
    http_response_code(400);
    exit('Bad Request');
}

$request_path = rawurldecode(str_replace('\\', '/', $request_path));

if (str_contains($request_path, "\0")) {
    http_response_code(400);
    exit('Bad Request');
}

$segments = array_values(array_filter(
    explode('/', $request_path),
    static fn (string $segment): bool => $segment !== ''
));

if (in_array('..', $segments, true)) {
    http_response_code(400);
    exit('Bad Request');
}

$first_segment = $segments[0] ?? '';
$protected_directories = ['data', 'includes', 'tools'];

if (
    in_array($first_segment, $protected_directories, true)
    || str_starts_with($first_segment, '.')
) {
    http_response_code(404);
    require $project_root . DIRECTORY_SEPARATOR . '404.php';
    return true;
}

if ($request_path === '/sitemap.xml') {
    require $project_root . DIRECTORY_SEPARATOR . 'sitemap.php';
    return true;
}

$relative_path = implode(DIRECTORY_SEPARATOR, $segments);
$candidate = $project_root . ($relative_path !== ''
    ? DIRECTORY_SEPARATOR . $relative_path
    : '');

if (is_file($candidate)) {
    if (strtolower(pathinfo($candidate, PATHINFO_EXTENSION)) === 'php') {
        require $candidate;
        return true;
    }

    return false;
}

$index_file = $candidate . DIRECTORY_SEPARATOR . 'index.php';

if (is_dir($candidate) && is_file($index_file)) {
    require $index_file;
    return true;
}

http_response_code(404);
require $project_root . DIRECTORY_SEPARATOR . '404.php';

return true;
