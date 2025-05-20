/**
 *  你都看到了，不要跟別人說，噓～～
 */

$(function() {
    let docs = {
        'ls': '看有三小檔案',
        'cd': 'pro2',
        'man': '上了天堂',
        'woman': '被玫瑰刺傷',
        'cat': '一種會喵喵叫的動物',
        'tar': '不要掙扎，你以後下的參數也會是錯的',
        'kill': '我的大哥哥 不要叫我大哥\n我的大哥哥 不要叫我大哥\n我不做大哥已經很久了\n你再叫我大哥就殺死你\n殺你殺你 哎呦哎呦\n殺你殺你 哎呦哎呦\n啦啦啦啦啦啦啦啦\n你再叫我大哥就殺死你',
    }

    let session = {
        'username': 'guest',
        'pwd' : '/',
    }

    let filesystem = {
        'welcome.txt': '歡迎使用 unixkcd-tw 主控台\n\n`xkcd {id}` 可以看指定的漫畫\n`ls strips` 可以看到漫畫清單\n\n用 `ls` `cd` `cat` 可以瀏覽檔案系統\n',
        'why.txt': 'https://uni.xkcd.com <= 這是某一年的愚人節玩笑',
        'strips' : {},
        'bin': {}
    }

    let strips = {}
    fetch('/api/strips.json')
    .then(d => d.json())
    .then(function(d){
        let lastStrip, lastStripTime = '1999-01-01 00:00:00';

        strips = d
        for (let id in d) {
            let strip = d[id]
            filesystem.strips[id.toString()] = function(){
                term.echo(`[${strip.id}] ${strip.title}`)
                runCommand('image', ['image', strip.img_url])
                term.echo(`https://xkcd.tw/${strip.id}`)
            }

            if (lastStripTime < strip.translate_time) {
                lastStrip = strip
                lastStripTime = strip.translate_time
            }
        }

        let step = 60
        let gap = 700
        let offset = 0

        let foo = [
            `xkcd ${lastStrip.id}`,
            'cat welcome.txt',
        ].forEach(cmd => {

            let c = ''
            for (let i = 0; i < cmd.length; i++) {
                c += cmd[i]
                let foo = c
                setTimeout(e => term.set_command(foo), offset);
                offset += step
            }
            setTimeout(e => {term.exec(cmd); term.set_command('')}, offset);
            offset += gap
        })

    })

    let getFilesystem = function(path){
        path = normalizePath(path)

        let pwd = filesystem
        path.split('/').forEach(function(p){
            if (pwd && typeof pwd == 'object') {
                pwd = p ? ((p in pwd) ? pwd[p] : null) : filesystem
            } else {
                pwd = null
            }
        })
        return pwd
    }

    let normalizePath = function (path){
        path = path.replace(/^~/, '/')
        let stack = path.charAt(0) == '/'
            ? []
            : session.pwd.split('/').filter(p => p);

        path.split('/').forEach(function(p){
            if (!p || p == '.') {
                // do nothing
            } else if (p == '..') {
                stack.pop()
            } else {
                stack.push(p)
            }
        })

        path = '/' + stack.join('/')
        return path
    }

    let cmds = {
        'apt-get': function(argv){
            let action = argv[1] || null
            let ops = {
                'update': '哞哞哞地更新了套件資訊',
                'upgrade': '哞哞哞地更新了一大堆套件',
                'dist-upgrade': '哞哞哞的你的 Ubuntu 就升級升到爛掉了',
                'install': argv[2] ? '哞哞哞的折騰了半天結果還是裝不起來' : '你想裝什麼？',
                'remove': argv[2] ? '哞哞哞的折騰了半天結果還是砍不掉' : '你想砍什麼？',
                'purge': argv[2] ? '哞哞哞的折騰了半天結果把不該砍的東西砍掉了' : '你想砍什麼？',
            }

            if (1 === argv.length) {
                this.cowsay(['cowsay', "APT 有著超牛力量"])
            } else if ('moo' == action) {
                term.echo("你今天哞了沒？")
            } else if (!ops[action]) {
                term.echo("E: 不合法的操作 " + action)
            } else if (!session.sudo) {
                term.echo('權限不足')
            } else {
                term.echo(ops[action])
            }
        },
        'make': function(argv) {
            let action = argv[1] || null
            let ops = {
                'love': '>/////<',
                'fuck': '你壞壞',
            }
            if (!action) {
                term.echo("你要 make 什麼？")
            } else if ('make-me-a-sandwitch' == argv.join('-')) {
                term.echo(session.sudo ? "好" : "不要，你自己去做");
            } else if (ops[action]) {
                term.echo(ops[action])
            } else {
                term.echo("我不知道怎麼 make " + action +" 所以人家不依")
            }
        },
        'telnet': function(argv){
            if (1 == argv.length) {
                term.echo('請輸入主機位址')
            } else if (-1 != ['ptt.cc', 'bbsu@ptt.cc', 'bbs@ptt.cc', 'ptt'].indexOf(argv[1])) {
                openorecho('https://term.ptt.cc/')
            } else {
                term.echo('不過就算告訴我主機位址，我還是不會連線的')
            }
        },
        'sudo': function(argv) {
            if (2 > argv.length) {
                let msg = '你想幹嘛？'
                if (session.sudodepth > 0) {
                    msg = `你想幹嘛...都${new Array(session.sudodepth).fill('').map(e => '可以').join('...')}...`
                }
                term.echo(msg)
                return
            }
            session.sudo = true
            session.sudodepth++
            runCommand(argv[1], argv.slice(1))
        },
        'login': function(argv){
            if (!argv[1]) {
                term.echo('站住口令誰')
            } else if ('root' === argv[1]) {
                term.echo('只要我們有根，明春，明春來時，我們又會枝繁葉茂，宛如新生。')
            } else {
                session.username = argv[1]
                term.set_prompt()
            }
        },
        'cd': function(argv){
            let path = argv[1] || '~'
            let tgt = getFilesystem(path)

            if (!tgt) {
                term.echo(path + ': 檔案或資料夾不存在');
            } else if (typeof tgt !== 'object') {
                term.echo(path + ': 不是個資料夾');
            } else {
                session.pwd = normalizePath(path)
            }
        },
        'ls': function(argv) {
            let path = argv[1] || ''
            let tgt = getFilesystem(path)

            if (!tgt) {
                term.echo(path + ': 檔案或資料夾不存在');
                return
            }

            if (typeof tgt == 'string' || typeof tgt === 'function') {
                term.echo(path)
            } else {
                let colors = {
                    'object': 'blue',
                    'function': 'cyan',
                }
                let files = {}
                let maxNameLen = 0
                for (key in tgt) {
                    files[key] = colors[typeof tgt[key]] || ''
                    maxNameLen = Math.max(maxNameLen, key.length)
                }

                let outstring = ''
                let rowLen = 0
                for (key in files) {
                    if (rowLen + maxNameLen > term.cols() * 0.9) {
                        outstring += '\n'
                        rowLen = 0
                    }
                    let color = files[key]
                    let name = key.padStart(maxNameLen, '\xa0')
                    outstring += ` [[;${color};]${name}]`
                    rowLen += maxNameLen + 1
                }
                term.echo(outstring)
            }
        },
        'cat': function(argv) {
            if (!argv[1]) {
                term.echo('是小貓咪耶！')
                return
            }

            let path = argv[1]
            let tgt = getFilesystem(path)

            if (!tgt) {
                term.echo(path + ': 檔案或資料夾不存在');
            } else if (typeof tgt == 'object') {
                term.echo(path + ': 這是一個資料夾');
            } else if (typeof tgt == 'string') {
                term.echo(tgt);
            } else if (typeof tgt == 'function') {
                term.echo('印出了一些亂碼然後你發現這是個執行檔');
            } else {
                term.echo('恭喜你，找到 bug 了 :/');
            }
        },
        'file': function(argv){
            let path = argv[1] || null

            if (!path) {
                term.echo('所以我說那個檔案呢？')
                return
            }
            let tgt = getFilesystem(path)
            if (!tgt) {
                term.echo(path + ': 檔案或資料夾不存在')
                return
            }

            let filetype = {
                'function':'是個執行檔',
                'object':'是個資料夾',
                'string':'是個文字檔',
            }[typeof tgt] || '這啥？怎麼會出現在這裡？'
            term.echo(path + ": " + filetype)
        },
        'help': function(argv){
            let helper = argv[1] || null
            if (!helper) {
                term.echo('你叫破喉嚨吧，沒有人會來救你的')
            } else if (helper == '破喉嚨') {
                term.echo('我就是沒有人，我來救你了')
            } else if (docs[helper]) {
                this.man(argv)
            } else {
                term.echo('你叫' + helper + '吧，沒有人會來救你的')
            }
        },
        'man': function(argv) {
            let cmd = argv[1] || null
            let home = `${argv[0]}-${cmd}`
            if (!cmd) {
                term.echo(('man' === argv[0]) ? '男人' : '女人')
            } else if (home === 'man-man' || home === 'woman-woman') {
                term.echo('破壞傳統價值')
            } else if (home === 'man-woman' || home === 'woman-man') {
                term.echo('守護傳統價值')
            } else if (docs[cmd]) {
                term.echo(docs[cmd])
            } else {
                term.echo('靠你自己就能搞懂那是什麼的啦，我相信你')
            }
        },
        'bash': function(argv){
            let tgt = argv[1] || '可愛的小兔子'
            term.echo('你把你的頭砸向' + tgt + '，對' + tgt + '造成很大的精神傷害')
        },
        'top': function(argv){
            let rows = [
                ['PID', 'USER', 'MEMORY', 'CPU', 'COMMAND'],
                [
                    '32767',
                    session.username,
                    Math.floor(100000 * Math.random()) + '' + Math.floor(100000 * Math.random()),
                    Math.floor(1000 * Math.random()) + '%',
                    argv[0]
                ]
            ]

            let d = 100;
            for (let i = 0; i < 8; i++) {
                rows.push([
                    (i + 1) + '',
                    'root',
                    Math.floor(1000000 * Math.random()) + '',
                    Math.floor(Math.sqrt(10000 * Math.random())) + '%',
                    'system' + String.fromCharCode(d + i)
                ])
            }

            let usernamelen = Math.max(4, rows[1][0].length)
            rows.forEach(function(row){
                term.echo(
                    row[0].padStart(5, '\xa0') + '  ' +
                    row[1].padStart(usernamelen, '\xa0') + '  ' +
                    row[2].padStart(10, '\xa0') + '  ' +
                    row[3].padStart(4, '\xa0') + '  ' +
                    row[4]
                )
            });
        },
        'kill': function(argv){
            let tgt = argv[1] || null
            if (!tgt || isNaN(tgt)) {
                tgt = tgt || '可愛的兔子'
                let msgs = [
                    `${tgt}一個漂亮的側翻閃過你的攻擊了。`,
                    `你閃躲過${tgt}的攻擊了。`,
                    `${tgt}騰空躍起讓你攻擊完全落空了。`,
                    `你閃躲過${tgt}的攻擊了。`,
                    `${tgt}迅速往後一退讓你的攻擊落空了。`,
                    `你閃躲過${tgt}的攻擊了。`,
                    `${tgt}低下身來閃躲過你的攻擊了。`,
                    `你閃躲過${tgt}的攻擊了。`,
                    `[[;lime;]你突刺${tgt}，對它造成][[;red;]****石-破-天-驚-的-創-傷****].(1),
${tgt}已經斷氣，倒在地上死亡了!!,
[[b;gold;]你共獲得了【1】點的經驗點數。],
你聽到${tgt}淒厲地哀嚎，跪倒在地上。,
你把【一些金幣】從【${tgt}的屍體】拿出來。,
你估算一下裡面共有【1】枚金幣。`
                ]

                term.pause()

                let delay = 700
                for (let i = 0; i < msgs.length; i++) {
                    let msg = msgs[i]
                    setTimeout(function(){term.echo(msg)}, delay * i)
                }
                setTimeout(function(){term.resume()}, delay * ( msgs.length - 1) + 50)
            } else {
                if (session.sudo) {
                    term.echo('Process 殺掉了以後又長回來了')
                } else {
                    term.echo('權限不足')
                }
            }
        },
        'date': function(){
            if (session.sudo) {
                term.echo('我會跟你約會')
            } else {
                term.echo('我不會跟你約會')
            }
        },
        'flee': '你逃不掉的，到天涯海角我都會找到你',
        'sh': '噓～安靜一點～',
        'zsh': '潮',
        'tar': '你下的參數是錯的',
        'pwd': '你身處在濃霧環繞的迷宮之中',
        'look': function(argv){
            let tgt = argv[1] || null
            if (!tgt) {
                term.echo('你身處在濃霧環繞的迷宮之中')
            } else if (getFilesystem(tgt)) {
                this.file(argv)
            } else {
                term.echo('你以為你看到了什麼，但你其實什麼都沒看到')
            }
        },
        'sleep': function(argv){
            let sleeptime = parseInt(argv[1]) || 5
            term.echo(`你沈睡了 ${sleeptime} 秒鐘`);
            term.pause()
            setTimeout(function(){term.resume()}, sleeptime * 1000)
        },
        'cls': function(){term.exec('clear')},
        'why': function(){runCommand('cat', ['cat', '~/why.txt'])},
        'game': '你覺得遊戲很好玩，然後浪費了許多人生',
        'vi': '你應該用 emacs',
        'vim': '你應該用 emacs',
        'emacs': '你應該用 vim',
        'ed': '你才ed',
        'nano': ['你應該用小畫家', '你應該用筆記本', '你應該用 notepad++'],
        'pico': ['你應該用小畫家', '你應該用筆記本', '你應該用 notepad++'],
        'notepad': ['你應該用小畫家', '你應該用 notepad++', '你應該用 Ultraedit'],
        'notepad++': ['你應該用小畫家', '你應該用筆記本', '你應該用 Ultraedit'],
        'ultraedit': ['你應該用小畫家', '你應該用筆記本', '你應該用 notepad++'],
        'mspaint': function(){openorecho('https://jspaint.app')},
        'git': [
            'conflict 解不掉',
            'rebase 之後爛了',
            '註解寫「改了一點東西」跟沒寫是一樣的',
            '沒事不要 force push master',
            function(){term.echo('<img src="https://xkcd.tw/strip/1597.jpg">', {raw:true})}
        ],
        'who': 'Docter Who?',
        'su': '這一刻，你將成為神....然後你被其他神趕走了',
        'love': '我也愛你',
        'hate': '懼而後憤、憤而後憎、憎而後大家屁股一起痛',
        'fuck': '不要啦',
        'shit': '髒髒',
        'hi': '你好',
        'echo': function(argv){
            let s = argv.slice(1).join('~') || '啊'
            term.echo(s+'~~~'+s+'~~~'+s+'~~~')
        },
        'tree': '長得像大～樹～一樣高～',
        'ping': '....發現潛艇，前方三浬，方位225，深度10公尺',
        'dig': '你挖了一個洞',
        'whois': function (argv) {
            if (argv.length <= 1) {
                term.echo('你說誰是誰？')
            } else {
                term.echo(`${argv.slice(1).join(' ')} 是誰很重要嗎？`)
            }
        },
        'nslookup': '上面沒什麼好看的',
        'python': '沒有大括號的傢伙得意什麼，哼哼',
        'node': 'no 的',
        'php': '不過是個樣版引擎',
        'java': '囉唆的傢伙',
        'ruby': '連 RPG maker 都改用 javascript 了，你在等什麼？',
        'gcc': '不要以為你會指標就在那邊得意',
        'g++': '不要以為你書比較厚就在那邊得意',
        'clang': '不要以為你後面有蘋果就在那邊得意',
        'ps': '這年頭用美肌相機比較快',
        'uname': 'Illudium Q-36 Explosive Space Modulator',
        'whoami': 'https://www.google.com.tw/search?q=%E5%A4%B1%E6%99%BA\n趁早認識失智症，你還有救',
        'cqd': '做你現在看到的東西的傢伙 => https://cqd.tw',
        'exit': '你無處可逃',
        'logout': '你無處可逃',
        'ag': '雄辯是銀',
        'docker': '不必',
        'wc': '這裡沒有廁所，你應該挖洞',
        'wget': '去用 curl',
        'curl': function(argv){
            let url = null;
            argv.forEach(arg => {
                arg = arg.toLowerCase()
                let has_http = (arg.indexOf("http://") == 0 || arg.indexOf("https://") == 0)
                let has_dot = arg.match(/[^\\/]\.[a-z]/)
                if (has_http || has_dot) {
                    url = arg
                }
            })

            if (!url) {
                term.echo('所以我說那個網址呢？')
            } else {
                term.echo(
`<html>
<head>
    <title>網頁標題</title>
</head>
<body>
    <h1>網頁標題</h1>
    <p>其實我是騙你的</p>
</body>
</html>`
                )
            }
        },
        'sl': function(argv){
            term.echo(
                '<iframe width="560" height="315" src="https://www.youtube.com/embed/r4VvlwHAGtQ?autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                {raw:true}
            )
        },
        'cowsay': function (argv) {
            let max_width = 40

            let width = Math.min(term.cols() - 2, max_width)

            argv.shift()
            let msg = argv.join(' ').trim() || "哞"

            term.echo(`/${'-'.repeat(width - 2)}\\`)
            term.echo(`<div style="margin-left:1em; width:${width}ex;">${escape_html(msg)}</div>`, {raw:true})
            term.echo(`\\${'_'.repeat(width - 2)}/
   \\  ^__^
      (oo)\\_______
      (__)\\       )\\/\\
          ||----w |
          ||     ||`)
        },
        'reboot': function(argv){
            if (session.sudo) {
                term.echo('重新啟動中...')
                term.pause()
                setTimeout(() => window.location.reload(), 500)
            } else {
                term.echo('不下呂布')
            }
        },
        'mkdir': '你打開了通往異世界的大資料夾',
        'xkcd': function(argv) {
            if (!argv[1]) {
                term.echo('某個畫的漫畫很純的美國人 => https://xkcd.com')
                return
            }

            let file = `~/strips/${argv[1]}`
            let id = argv[1]

            if (getFilesystem(file)) {
                runCommand(file, [file])
            } else if ('404' === id) {
                term.echo('xkcd 沒有 404 漫畫，只有 404 找不到')
            } else {
                term.echo(`我手上沒有 xkcd ${id} 的中文翻譯`)
            }
        },
        'commandnotfound': function(argv) {
            let cmd = getFilesystem(argv[0])
            if (cmd && typeof cmd == 'function') {
                cmd(argv)
            } else {
                term.echo(argv[0] + ": 找不到這個指令")
            }
        },
        'image': function(argv){
            term.echo(`<img src="${escape_html(argv[1])}">`, {raw:true})
        }
    }

    cmds.apt   = cmds['apt-get']
    cmds.paint = cmds.mspaint
    cmds.ssh   = cmds.telnet
    cmds.dir   = cmds.ls
    cmds.woman = cmds.man
    cmds.restart = cmds.reboot
    cmds.moo   = cmds.cowsay

    Object.keys(cmds).forEach(cmd => filesystem.bin[cmd] = function(argv){cmds[cmd](argv)})
    delete filesystem.bin['commandnotfound']

    let runCommand = function(name, argv){
        argv = argv ? argv.filter(p => {return p.charAt(0) != '-'}) : argv
        name = name.replace(/^sh+$/,'sh')
        if (!name) {
            return
        } else if (!cmds[name]) {
            runCommand('commandnotfound', argv)
        } else if (typeof cmds[name] === 'function') {
            cmds[name](argv)
        } else if (typeof cmds[name] === 'string') {
            term.echo(cmds[name])
        } else if (Array.isArray(cmds[name])) {
            let item = cmds[name][Math.floor(Math.random() * cmds[name].length)];
            if (typeof item === 'string') {
                term.echo(item)
            } else if (typeof item === 'function') {
                item(argv)
            } else {
                term.echo("唔，你找到 bug 了，你好棒");
            }
        }
        setTimeout(function(){term.scroll_to_bottom()}, 100)
    }

    let $body = $('body');
    $body.children().remove();
    let term = $body.terminal(function(input, term){
        session.sudo = false
        session.sudodepth = 0

        let argv = input.trim().split(/\s+/)
        let cmd = argv[0]
        runCommand(cmd, argv)

        gtag && gtag('event', 'cmd_input', {
            'event_category': 'unixkcd'
        });
    }, {
        greetings: '[[;white;]unixkcdtw\n這裡翻譯某個關於浪漫、諷刺、數學、以及語言的漫畫]\n\n',
        checkArity: false,
        completion: function(string, callback) {
            let full = this.get_command()
            let matches = []
            if (full !== string) {
                let pathParts = string.split('/')
                let base = pathParts.slice(0, -1).join('/')
                let file = pathParts.slice(-1)
                let pattern = new RegExp(`^${file}`)

                matches = Object.keys(getFilesystem(base))
                    .filter(path => path.match(pattern))
                    .map(path => base ? `${base}/${path}` : path)
            } else {
                let pattern = new RegExp(`^${string}`)
                matches = Object.keys(cmds)
                    .filter(cmd => cmd.match(pattern)
                        && 'commandnotfound' !== cmd
                        && 'image' !== cmd
                    )
            }
            matches.sort()
            callback(matches)
        },
    })

    term.set_prompt(function(set_prompt){
        set_prompt(`[[;white;]${session.username}@xkcd-tw] ${session.pwd} [[;gold;]$ ]`)
        document.title = session.username + '@xkcd-tw - xkcd 中文翻譯主控台';
    })

    $('.terminal').on('load', 'img', function(e){
        setTimeout(function(){term.scroll_to_bottom()}, 100)
    })

    window.term = term
})

function openorecho(url){
    window.open(url) || term.echo(`自己點連結 => ${url}`)
}

function escape_html(text)
{
    let e = document.createElement('div');
    e.textContent = text
    text = e.innerHTML
    e.remove()
    return text;
}