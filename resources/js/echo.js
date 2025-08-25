import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const host   = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
const port   = Number(import.meta.env.VITE_REVERB_PORT || 8080);
const scheme = import.meta.env.VITE_REVERB_SCHEME || 'http';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
});

// Private chat kanaliga subscribe
window.listenToChat = function(receiverId, currentUserId) {
    if (!window.Echo) return;

    window.Echo.private(`chat.${receiverId}`)
        .listen('MessageSent', (e) => {
            console.log('📩 Yangi xabar:', e.message.message);

            const messagesEl = document.getElementById('chatMessages');
            if (messagesEl) {
                const div = document.createElement('div');
                div.className = e.message.sender_id === currentUserId ? 'message sent' : 'message received';
                div.innerHTML = `<strong>${e.user.name}</strong><br>${e.message.message}`;
                messagesEl.appendChild(div);
                messagesEl.scrollTop = messagesEl.scrollHeight;
            }
        });
};
