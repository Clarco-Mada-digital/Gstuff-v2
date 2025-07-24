<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessengerApiController extends Controller
{
    public function search(Request $request)
    {
        try {
            $request->validate([
                'query' => 'required|string|min:1|max:100',
            ]);

            $input = trim($request->input('query'));
            $searchTerm = "%$input%";
            $currentUserId = Auth::id();

            $users = User::where('id', '!=', $currentUserId)
                ->where(function($q) use ($searchTerm) {
                    $q->where('pseudo', 'LIKE', $searchTerm)
                      ->orWhere('prenom', 'LIKE', $searchTerm)
                      ->orWhere('nom_salon', 'LIKE', $searchTerm)
                      ->orWhere('profile_type', 'LIKE', $searchTerm);
                })
                ->whereIn('profile_type', ['escorte', 'salon'])
                ->get();

            return response()->json([
                'users' => $users,
                'user_id' => $currentUserId
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche : ' . $e->getMessage());
            return response()->json([
                'error' => 'Une erreur est survenue lors de la recherche',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function fetchUserInfo(Request $request)
    {
        $userId = Auth::id();
        $contactId = $request->id;

        $user = User::where('id', $contactId)->firstOrFail();
        $favorite = Favorite::where(['user_id' => $userId, 'favorite_user_id' => $contactId])->exists();

        $sharedPhotos = Message::where(function($query) use ($userId, $contactId) {
            $query->where(['from_id' => $userId, 'to_id' => $contactId])
                  ->orWhere(['from_id' => $contactId, 'to_id' => $userId]);
        })
        ->whereNotNull('attachment')
        ->latest()
        ->get();

        $sharedLinks = Message::where(function($query) use ($userId, $contactId) {
            $query->where(['from_id' => $userId, 'to_id' => $contactId])
                  ->orWhere(['from_id' => $contactId, 'to_id' => $userId]);
        })
        ->whereNotNull('body')
        ->where(function($query) {
            $query->where('body', 'like', '%http://%')
                  ->orWhere('body', 'like', '%https://%');
        })
        ->latest()
        ->get();

        $totalMessages = Message::where(function($query) use ($userId, $contactId) {
            $query->where(['from_id' => $userId, 'to_id' => $contactId])
                  ->orWhere(['from_id' => $contactId, 'to_id' => $userId]);
        })
        ->count();

        return response()->json([
            'user' => $user,
            'favorite' => $favorite,
            'shared_photos' => $sharedPhotos,
            'shared_links' => $sharedLinks,
            'stats' => [
                'photos_count' => $sharedPhotos->count(),
                'links_count' => $sharedLinks->count(),
                'total_messages' => $totalMessages
            ]
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required_without:attachment',
            'id' => 'required|integer',
            'attachment' => 'nullable|max:1024|image'
        ]);

        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $message->attachment = $attachmentPath;
        }

        $message->save();

        event(new MessageSent($message));

        return response()->json([
            'message' => $message,
            'success' => true,
            'message_text' => 'Message sent successfully'
        ], 200);
    }

    public function fetchMessages(Request $request)
    {
        $messages = Message::where(function($query) use ($request) {
            $query->where(['from_id' => Auth::user()->id, 'to_id' => $request->id])
                  ->orWhere(['from_id' => $request->id, 'to_id' => Auth::user()->id]);
        })
        ->latest()
        ->paginate(20);

        if ($messages->isEmpty()) {
            return response()->json([
                'messages' => 'No messages found'
            ]);
        }

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function fetchContacts(Request $request)
    {
        $users = Message::join('users', function($join) {
            $join->on('messages.from_id', '=', 'users.id')
                 ->orOn('messages.to_id', '=', 'users.id');
        })
        ->where(function($q) {
            $q->where('messages.from_id', Auth::user()->id)
              ->orWhere('messages.to_id', Auth::user()->id);
        })
        ->where('users.id', '!=', Auth::user()->id)
        ->select('users.*', \DB::raw('MAX(messages.created_at) as max_created_at'))
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.id')
        ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'contacts' => 'No contacts found'
            ]);
        }

        return response()->json([
            'contacts' => $users
        ]);
    }

    public function updateContactItem(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function makeSeen(Request $request)
    {
        Message::where('from_id', $request->id)
            ->where('to_id', Auth::user()->id)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        return response()->json(['success' => true]);
    }

    public function favorite(Request $request)
    {
        $favoriteStatus = Favorite::where(['user_id' => Auth::user()->id, 'favorite_user_id' => $request->id])->exists();

        if (!$favoriteStatus) {
            $star = new Favorite();
            $star->user_id = Auth::user()->id;
            $star->favorite_user_id = $request->id;
            $star->save();

            return response()->json(['status' => 'added']);
        } else {
            Favorite::where(['user_id' => Auth::user()->id, 'favorite_user_id' => $request->id])->delete();

            return response()->json(['status' => 'removed']);
        }
    }

    public function deleteMessage(Request $request)
    {
        $message = Message::findOrFail($request->message_id);

        if ($message->from_id == Auth::user()->id) {
            $message->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Message deleted successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete message'
        ], 403);
    }

    public function fetchUnreadMessagesCount(Request $request)
{
    $userId = Auth::user()->id;

    $unreadCounts = Message::where('to_id', $userId)
        ->where('seen', 0)
        ->selectRaw('from_id, COUNT(*) as unread_count')
        ->groupBy('from_id')
        ->get()
        ->pluck('unread_count', 'from_id');

    return response()->json([
        'unread_counts' => $unreadCounts
    ]);
}

}
