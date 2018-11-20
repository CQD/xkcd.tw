<?php
header('Content-Type: application/xml');
echo '<'?>?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url><loc>https://xkcd.tw/</loc> </url>
<?php foreach ($strips as $id => $strip): ?>
<url><loc>https://xkcd.tw/<?=(int) $id?></loc></url>
<?php endforeach ?>
</urlset>