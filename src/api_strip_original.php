<?php
header('Content-type: application/json');

$id = explode('/', $_SERVER['REQUEST_URI'])[4];

$cache_key = "api_cache_strip_original_{$id}";
$url = "https://xkcd.com/{$id}/info.0.json";

$memcache = class_exists('Memcached') ? new Memcached : null;
$cached_data = $memcache ? $memcache->get($cache_key) : null;

if ($cached_data) {
    echo $cached_data;
    exit;
}

$data = file_get_contents($url);

if ($memcache) {
    $memcache->set($cache_key, $data);
}

echo $data;