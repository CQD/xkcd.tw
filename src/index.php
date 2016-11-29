<?php
include __DIR__ . '/init.php';

$og['title'] = 'xkcd 中文翻譯';
$og['url'] = 'http://xkcd.tw';

echo $twig->render('index.twig', [
    'page_title' => '首頁',
    'strips' => $strips,
    'og' => $og,
]);