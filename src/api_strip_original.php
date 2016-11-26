<?php
header('Content-type: application/json');

$id = explode('/', $_SERVER['REQUEST_URI'])[4];

$cache_key = "api_cache_strip_original_{$id}";
$url = "http://xkcd.com/{$id}/info.0.json";


$memcache = new Memcached;

$cached_data = $memcache->get($cache_key);
if ($cached_data) {
    echo $cached_data;
    exit;
}


$data = file_get_contents($url);

$memcache->set($cache_key, $data);
echo $data;