<PRE><?php

use Google\Cloud\Storage\StorageClient;

(new StorageClient())->registerStreamWrapper();

$log_file_name = 'gs://xkcd-tw/recommand.log';

$log = file_get_contents($log_file_name);
echo $log;
