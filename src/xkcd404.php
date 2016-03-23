<?php
include __DIR__ . '/init.php';
$og['title'] = "xkcd 翻譯：404" . $strip['title'];
$og['url'] = 'http://xkcd.tw/404';

echo $twig->render('xkcd_404.twig', [
    'page_title' => '404',
]);