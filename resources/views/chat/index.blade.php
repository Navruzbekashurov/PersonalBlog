<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>

    {{-- Styles --}}
    <style>
        .chat-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            height: 75vh;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
        }
        .users { background: #f9fafb; overflow-y: auto; }
        .users h3 { padding: 14px; background: #e0e7ff; margin: 0; }
        .user { display:block; padding: 12px; cursor: pointer; text-decoration: none; color: inherit; border-bottom: 1px solid #e5e7eb; }
        .user:hover { background: #f3f4f6; }
        .user.active { background: #bfdbfe; }
        .chat { display: flex; flex-direction: column; }
        .chat-header { padding: 14px; background: #e0e7ff; font-weight: bold; }
        .messages { flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; }
        .message { max-width: 65%; margin-bottom: 10px; padding: 10px 15px; border-radius: 20px; }
        .sent { background: #3b82f6; color: white; align-self: flex-end; }
        .received { background: #e5e7eb; color: #1f2937; align-self: flex-start; }
        .chat-input { display: flex; border-top: 1px solid #e5e7eb; padding: 8px; gap: 8px; }
        .chat-input input { flex: 1; border: 1px solid #d1d5db; border-radius: 20px; padding: 8px 12px; outline: none; }
        .chat-input button { background: #3b82f6; color: white; padding: 8px 16px; border-radius: 20px; border: none; cursor: pointer; }
        .chat-input button:hover { background: #2563eb; }
    </style>

    @vite('resources/js/app.js') {{-- agar umumiy Vite bundle ishlatilsa --}}
    <script>
        // Chat listener for MessageSent events
        window.listenToChat = function(receiverId, currentUserId) {
            console.log('🚀 Setting up chat listener for receiver:', receiverId, 'current user:', currentUserId);
            
            // Listen to the chat channel
            const channel = window.Echo.channel('chat');
            
            // Debug: Log when we successfully join the channel
            channel.subscribed(() => {
                console.log('✅ Successfully subscribed to chat channel');
            });
            
            // Debug: Log any subscription errors
            channel.error((error) => {
                console.error('❌ Error subscribing to chat channel:', error);
            });
            
            // Listen for MessageSent events
            channel.listen('.message.sent', (data) => {
                console.log('📨 Received message.sent event:', data);
                
                // Only show messages intended for the current conversation
                if (data.message.receiver_id === currentUserId || data.message.sender_id === currentUserId) {
                    addMessageToChat(data);
                } else {
                    console.log('🔄 Message not for current conversation, ignoring');
                }
            });
            
            // Debug: Listen to all events on this channel
            channel.listen('*', (eventName, data) => {
                console.log('🎧 Raw event received:', eventName, data);
            });
        };

        // Function to add received message to the chat UI
        function addMessageToChat(data) {
            const messagesContainer = document.getElementById('chatMessages');
            if (!messagesContainer) {
                console.warn('⚠️ Messages container not found');
                return;
            }
            
            // Create message element
            const messageDiv = document.createElement('div');
            const currentUserId = window.currentUserId || null;
            const isOwnMessage = data.message.sender_id === currentUserId;
            
            messageDiv.className = `message ${isOwnMessage ? 'sent' : 'received'}`;
            messageDiv.innerHTML = `
                <strong>${data.user.name}</strong><br>
                ${data.message.message}
            `;
            
            // Add to messages container
            messagesContainer.appendChild(messageDiv);
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
            console.log('✅ Message added to chat UI');
        }

        // Debug function to test Echo connection
        window.testEchoConnection = function() {
            console.log('🔍 Testing Echo connection...');
            console.log('Echo instance:', window.Echo);
            
            if (window.Echo) {
                console.log('✅ Echo is available');
                
                // Test basic channel subscription
                const testChannel = window.Echo.channel('test-channel');
                testChannel.subscribed(() => {
                    console.log('✅ Test channel subscription successful');
                    testChannel.unsubscribe();
                });
                testChannel.error((error) => {
                    console.error('❌ Test channel subscription failed:', error);
                });
            } else {
                console.error('❌ Echo is not available');
            }
        };

        // Debug function to manually trigger a test event
        window.triggerTestMessage = function() {
            console.log('🧪 Triggering test message event...');
            
            fetch('/api/test-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: 'Test message from frontend',
                    receiver_id: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ Test message triggered:', data);
            })
            .catch(error => {
                console.error('❌ Failed to trigger test message:', error);
            });
        };

        console.log('📡 Chat listener script loaded');
    </script>
</head>
<body>
<div class="chat-container">

    <!-- Users list -->
    <div class="users">
        <h3>Users</h3>
        @foreach($users as $user)
            <a href="{{ route('chat.show', $user->id) }}"
               class="user {{ isset($selectedUser) && $selectedUser->id === $user->id ? 'active' : '' }}">
                <div><strong>{{ $user->name }}</strong></div>
                <small>{{ $user->email }}</small>
            </a>
        @endforeach
    </div>

    <!-- Chat area -->
    <div class="chat">
        <div class="chat-header">
            {{ $selectedUser ? $selectedUser->name : 'No user selected' }}
        </div>

        <div class="messages" id="chatMessages">
            @if($selectedUser)
                @forelse($messages as $message)
                    <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                        <strong>{{ $message->sender->name }}</strong><br>
                        {{ $message->message }}
                    </div>
                @empty
                    <div class="text-gray-500">No messages yet</div>
                @endforelse
            @else
                <div class="text-gray-500">Select a user to start chatting</div>
            @endif
        </div>

        @if($selectedUser)
            <form action="{{ route('chat.send', $selectedUser->id) }}" method="POST" class="chat-input">
                @csrf
                <input type="text" name="message" placeholder="Type your message..." required>
                <button type="submit">Send</button>
            </form>
        @endif
    </div>
</div>

<script>
    // Always scroll to bottom on load
    window.addEventListener('load', () => {
        const messages = document.getElementById('chatMessages');
        if (messages) messages.scrollTop = messages.scrollHeight;
    });
</script>

{{-- Echo JS --}}
@vite('resources/js/echo.js')

<script type="module">
    const receiverId = @json($selectedUser->id ?? null);
    const currentUserId = @json(auth()->id());
    
    // Make current user ID globally available
    window.currentUserId = currentUserId;
    
    if (receiverId) {
        // Wait for Echo to be ready
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (window.Echo && window.listenToChat) {
                    window.listenToChat(receiverId, currentUserId);
                } else {
                    console.error('❌ Echo or listenToChat function not available');
                }
            }, 1000); // Give Echo time to initialize
        });
    }
</script>

<!-- Debug Panel (remove in production) -->
<div style="position: fixed; bottom: 10px; right: 10px; background: #f3f4f6; padding: 10px; border-radius: 5px; font-size: 12px;">
    <strong>Debug Panel</strong><br>
    <button onclick="window.testEchoConnection()" style="margin: 2px; padding: 5px; font-size: 11px;">Test Echo</button><br>
    <button onclick="window.triggerTestMessage()" style="margin: 2px; padding: 5px; font-size: 11px;">Test Message</button><br>
    <button onclick="console.log('Echo:', window.Echo)" style="margin: 2px; padding: 5px; font-size: 11px;">Log Echo</button>
</div>
</body>
</html>
