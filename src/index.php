<?php
include __DIR__ . '/init.php';

header("ETag: " . md5('xkcd.tw.index'));
header('Cache-Control: public, max-age=3600'); // cache 1 小時

$og['title'] = 'xkcd 中文翻譯';
$og['url'] = 'http://xkcd.tw';

echo $twig->render('index.twig', [
    'page_title' => '首頁',
    'strips' => $strips,
    'og' => $og,
]);