<?php
include __DIR__ . '/init.php';

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

foreach ($strips as $id => $strip) {
    $strips[$id]['id'] = $id;
}
$order = @$_GET['o'] ?: 'publish';
if ('translate' === $order) {
    uasort($strips, function($a, $b){
        $ta = @$a['translate_time'] ?: '1999-01-01';
        $ta = strtotime($ta);
        $tb = @$b['translate_time'] ?: '1999-01-01';
        $tb = strtotime($tb);
        return ($ta === $tb)
            ? ($a['id'] < $b['id'] ? 1 : -1)
            : ($ta < $tb ? 1 : -1);
    });
}

header("ETag: " . md5('xkcd.tw.index' . count($strips)));
header('Cache-Control: public, max-age=3600'); // cache 1 小時
echo $twig->render('index.twig', [
    'page_title' => '首頁',
    'strips' => $strips,
    'og' => $og,
    'ld' => $ld,
    'order' => $order,
]);