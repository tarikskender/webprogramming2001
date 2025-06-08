<?php
// router.php

// 1) if using the PHP built-in server, check if the requested URI maps to an actual file
if (php_sapi_name() === 'cli-server') {
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $urlPath;
    if (is_file($file)) {
        // serve the file directly
        return false;
    }
}

// 2) decide which paths go to FlightPHP
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// any of these prefixes should be routed into your backend
$apiPrefixes = ['backend','tasks','users','categories','friends','follows'];
$pattern = '#^/(' . implode('|', $apiPrefixes) . ')#';

if (preg_match($pattern, $uri)) {
    // hand off to FlightPHP
    require __DIR__ . '/backend/index.php';
    return;
}

// 3) otherwise let the built-in server try to serve from disk (e.g. your frontend/)
return false;
