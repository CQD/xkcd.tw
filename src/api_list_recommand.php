<PRE><?php
$log_file_name = 'gs://xkcd-tw/recommand.log';

$log = file_get_contents($log_file_name);
echo $log;
