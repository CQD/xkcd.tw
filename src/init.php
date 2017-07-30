<?php
include __DIR__ . '/../vendor/autoload.php';

$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../view'));

$og = [
];

$strips = include __DIR__ . '/data/strips.php';

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