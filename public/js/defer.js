function toRandomStrip() {
    return fetch('/api/strips.json')
        .then(e => e.json())
        .then(e => {
            let ids = Object.keys(e)
            let randomId = ids[Math.floor(Math.random() * ids.length)]
            window.location.href = `/${randomId}`
        })
}
