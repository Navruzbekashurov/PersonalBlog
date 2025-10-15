import Echo from 'laravel-echo'

// 🔧 .env orqali sozlamalar
const host   = import.meta.env.VITE_REVERB_HOST || window.location.hostname
const port   = Number(import.meta.env.VITE_REVERB_PORT || 80)
const scheme = (import.meta.env.VITE_REVERB_SCHEME || 'http').toLowerCase()
const secure = scheme === 'https'

console.log('🔌 Echo config:', {
    key: import.meta.env.VITE_REVERB_APP_KEY,
    host,
    port,
    secure,
})

// Echo obyektini yaratamiz
window.Echo = new Echo({
    broadcaster: 'reverb',   // 🔹 Pusher emas, Reverb ishlatyapmiz
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: host,
    wsPort: port,
    wssPort: port,
    forceTLS: secure,
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
})

// 📩 Chat tinglovchi funksiya
window.listenToChat = function(receiverId, currentUserId) {
    if (!window.Echo) {
        console.error("❌ Echo hali yuklanmagan")
        return
    }

    console.log(`👂 chat.${receiverId} kanaliga ulanyapti...`)

    window.Echo.private(`chat.${receiverId}`)
        .listen('MessageSent', (e) => {
            console.log('📩 Yangi xabar:', e.message.message)

            const messagesEl = document.getElementById('chatMessages')
            if (messagesEl) {
                const div = document.createElement('div')
                div.className = e.message.sender_id === currentUserId ? 'message sent' : 'message received'
                div.innerHTML = `<strong>${e.user.name}</strong><br>${e.message.message}`
                messagesEl.appendChild(div)
                messagesEl.scrollTop = messagesEl.scrollHeight
            }
        })
}

// ✅ Test kanalini tinglash
window.Echo.private('test')
    .listen('TestEvent', (e) => {
        console.log('✅ TestEvent keldi:', e.message)
    })
