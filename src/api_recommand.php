<PRE><?php

use Google\Cloud\Storage\StorageClient;

(new StorageClient())->registerStreamWrapper();

$log_file_name = 'gs://xkcd-tw/recommand.log';

$id = explode('/', $_SERVER['REQUEST_URI'])[3];

$log = file_get_contents($log_file_name);
$log .= json_encode([
    'strip_id' => $id,
    'renote_addr' => $_SERVER['REMOTE_ADDR'],
    'http_cookie' => $_SERVER['HTTP_COOKIE'],
    'date_time' => date('Y-m-d H:i:s'),
    'time' => time(),
]);
$log .= "\n";

file_put_contents($log_file_name, $log);
