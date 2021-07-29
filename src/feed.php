<?php
$format = $_GET['f'] ?? 'atom';
$format = strtolower($format);

$format = ('rss' === $format) ? 'rss' : 'atom';

uasort($strips, function($a, $b){
    $ta = $a['translate_time'] ?? '1999-01-01';
    $ta = strtotime($ta);
    $tb = $b['translate_time'] ?? '1999-01-01';
    $tb = strtotime($tb);
    return ($ta === $tb)
        ? ($a['id'] < $b['id'] ? 1 : -1)
        : ($ta < $tb ? 1 : -1);
});

$strips = array_slice($strips, 0, 50);
foreach ($strips as $id => $strip) {
    $strips[$id]['translate_time'] = formatTime($strip['translate_time'], $format);
    if (1110 == $strip['id']) {
        $strips[$id]['img_url'] = '/img/og_1110.png';
    }
}
$finalUpdateTime = reset($strips)['translate_time'];

$template = "{$format}.twig";

header("ETag: " . md5("xkcd.tw.feed.{$format}.{$finalUpdateTime}."));
header('Cache-Control: public, max-age=10800');
header("Content-Type: application/{$format}+xml; Charset=utf-8");
echo $twig->render($template, [
    'title' => 'XKCD 中文翻譯',
    'desc' => '翻譯某個關於浪漫、諷刺、數學、以及語言的漫畫',
    'items' => $strips,
    'pub_date' => $finalUpdateTime,
]);
exit;

////////////////////////////////////////////

function formatTime($time, $format)
{
    if (!is_numeric($time)) {
        $time = strtotime($time);
    }

    if ('atom' === $format) {
        return date('c', $time); // RFC3339
    } else {
        return date('r', $time); // RFC822
    }
}