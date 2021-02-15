<?php
header('Content-Type: application/xml');
echo '<'?>?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<url><loc>https://xkcd.tw/</loc> </url>
<?php foreach ($strips as $id => $strip): ?>
<url>
<loc>https://xkcd.tw/<?=(int) $id?></loc>
<image:image>
<image:loc>https://xkcd.tw<?=$strip['img_url']?></image:loc>
<image:title><?=htmlspecialchars($strip['title'])?></image:title>
<image:license>https://creativecommons.org/licenses/by-nc/2.5/</image:license>
</image:image>
</url>
<?php endforeach ?>
<url><loc>https://xkcd.tw/s/314_date_calculator.html</loc></url>
<url><loc>https://xkcd.tw/s/936_password_generator.html</loc></url>
<url><loc>https://xkcd.tw/s/1110/map.html</loc></url>
</urlset>
