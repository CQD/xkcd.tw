<?php
$og['title'] = 'xkcd 中文翻譯';
$og['url'] = 'https://xkcd.tw';

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

$order = @$_GET['o'] ?: 'translate';
if ('translate' === $order) {
    uasort($strips, function($a, $b){
        $ta = @$a['translate_time'] ?: '1999-01-01';
        $ta = strtotime($ta);
        $tb = @$b['translate_time'] ?: '1999-01-01';
        $tb = strtotime($tb);
        return $tb <=> $ta;
    });
}

header("ETag: " . md5('xkcd.tw.index' . count($strips)));
header('Cache-Control: public, max-age=10800'); // cache 3 小時
echo $twig->render('index.twig', [
    'page_title' => '首頁',
    'strips' => $strips,
    'og' => $og,
    'ld' => $ld,
    'order' => $order,
]);