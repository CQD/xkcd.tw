<?php
include __DIR__ . '/init.php';

if ('/' === substr($_SERVER['REQUEST_URI'], -1)) {
    header("Location: /404");
    exit;
}

$og['title'] = "xkcd 翻譯：404" . $strip['title'];
$og['url'] = 'http://xkcd.tw/404';

echo $twig->render('xkcd_404.twig', [
    'page_title' => '404',
]);