<?php
include __DIR__ . '/init.php';

$id_str = trim($_SERVER['REQUEST_URI'], '/');
$id = (int) $id_str;

if ('/' === substr($_SERVER['REQUEST_URI'], -1)) {
    header("Location: /{$id}");
    exit;
}

if (!isset($strips[$id])) {
    die404("你要看的東西我還沒翻譯到，傷心，真傷心...");
}

$strip = $strips[$id];

$strip['id'] = $id;

$strip_ids = array_keys($strips);
$pos = array_search($id, $strip_ids);
if ($pos > 0) {
    $strip['next_id'] = $strip_ids[$pos - 1];
}
if ($pos < count($strip_ids)) {
    $strip['prev_id'] = $strip_ids[$pos + 1];
}

$og['title'] = "xkcd 中文翻譯：" . $strip['title'];
$og['url'] = sprintf('http://xkcd.tw/%d', $id);
$og['image'] = sprintf('http://xkcd.tw/strip/%d.jpg', $id);

echo $twig->render('strip.twig', [
    'page_title' => $strip['title'],
    'strip' => $strip,
    'og' => $og,
    'ld' => $ld,
]);