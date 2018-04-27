<?php
include __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Asia/Taipei');
header('Content-Type: text/html; Charset=utf-8');

$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../view'));

$og = [
];

$strips = include __DIR__ . '/data/strips.php';
$imageMap = include __DIR__ . '/../build/image_map.php';
foreach ($strips as $id => $strip) {
    $strips[$id]['id'] = $id;
    $strips[$id]['img_url'] = @$strips[$id]['img_url'] ?: "/strip/{$imageMap[$id]}";
}

//////////////////////////////////////////////

function die404($msg = "找不到這一頁，真傷心")
{
    global $twig; // i hate global...

    http_response_code(404);
    echo $twig->render('error_404.twig', [
       'page_title' => '網頁找不到（哭',
       'msg' => $msg,
    ]);
    die();
}