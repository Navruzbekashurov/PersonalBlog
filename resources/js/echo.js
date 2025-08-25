import Echo from 'laravel-echo'
import Pusher from 'pusher-js'      // <-- add

// Make the Pusher client globally available for Echo
window.Pusher = Pusher

const host   = import.meta.env.VITE_REVERB_HOST || window.location.hostname
const port   = Number(import.meta.env.VITE_REVERB_PORT || 8081)
const scheme = (import.meta.env.VITE_REVERB_SCHEME || 'http').toLowerCase()

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'local-key',
    wsHost: host,
    wsPort: port,
    wssPort: port,
    forceTLS: scheme === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,               // <-- important for Reverb
    activityTimeout: 30000,
    pongTimeout: 30000,
})

// (Optional) debug hooks — guard in case connector shape differs
const conn = window.Echo?.connector?.pusher?.connection
if (conn) {
    conn.bind('connected',     () => console.log('🔗 WebSocket connected!'))
    conn.bind('disconnected',  () => console.log('❌ WebSocket disconnected!'))
    conn.bind('error',         e  => console.error('🚨 WebSocket error:', e))
    conn.bind('state_change',  s  => console.log('🔄 WS state:', s.previous, '->', s.current))
    conn.bind('ping',          () => console.log('🏓 Ping sent'))
    conn.bind('pong',          () => console.log('🏓 Pong received'))
}
