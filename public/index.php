<?php

$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = explode('?', $path)[0];

include __DIR__ . '/../src/' . route($path);
exit;

////////////////////////////////////////////////////////////////

function route($path)
{
    return staticRoute($path) ?: dynamicRoute($path) ?: 'error404.php';
}


function staticRoute($path)
{
    $map = [
        '/'                     => 'index.php',
        '/recommand'            => 'recommand.php',
        '/feed'                 => 'feed.php',
        '/sitemap.xml'          => 'sitemap.php',
        '/404'                  => 'xkcd404.php',
        '/404/'                 => 'xkcd404.php',
        '/api/list_recommand'   => 'api_list_recommand.php',
        '/api/list_recommand/'  => 'api_list_recommand.php',
    ];

    return $map[$path] ?? false;
}

function dynamicRoute($path)
{
    $pathParts = preg_split('/[0-9]+/',$path, 2);
    $prefix = $pathParts[0];
    $postfix = $pathParts[1] ?? '';

    if ($postfix !== '/' && $postfix !== '') {
        return false;
    }

    $map = [
        '/'                     => 'strip.php',
        '/api/strip/original/'  => 'api_strip_original.php',
        '/api/recommand/'       => 'api_recommand.php',
    ];

    return $map[$prefix] ?? false;
}
