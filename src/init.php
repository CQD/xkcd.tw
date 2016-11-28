<?php
include __DIR__ . '/../vendor/autoload.php';

$twig = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . '/../view'));

$og = [
];

$strips = [
    1761 => [
        'title' => '牽拖',
        'caption' => '我敢說如果我對著我朋友大吼大叫把他們嚇得半死，我心情會變好',
        'style' => "max-height:215px",
    ],
    1758 => [
        'title' => '天文物理',
        'caption' => '神經科學部門 / 格言：我發誓如果我聽到「鏡像神經元」這個詞的話我會翻桌',
        'style' => "max-height:314px",
    ],
    1755 => [
        'title' => '舊時光',
        'caption' => 'Lot of drama in those days, including constant efforts to force the &quot;Reflections on Trusting Trust&quot; guy into retirement so we could stop being so paranoid about compilers.',
        'style' => "max-height:530px",
    ],
    1737 => [
        'title' => '資料中心規模',
        'caption' => '艾西莫夫（最後的問題）漫畫裡的AC是藉由把每個資料中心透過超空間相連而建立起來的，這能解釋一些事情。熵沒有被逆轉，他只是在宇宙終結時扔掉它然後重新買一個新的進來。',
        'style' => "max-height:294px",
    ],
    1731 => [
        'title' => '錯了',
        'caption' => '啊，我剛想起有另外一件事情我是對的，像是這個...',
        'style' => "max-height:638px",
    ],
    1730 => [
        'title' => '掩星板',
        'caption' => 'New Worlds 任務有在爭取掩星板的預算，不過因為 NASA 有贊助，所以很難用這招嚇到他們的望遠鏡操作人員。',
        'style' => "max-height:287px",
    ],
    1728 => [
        'title' => 'Cron Mail',
        'caption' => '接招吧，我在系統上意外維護了十五年卻從來沒搞懂怎麼用的 1980 年代架構的鬼東西',
        'style' => "max-height:298px",
    ],
    1727 => [
        'title' => '電腦數量',
        'caption' => '他們為了灌水，在年度報告中把伽利略上的備援系統算成好幾台電腦。但就算這樣他們的進度還是嚴重落後。',
        'style' => "max-height:311px",
    ],
    1726 => [
        'title' => 'Unicode',
        'caption' => '我對於申請雷龍的表情符號 codepoint 的提案感到非常期待，這東西有潛力把好幾群脫離現實的書呆子扯進同一個巨大網路辯論中。',
        'style' => "max-height:461px",
    ],
    1725 => [
        'title' => '線性回歸',
        'caption' => '95%的信心區間暗示龍索的狗也可能是貓，或者是茶壺。',
        'style' => "max-height:312px",
    ],
    1723 => [
        'title' => '隕石判斷',
        'caption' => "點圖可以看到真正的隕石判斷流程圖。我覺得最有趣的部分是「有人看到他掉下來嗎？ 有 -> 那不是隕石」，他沒寫錯。",
        'style' => "max-height:213px",
        'link' => 'http://meteorites.wustl.edu/check-list.htm',
    ],
    1722 => [
        'title' => 'Debugging',
        'caption' => "如果你 google 不到你眼前的錯誤訊息，那你很可能發現了馬丁之劍的線索。",
        'style' => "max-height:258px",
    ],
    1720 => [
        'title' => '馬兒們',
        'caption' => "這台車的決策能力是馬匹的 240%，而產生的便便只有 30%。",
        'style' => "max-height:272px",
    ],
    1716 => [
        'title' => '時間旅行理論',
        'caption' => "「對了，那個看起來很帥的眼鏡是什麼」「只是壞掉的 Google Glass」",
        'style' => "max-height:298px",
    ],
    1715 => [
        'title' => '家事小技巧',
        'caption' => "如果想讓你的鞋子更舒適、不發臭、而且更耐久，可以試著在洗澡前把他們脫下來。",
        'style' => "max-height:247px",
    ],
    1693 => [
        'title' => '氧化',
        'caption' => '冷靜一點，你的皮膚上本來就住著一大堆節肢動物，那幾隻只是大一點而已。',
        'style' => "max-height:297px",
    ],

    1667 => [
        'title' => '演算法',
        'caption' => '在 2007 年發生過宗教分裂，當時有個擁護 OpenOffice 的教派複製了一份 Sunday.xlsx 並獨立維護了這個檔案幾個月，為了讓兩份衝突的行程能夠重新結合在一起，導致了新發明的誕生，在試算表的格子之中，出現了現代的版本控制系統。',
        'style' => "max-height:206px",
    ],
    1660 => [
        'title' => '機長廣播',
        'caption' => '啊靠，你有付錢嗎？嘿，有人有付錢嗎？有的話能讓我借一下你的電話嗎？',
        'style' => "max-height:315px",
    ],
    1659 => [
        'title' => '輪胎鞦韆',
        'caption' => '如果我們能找到其中一個輪胎掩埋場，那下次他來搶他的卡車的時候我們就能抽身讓他把車拿回去。',
        'style' => "max-height:530px",
    ],
    1658 => [
        'title' => '估計時間',
        'caption' => '侯世達定律：你每花一分鐘思考侯世達定律，你就有一分鐘沒在工作，而且你永遠做不完！完～～蛋～～啦～～～！',
        'style' => "max-height:278px",
    ],
    1657 => [
        'title' => '瘋狂',
        'caption' => '我在十本字典裡面找 "insanity"，沒有一本寫了類似的東西。DSM-4 裡面也沒提到。不過我會繼續找下去，搞不好 DSM-5 裡面會有！',
        'style' => "max-height:378px",
    ],
    1656 => [
        'title' => '開始了',
        'caption' => '也可以試試看「矮額～」',
        'style' => "max-height:196px",
    ],
    1654 => [
        'title' => '萬用安裝 script',
        'caption' => '失敗的時候通常不會有什麼問題，如果安裝了好幾個版本，那其中一個版本是正確版本的機會也會提高。（注意：建議加上「yes」指令跟「 2>/dev/null」）',
        'style' => "max-height:340px",
        'comment' => '這篇好像沒什麼翻譯到...',
    ],
    1652 => [
        'title' => '條件判斷',
        'caption' => '「如果你執著夠了，我們來去吃晚餐」「你又來了」「我沒有！」',
        'style' => "max-height:380px",
    ],
    1643 => [
        'title' => '溫度',
        'caption' => '「攝氏弳度還是華氏弳度？」「呃，不好意思，我先走了」',
        'style' => "max-height:284px",
    ],
    1642 => [
        'title' => '重力波',
        'caption' => '最後一筆 Linkedin 連結請求創下了天文史上發射能量最強的紀錄，也許該回他一句「鼻要」',
        'style' => "max-height:284px",
    ],
    1638 => [
        'title' => '反斜線們',
        'caption' => "我爬了一下我 .bash_history，看哪些指令有最多的特殊字元跟最少的英文字母，贏家是「cat out.txt | grep -o '[[(].*[])][^)]]*$'」...我不記得這是什麼也沒印象我原本想幹嘛，希望這行指令會動。",
        'style' => "max-height:207px",
    ],
    1636 => [
        'title' => 'XKCD 架構',
        'caption' => "此網站需要 Sun Java 6.0.0.1 (32-bit) 或更高版本，您安裝了 Macromedia Java 7.3.8.1¾ (48-bit)。點此（連結到 java.com 首頁）可以下載安裝程式，雖然他會正常執行不過什麼都不會安裝。",
        'style' => "max-height:592px",
    ],
    1633 => [
        'title' => '可能還沒發現的行星',
        'caption' => "超人在鳥跟飛機的邊界上，難怪有人會搞錯。",
        'style' => "max-height:697px",
    ],
    1613 => [
        'title' => '機器人三定律',
        'caption' => '以第五個順序來說，自動駕駛車會很樂意載你到處走，但如果你要他們開到二手車行，他們會把門鎖起來，然後有禮貌的問你餓死人類要花多久時間。',
        'style' => "max-height:570px",
    ],
    1606 => [
        'title' => '五日天氣預報',
        'caption' => '有句話是這樣說的：如果你不喜歡太陽系這裡的天氣，等個五十億年就好了。',
        'style' => 'max-height: 440px',
    ],
    1604 => [
        'title' => '蛇',
        'caption' => '最後一條色環用來標示這條蛇被人抓起來之後能容忍到什麼程度而不咬人',
        'style' => 'max-height:205px;',
    ],
    1601 => [
        'title' => '人際孤立',
        'caption' => '2060: 那些開心著彼此聊著自己怎麼離開電腦的超智慧AI已經變成了老古董。現在的量子超生物忙著做多重宇宙模擬，根本沒空發現他們自己是在電腦裡面！',
        'style' => 'max-height:243px;',
    ],
    1597 => [
        'title' => 'GIT',
        'caption' => "如果沒用的話，打開 git.txt ，裡面那支電話可以找到我一個朋友他會用 GIT。他會先跟你講幾分鐘的「這很簡單，你就把 branch 想成是....」，之後他就會告訴你一段指令，那段指令能把東西修好。",
        'style' => "max-height:478px",
    ],
    1521 => [
        'title' => '石中劍',
        'caption' => "我只是覺得這劍很酷而已，哪有那麼麻煩的..",
        'style' => "max-height:184px",
    ],
    1519 => [
        'title' => '金星',
        'caption' => "金星花卉突然進入地球，導致授粉動物的爆炸性成長。這稱為「蝴蝶效應」。",
        'style' => "max-height:271px",
    ],
    1510 => [
        'title' => '拿破崙',
        'caption' => "「總統先生，如果發生了萬一該怎麼辦？萬一火箭發射失敗，拿破崙沒有被困在月球上？」「叫 William Safire 寫一篇演講稿」",
        'style' => "max-height:923px",
    ],
    1505 => [
        'title' => '本體論證明',
        'caption' => "握有吃滑板世界紀錄的神，比起沒有該項紀錄的神更加的偉大。",
        'style' => "max-height:293px",
    ],
    1504 => [
        'title' => '機遇號',
        'caption' => "我們都記得登上火星的太空人說過的名言：這是我的一小...靠腰那看起來像是個鑽頭，快點回...[無法分辨]...[信號中斷]",
        'style' => "max-height:278px",
    ],
    1445 => [
        'title' => '效率',
        'caption' => "我的研究計畫延期，是因為我花了一個月研究 Dvorak 鍵盤會不會讓我打字比較快。",
        'style' => "max-height:214px",
    ],
    1425 => [
        'title' => '工作項目',
        'caption' => "在 60 年代，Marvin Minsky 找來一批應屆畢業生叫他們花一個夏天來寫程式用攝影機判斷拍到的物體是什麼。他當時認為夏天結束之前他們就能解決問題。半個世紀之後我們還在繼續努力。",
        'style' => "max-height:448px",
    ],
    1361 => [
        'title' => 'Google 的公告',
        'caption' => '比較不熱門的 8.8.4.4 也已經預定要終止',
        'style' => "max-height:383px",
    ],
    1342 => [
        'title' => '古代的星星',
        'caption' => '「那幾百萬顆星星發出的光芒可能已經有幾萬年了」是少數一般人會高估天文學數字的例子。',
        'style' => "max-height:243px",
    ],
    1340 => [
        'title' => '獨特日期',
        'caption' => '如果我們的文明再持續個八千年，我想可以預期長遠當代基金會能搞定一切，然後我們會乖乖聽他們的話改用五碼日期。',
        'style' => "max-height:333px",
    ],
    1338 => [
        'title' => '陸地哺乳動物',
        'caption' => '細菌的重量還是超過我們一千倍，這還沒算進人體內幾磅重的細菌。',
        'style' => "max-height:495px",
    ],
    1319 => [
        'title' => '自動化',
        'caption' => 'Automating 的字根 Auto- 意思是「自己」， mating 則是「搞」的意思',
        'style' => "max-height:408px",
    ],
//    1305 => [
//    ],
    1268 => [
        'title' => '平行宇宙',
        'caption' => '我想我應該是在1990年代後期從 Earth Prime 被傳送過來的。你們的宇宙跟我的都一樣，除了那個龍蝦什麼的以外，還有你們某些地方的人有時候會為了某些理由改掉時鐘的時間。',
        'style' => "max-height:413px",
    ],

//    1253 => [
//    ],
    1244 => [
        'title' => '一句話',
        'caption' => '嚴格說起來，我們用的是 Orbiter',
        'style' => "max-height:397px",
    ],
    1200 => [
        'title' => '授權',
        'caption' => '你先別說話，不，我才不會登入帳號以後離開我的筆電趴趴走。而且我有設定在幾分鐘沒有動作之後自動切換到我哥的帳號。',
        'style' => "max-height:342px",
    ],
    1199 => [
        'title' => '沈默',
        'caption' => '所有的音樂都是 4\'33"，只是剛好旁邊有其他樂團在演奏。',
        'style' => "max-height:235px",
    ],
    1174 => [
        'title' => 'APP',
        'caption' => '我按下 No 的時候大概表示我已經放棄了。所以別再把我轉址到剛剛我原本想打開的那頁了，帶我回首頁吧。',
        'style' => "max-height:411px",
    ],
    1168 => [
        'title' => 'TAR',
        'caption' => '不知道哪一點比較糟：用了十五年我依然沒辦法直接記住 tar 的 flag 要怎麼下，或是在十五年的科技進步之後我還是得搞這些當年就已經十五歲的 tar flag',
        'style' => "max-height:229px",
    ],
    1162 => [
        'title' => '對數刻度',
        'caption' => '高德納紙堆表示法：在紙上寫下該數字，把紙張堆起來。如果堆得太高房間塞不下，寫下寫這個數字需要的頁數。現在這個數字還是塞不進房間裡面的話，重複一次。當紙堆可以塞進房間的時候，在卡片上寫下剛剛的動作重複做了幾次，然後把卡片釘在紙堆上。',
        'style' => "max-height:400px",
    ],
    1144 => [
        'title' => '標籤',
        'caption' => '<A>:像是</a>這樣。&nbsp;',
        'style' => "max-height:57px",
    ],
    1098 => [
        'title' => '五星評分',
        'caption' => '我不小心迷路走進全世界最嚇人的葬禮，墓碑上面只有名字跟五星評分。我嚇死了。我回到家以後想要在 Yelp 上面寫一篇壞的評論文，但當我的游標移到「一顆星」的按鈕上面時，我感到一陣惡寒...',
        'style' => "max-height:310px",
    ],
    979 => [
        'title' => '前人的智慧',
        'caption' => '很長的求救文應該要讓討論串的第一篇可以被任何人編輯，開頭是「來自未來的各位，我們現在的進度是...',
        'style' => 'max-height:274px;',
    ],
    965 => [
        'title' => '元素之力',
        'caption' => '在各國之中，操縱 Uuo 的大概是最不嚇人的。操縱氙的只好人家一點，不過至少他們的霓虹燈閃閃爍爍很有宣傳效果。',
        'style' => 'max-height:452px;',
    ],
    961 => [
        'title' => '永恆之火',
        'caption' => '懷抱希望，只要等得夠久，說不定海灘球就會消失，卡住的畫面會回來。',
        'img_url' => '/strip/961.gif',
        'style' => 'max-height:223px;',
    ],
    936 => [
        'title' => '密碼安全性',
        'caption' => '對於那些理解資訊安全以及資訊理論，而且正在跟不懂的人戰的人，我誠摯的道歉。',
        'style' => 'max-height:601px;',
    ],
    932 => [
        'title' => 'CIA',
        'caption' => '那是他們的主要徵才海報，掛在牆上接近三公尺高的地方！換句話說駭客有「梯子」這種技術！未來我們是否每個人都要為了壓克力做的海報護套付出50美金的代價呢？廣告之後我們繼續...',
        'style' => 'max-height:263px;',
    ],
    927 => [
        'title' => '標準規範',
        'caption' => '還好，充電的標準已經統一成大家全部用 mini-USB。等等是 micro-USB？ 靠腰..',
        'style' => 'max-height:283px;',
    ],
    862 => [
        'title' => '放手',
        'caption' => "經過許多年，試了各種方法，我藉由讓我的缺乏耐心跟我的懶惰彼此競爭消滅了這個習慣。我將這個行為與精神上的愉悅斷開連結的方式是設定我自己在載入任何新頁面或是聊天軟體前必須要等待三十秒，這段時間我什麼事都不能做，而且我一次只能開一個。然後我想要檢查這些網站的慾望神奇的消失了，而我「有產出」的電腦使用則不受影響。",
        'style' => 'max-height:237px;',
    ],
    787 => [
        'title' => '軌道載具',
        'caption' => '正常來說，從卡納維爾角發射的太空梭不太能安全的抵達能到達這幾個點的軌道。不過這篇是平行世界，要嘛是太空梭從范登堡空軍基地發射，要嘛是大家很討厭外灘群島。',
        'style' => 'max-height:345px;',
    ],
    773 => [
        'title' => '大學網站',
        'caption' => '人們會去這些網站是因為他們等不及想看下一期的校友雜誌對吧？什麼？你說要校園地圖？我們有個 CS 學生在 2001 做了個專案，你可以點選然後縮放上面的所有東西喔！',
        'style' => "max-height:378px",
    ],
    763 => [
        'title' => 'Workaround',
        'caption' => '我曾經處理過某個朋友爸爸的電腦，他的硬碟被分成六個 partition，從 C: 到 J:，每個槽都有一個「Documents」資料夾，檔案好像是隨機存到六個槽裡面的其中一個。我知道這時候什麼都不要問。',
        'style' => "max-height:462px",
    ],
    724 => [
        'title' => '地獄',
        'caption' => '另外還有個塊魂裡面東西都只比你大一點，還有個瑪力歐的無敵星星在你剛好吃不到的地方。',
        'style' => "max-height:476px",
    ],

    695 => [
        'title' => '精神號',
        'caption' => '2010年1月26日，任務的第 2274 個火星日，NASA 宣布精神號無法移動轉為固定式研究站，預計數個月後就會因為太陽能板被塵埃覆蓋，電力不足而必須關閉。',
        'style' => "max-height:862px",
    ],
    664 => [
        'title' => '學術界 vs 商業界',
        'caption' => '有工程師已經解決了 P=NP 問題，答案被鎖在某個打蛋器校正程式裡面。我們每發現一個 0x5f375a86，背後有數千個沒有被發現的。',
        'style' => "max-height:382px",
    ],
    627 => [
        'title' => '技術支援流程圖',
        'caption' => '乖女兒，我是你爸，要怎麼列印流程圖啊？',
        'style' => "max-height:823px",
    ],
    619 => [
        'title' => '功能支援',
        'caption' => '我知道有些人已經有平滑 flash 影片支援，不過我跟我的 Intel 顯示卡還在等開發流程中的某個 kernel patch，不然我們只能看到格子狀的喬恩·史都華',
        'style' => "max-height:326px",
    ],
    600 => [
        'title' => '機器男友',
        'caption' => '這正好是我家裡面讓人最不舒服的壁爐裝飾。',
        'style' => "max-height:220px",
    ],
    503 => [
        'title' => '用詞',
        'caption' => '然後，是只有我這麼覺得，還是日本跟紐西蘭看起來超像的？有人看過他們兩個同時出現嗎？',
        'style' => "max-height:348px",
    ],
    457 => [
        'title' => '挫折',
        'caption' => '「別擔心，我花不到一分鐘就能解決」「是的，我注意到了」',
        'img_url' => '/strip/457.png',
        'style' => "max-height:279px",
    ],
    456 => [
        'title' => '警告',
        'caption' => '這是個真實故事，當事人不知道我把這個畫成漫畫是因為他的 Wifi 壞了好幾個禮拜',
        'style' => "max-height:277px",
    ],
    444 => [
        'title' => '懶惰馬蓋先',
        'caption' => '馬蓋先維基上有篇文章，標題是「List of problems solved by MacGyver」',
        'style' => "max-height:248px",
    ],
    393 => [
        'title' => '終極遊戲',
        'caption' => '安息吧，Gary',
        'style' => "max-height:188px",
    ],
    349 => [
        'title' => '成功',
        'caption' => '安裝 OpenBSD 有 40% 的機率導致鯊魚攻擊，這是他們唯一的安全性問題。',
        'style' => "max-height:947px",
    ],
    327 => [
        'title' => '媽咪攻擊',
        'caption' => '她女兒的名字是「救命！我被困在駕照工廠裡面！」',
        'style' => "max-height:205px",
    ],
    323 => [
        'title' => '鮑爾默高點',
        'caption' => 'Apple 靠的是自動化杜松子酒靜脈注射。',
        'style' => "max-height:592px",
    ],
    303 => [
        'title' => '編譯中',
        'caption' => '「你在偷 LCD 嗎？」「對，不過我是趁 code 還在編譯的時候偷的」',
        'style' => "max-height:360px",
    ],
    231 => [
        'title' => '人貓距離',
        'caption' => '是耶！你坐在那裡耶！你好啊，小貓咪！',
        'style' => "max-height:439px",
    ],
    202 => [
        'title' => 'Youtube',
        'caption' => '',
        'style' => 'max-height:860px',
    ],
];

//////////////////////////////////////////////

function die404($msg = "找不到這一頁，真傷心")
{
    global $twig; // i hate global...

    http_response_code(404);
    echo $twig->render('error_404.twig', [
       'page_title' => '網頁找不到（哭',
       'msg' => $msg,
    ]);
    die();
}