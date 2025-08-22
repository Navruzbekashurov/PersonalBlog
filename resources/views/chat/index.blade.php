
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

<script>
    // Always scroll to bottom
    window.addEventListener('load', () => {
        const messages = document.getElementById('chatMessages');
        if (messages) {
            messages.scrollTop = messages.scrollHeight;
        }
    });
</script>
