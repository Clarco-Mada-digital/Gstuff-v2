<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        $sender = Auth::user();
        broadcast(new NewMessage($message, $sender))->toOthers();

        // Notification Email et In-App
        $receiver->notify(new NewChatMessageNotification($message, Auth::user()));

        return response()->json(['status' => 'Message Sent!', 'message' => $message]); // Retourner le message pour l'afficher immédiatement dans l'UI
    }

    public function getMessages(Request $request, $receiver_id)
    {
        $messages = Message::where(function ($query) use ($receiver_id) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($receiver_id) {
            $query->where('sender_id', $receiver_id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function showChatForm(User $receiver)
    {
        
        return view('chat.form', ['receiver' => $receiver]);
    }
}
