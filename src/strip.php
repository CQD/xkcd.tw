<?php
include __DIR__ . '/init.php';

$id_str = trim($_SERVER['REQUEST_URI'], '/');
$id = (int) $id_str;

if (!isset($strips[$id])) {
    die404();
}

$strip = $strips[$id];

$strip['id'] = $id;


$og['title'] = "xkcd 翻譯：" . $strip['title'];
$og['url'] = sprintf('http://xkcd.tw/%d', $id);
$og['image'] = sprintf('http://xkcd.tw/strip/%d.jpg', $id);

echo $twig->render('strip.twig', [
    'page_title' => $strip['title'],
    'strip' => $strip,
    'og' => $og,
    'ld' => $ld,
]);