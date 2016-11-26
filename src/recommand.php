<?php
include __DIR__ . '/init.php';

$og['title'] = '推薦翻譯';
$og['url'] = 'http://xkcd.tw/recommand';

echo $twig->render('recommand.twig', [
    'page_title' => '推薦翻譯',
    'strip_ids' => array_keys($strips),
    'og' => $og,
]);