console.log("✅ Echo.js yuklandi");

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'local-key',
    wsHost: 'localhost',
    wsPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws'],
});
