<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function show($userId)
    {
        $selectedUser = User::findOrFail($userId);
        $users = User::where('id', '!=', auth()->id())->get();

        $messages = Message::where(function($q) use ($userId) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })
            ->orderBy('created_at')
            ->get();

        return view('chat.index', compact('users', 'selectedUser', 'messages'));
    }

    // Xabar yuborish
    public function send(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent(auth()->user(), $message->message))->toOthers();

        return back();
    }
}
