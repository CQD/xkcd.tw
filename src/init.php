<?php
include __DIR__ . '/../vendor/autoload.php';

$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../view'));

$og = [
];

$strips = [
    1657 => [
        'title' => '瘋狂',
        'caption' => '我在十本字典裡面找 "insanity"，沒有一本寫了類似的東西。DSM-4 裡面也沒提到。不過我會繼續找下去，搞不好 DSM-5 裡面會有！',
        'style' => "max-height:400px",
    ],
    1656 => [
        'title' => '開始了',
        'caption' => '也可以試試看「矮額～」',
        'style' => "max-height:200px",
    ],
    1652 => [
        'title' => '條件判斷',
        'caption' => '「如果你執著夠了，我們來去吃晚餐」「你又來了」「我沒有！」',
        'style' => "max-height:400px",
    ],
    1642 => [
        'title' => '重力波',
        'caption' => '最後一筆 Linkedin 連結請求創下了天文史上發射能量最強的紀錄，也許該回他一句「鼻要」',
        'style' => "max-height:300px",
    ],
    1638 => [
        'title' => '反斜線們',
        'caption' => "我爬了一下我 .bash_history，看哪些指令有最多的特殊字元跟最少的英文字母，贏家是「cat out.txt | grep -o '[[(].*[])][^)]]*$'」...我不記得這是什麼也沒印象我原本想幹嘛，希望這行指令會動。",
        'style' => "max-height:300px",
    ],
    1633 => [
        'title' => '可能還沒發現的行星',
        'caption' => "超人在鳥跟飛機的邊界上，難怪有人會搞錯。",
        'style' => "max-height:700px",
    ],
    1601 => [
        'title' => '人際孤立',
        'caption' => '2060: 那些開心著彼此聊著自己怎麼離開電腦的超智慧AI已經變成了老古董。現在的量子超生物忙著做多重宇宙模擬，根本沒空發現他們自己是在電腦裡面！'
    ],
    1597 => [
        'title' => 'GIT',
        'caption' => "如果沒用的話，打開 git.txt ，裡面那支電話可以找到我一個朋友他會用 GIT。他會先跟你講幾分鐘的「這很簡單，你就把 branch 想成是....」，之後他就會告訴你一段指令，那段指令能把東西修好。",
        'style' => "max-height:500px",
    ],
//    1305 => [
//    ],
//    1253 => [
//    ],
    1244 => [
        'title' => '一句話',
        'caption' => '嚴格說起來，我們用的是 Orbiter',
        'style' => "max-height:400px",
    ],
    936 => [
        'title' => '密碼安全性',
        'caption' => '對於那些理解資訊安全以及資訊理論，而且正在跟不懂的人戰的人，我誠摯的道歉。',
    ],
    695 => [
        'title' => '精神號',
        'caption' => '2010年1月26日，任務的第 2274 個火星日，NASA 宣布精神號無法移動轉為固定式研究站，預計數個月後就會因為太陽能板被塵埃覆蓋，電力不足而必須關閉。',
        'style' => "max-width:600px",
    ],
    327 => [
        'title' => '媽咪攻擊',
        'caption' => '她女兒的名字是「救命！我被困在駕照工廠裡面！」'
    ],

];

//////////////////////////////////////////////

function die404()
{
    global $twig; // i hate global...

    http_response_code(404);
    echo $twig->render('error_404.twig', [
       'page_title' => '網頁找不到（哭',
    ]);
    die();
}