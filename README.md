# xkcd 中文翻譯 xkcd.tw

這是網路漫畫 [xkcd](https://xkcd.com) 的非官方翻譯。

修圖程式為 sketch，使用的字型為 Mac OS 內建的翩翩體-繁體（HanziPen TC）。

網址為 [xkcd.tw](https://xkcd.tw)。過去跑 PHP 放在 Google App Engine 上，後來改為放在 Github Page 上，原本的 PHP 程式用來產生靜態頁面以及本機快速開發用。

# 程式介面

提供兩組可以自動撈取資料的程式介面：

- https://xkcd.tw/feed 是 ATOM Feed，可用閱讀器訂閱
- https://xkcd.tw/api/strips.json 列出所有已翻譯項目的資料，格式為 JSON
