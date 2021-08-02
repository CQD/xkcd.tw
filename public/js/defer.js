function toRandomStrip() {
    getStrips()
        .then(e => {
            let ids = Object.keys(e)
            let randomId = ids[Math.floor(Math.random() * ids.length)]
            window.location.href = `/${randomId}`
        })
}

let currentOrder = 'translate_time';
function toggleIndexOrder() {
    let map = {
        'translate_time':'翻譯更新',
        'date':'原版',
    }
    let newOrder = currentOrder === 'translate_time' ? 'date' : 'translate_time'


    indexReorderBy(newOrder)
    let orderChanger = document.getElementById('order-changer')
    orderChanger.innerHTML = `依照${map[newOrder]}順序排列。<a href="javascript:toggleIndexOrder()">點此改為依照${map[currentOrder]}順序排列</a>`

    currentOrder = newOrder
}

function indexReorderBy(field) {
    getStrips()
        .then(strips => {
            let ids = Object.keys(strips)
            ids.sort((id1, id2) => {
                let val1 = strips[id1][field]
                let val2 = strips[id2][field]
                if (val1 > val2) return 1
                if (val1 < val2) return -1
                return 0
            })

            let listNode = document.getElementById('strip_list')

            while (listNode.firstChild) {
                listNode.firstChild.remove()
            }

            ids.forEach(id => {
                let li = document.createElement('li')

                let a = document.createElement('a')
                a.textContent = ` ${strips[id].title}`
                a.href = `/${id}`;
                li.prepend(a)

                let span = document.createElement('span')
                span.textContent = id
                a.prepend(span)

                listNode.prepend(li)
            })
        })
}


let strips = null;
function getStrips() {
    return new Promise((resolve, reject) => {
        resolve(
            strips ||
            fetch('/api/strips.json')
                .then(e => e.json())
                .then(e => strips = e)
        )
    })
}
