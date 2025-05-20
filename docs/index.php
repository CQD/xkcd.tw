<?php

spamBlock();

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Asia/Taipei');
header('Content-Type: text/html; Charset=utf-8');

$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../view'));

$og = [
];

$strips = require __DIR__ . '/../src/data/strips.php';
$imageMap = require __DIR__ . '/../build/image_map.php';
foreach ($strips as $id => $strip) {
    $strips[$id]['id'] = $id;
    $defaultImageUrl = isset($imageMap[$id])
        ? "/strip/{$imageMap[$id]}"
        : "/strip/{$id}.png";
    $strips[$id]['img_url'] = $strips[$id]['img_url'] ?? $defaultImageUrl;
}

$path = $_SERVER['REQUEST_URI'] ?? $argv[1] ?? '/';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? $path;

$path = explode('?', $path)[0];

require __DIR__ . '/../src/' . route($path);
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
        '/feed'                 => 'feed.php',
        '/sitemap.xml'          => 'sitemap.php',
        '/sitemap'              => 'sitemap.php',
        '/api/strips'           => 'api_strips.php',
        '/api/strips.json'      => 'api_strips.php',
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
    ];

    return $map[$prefix] ?? false;
}

////////////////////////////////////////////////////////////////

function die404()
{
    global $twig; // i hate global...

    http_response_code(404);
    echo $twig->render('404.twig');
    die();
}

function spamBlock()
{
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return;
    }

    $referer = $_SERVER['HTTP_REFERER'];

    if (false !== strpos($referer, '-seo-') || false !== strpos($referer, '-seo.')) {
        http_response_code(404);
        echo '404';
        exit;
    }
}
