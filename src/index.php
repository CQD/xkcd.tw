<?php
include __DIR__ . '/init.php';

header("ETag: " . md5('xkcd.tw.index' . date('Y-m-d')));
header('Cache-Control: public, max-age=3600'); // cache 1 小時

$og['title'] = 'xkcd 中文翻譯';
$og['url'] = 'http://xkcd.tw';

$ld = [
    "@context" => "http://schema.org/",
    "@type" => "ComicSeries",
    "description" => "某個關於浪漫、諷刺、數學、以及語言的漫畫",
    "name" => "xkcd",
    "sameAs" => "https://xkcd.com",
    "inLanguage" => "zh-Hant-TW",
    "author" => [
        "@type" => "Person",
        "name" => "Randall Munroe",
        "sameAs" => 'https://en.wikipedia.org/wiki/Randall_Munroe',
    ],
];

echo $twig->render('index.twig', [
    'page_title' => '首頁',
    'strips' => $strips,
    'og' => $og,
    'ld' => $ld,
]);