<?php
$id_str = trim($_SERVER['REQUEST_URI'], '/');
$id = (int) $id_str;

if ('/' === substr($_SERVER['REQUEST_URI'], -1)) {
    header("Location: /{$id}");
    exit;
}

if (!isset($strips[$id])) {
    die404("你要看的東西我還沒翻譯到，傷心，真傷心...");
}

// 取出本回資料
$strip = $strips[$id];

// 拉出上一頁跟下一頁
$strip_ids = array_keys($strips);
$pos = array_search($id, $strip_ids);
$strip['next_id'] = $strip_ids[$pos - 1] ?? null;
$strip['prev_id'] = $strip_ids[$pos + 1] ?? null;

// OG
$strip_img_url = sprintf('https://xkcd.tw/%s', ltrim($strip['img_url'], '/'));
$og_image_url = $strip['og']['image'] ?? $strip_img_url;
$og['title'] = "xkcd 中文翻譯：" . $strip['title'];
$og['url'] = sprintf('https://xkcd.tw/%d', $id);
$og['image'] = $og_image_url;

if (0 !== strpos($og['image'], 'https://') && 0 !== strpos($og['image'], 'http://')) {
    $og['image'] = "https://xkcd.tw/" . ltrim($og['image'], '/');
}

if (isset($strip['og'])) {
    $og = array_merge($og, $strip['og']);
}

// JSON-LD
$ld = [
    "@context" => "http://schema.org/",
    "@type" => "ComicIssue",
    "issueNumber" => $id,
    "name" => $strip['title'],
    "image" => $strip_img_url,
    "thumbnailUrl" => $og_image_url,
    "datePublished" => date('Y-m-d', strtotime($strip['translate_time'])),
    "translationOfWork" => [
        "@type" => "ComicIssue",
        "sameAs" => sprintf("https://xkcd.com/%d/", $id),
    ],
    "translator" => [
        "@type" => "Person",
        "name" => "CQD",
        "sameAs" => "https://cqd.tw",
    ],
    "inLanguage" => "zh-Hant-TW",
    "author" => [
        "@type" => "Person",
        "name" => "Randall Munroe",
        "sameAs" => 'https://en.wikipedia.org/wiki/Randall_Munroe',
    ],
    "isPartOf" => [
        "@type" => "ComicSeries",
        "name" => "xkcd",
        "description" => "某個關於浪漫、諷刺、數學、以及語言的漫畫",
        "sameAs" => "https://xkcd.tw",
        "translationOfWork" => "https://xkcd.com",
        "translator" => [
            "@type" => "Person",
            "name" => "CQD",
            "sameAs" => "https://cqd.tw",
        ],
        "inLanguage" => "zh-Hant-TW",
        "author" => [
            "@type" => "Person",
            "name" => "Randall Munroe",
            "sameAs" => 'https://en.wikipedia.org/wiki/Randall_Munroe',
        ],
    ],
];
$ld = array_filter($ld);

// cache
$etagBase = sprintf(
    "xkcd.tw.strip.%s.%s.%s.%s",
    $id,
    $strip['prev_id'] ?: '',
    $strip['next_id'] ?: '',
    $strip['translate_time']
);
header("ETag: " . md5($etagBase));
header('Cache-Control: public, max-age=86400'); // cache 1 天

// 輸出
echo $twig->render($strip['template'] ?? 'strip.twig', [
    'page_title' => $strip['title'],
    'strip' => $strip,
    'og' => $og,
    'ld' => $ld,
]);