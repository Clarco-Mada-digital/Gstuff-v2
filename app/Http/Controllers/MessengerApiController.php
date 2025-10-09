<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
          $messages = Message::where('from_id', Auth::user()->id)->where('to_id', $request->id)
            ->orWhere('from_id', $request->id)->where('to_id', Auth::user()->id)
            ->latest()->paginate(20);

        if ($messages->isEmpty()) {
            return response()->json([
                'messages' => 'No messages found'
            ]);
        }

        return response()->json([
            'messages' => $messages
        ]);
    }

    // public function fetchContacts(Request $request)
    // {
    //     $users = Message::join('users', function($join) {
    //         $join->on('messages.from_id', '=', 'users.id')
    //              ->orOn('messages.to_id', '=', 'users.id');
    //     })
    //     ->where(function($q) {
    //         $q->where('messages.from_id', Auth::user()->id)
    //           ->orWhere('messages.to_id', Auth::user()->id);
    //     })
    //     ->where('users.id', '!=', Auth::user()->id)
    //     ->select('users.*', \DB::raw('MAX(messages.created_at) as max_created_at'))
    //     ->orderBy('max_created_at', 'desc')
    //     ->groupBy('users.id')
    //     ->get();

    //     if ($users->isEmpty()) {
    //         return response()->json([
    //             'contacts' => 'No contacts found'
    //         ]);
    //     }

    //     return response()->json([
    //         'contacts' => $users
    //     ]);
    // }


    // public function fetchContacts(Request $request)
    // {
    //     try {
    //         $users = Message::join('users', function($join) {
    //             $join->on('messages.from_id', '=', 'users.id')
    //                  ->orOn('messages.to_id', '=', 'users.id');
    //         })
    //         ->where(function($q) {
    //             $q->where('messages.from_id', Auth::user()->id)
    //               ->orWhere('messages.to_id', Auth::user()->id);
    //         })
    //         ->where('users.id', '!=', Auth::user()->id)
    //         ->select('users.*', 'messages.body as last_message', 'messages.created_at as last_message_time', 'messages.from_id as last_message_from_id')
    //         ->orderBy('last_message_time', 'desc')
    //         ->groupBy('users.id')
    //         ->get()
    //         ->map(function ($user) {
    //             $isOnline = false;
    //             if ($user->last_seen_at) {
    //                 $lastSeen = $user->last_seen_at instanceof Carbon
    //                     ? $user->last_seen_at
    //                     : Carbon::parse($user->last_seen_at);
    //                 $isOnline = $lastSeen->gt(now()->subMinutes(2));
    //             }
    
    //             $lastMessage = $user->last_message ? substr($user->last_message, 0, 30) . '...' : 'No messages yet';
    //             $lastMessageFromId = $user->last_message_from_id == Auth::user()->id ? 'You: ' : '';
    
    //             return [
    //                 'id' => $user->id,
    //                 'prenom' => $user->prenom,
    //                 'pseudo' => $user->pseudo,
    //                 'nom_salon' => $user->nom_salon,
    //                 'avatar' => $user->avatar,
    //                 'is_online' => $isOnline,
    //                 'last_message' => $lastMessageFromId . $lastMessage,
    //                 'last_message_time' => $user->last_message_time
    //             ];
    //         });
    
    //         if ($users->isEmpty()) {
    //             return response()->json([
    //                 'contacts' => 'No contacts found'
    //             ]);
    //         }
    
    //         return response()->json([
    //             'contacts' => $users
    //         ]);
    
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching contacts: ' . $e->getMessage());
    //         return response()->json([
    //             'error' => 'An error occurred while fetching contacts.'
    //         ], 500);
    //     }
    // }

    
// public function fetchContacts(Request $request)
// {
//     try {
//         $users = Message::join('users', function($join) {
//             $join->on('messages.from_id', '=', 'users.id')
//                  ->orOn('messages.to_id', '=', 'users.id');
//         })
//         ->where(function($q) {
//             $q->where('messages.from_id', Auth::user()->id)
//               ->orWhere('messages.to_id', Auth::user()->id);
//         })
//         ->where('users.id', '!=', Auth::user()->id)
//         ->select('users.*', 'messages.body as last_message', 'messages.created_at as last_message_time', 'messages.from_id as last_message_from_id', 'messages.attachment as attachment')
//         ->orderBy('last_message_time', 'desc')
//         ->groupBy('users.id')
//         ->get()
//         ->map(function ($user) {
//             $isOnline = false;
//             if ($user->last_seen_at) {
//                 $lastSeen = $user->last_seen_at instanceof Carbon
//                     ? $user->last_seen_at
//                     : Carbon::parse($user->last_seen_at);
//                 $isOnline = $lastSeen->gt(now()->subMinutes(2));
//             }

//             $lastMessageFromId = $user->last_message_from_id == Auth::user()->id ? 'You: ' : '';

//             if ($user->attachment) {
//                 $lastMessage = 'Image';
//             } else {
//                 $lastMessage = $user->last_message ? substr($user->last_message, 0, 30) . '...' : 'No messages yet';
//             }

//             return [
//                 'id' => $user->id,
//                 'prenom' => $user->prenom,
//                 'pseudo' => $user->pseudo,
//                 'nom_salon' => $user->nom_salon,
//                 'avatar' => $user->avatar,
//                 'is_online' => $isOnline,
//                 'last_message' => $lastMessageFromId . $lastMessage,
//                 'last_message_time' => $user->last_message_time
//             ];
//         });

//         if ($users->isEmpty()) {
//             return response()->json([
//                 'contacts' => 'No contacts found'
//             ]);
//         }

//         return response()->json([
//             'contacts' => $users
//         ]);

//     } catch (\Exception $e) {
//         Log::error('Error fetching contacts: ' . $e->getMessage());
//         return response()->json([
//             'error' => 'An error occurred while fetching contacts.'
//         ], 500);
//     }
// }

// public function fetchContacts(Request $request)
// {
//     try {

        
//         $users = Message::join('users', function($join) {
//             $join->on('messages.from_id', '=', 'users.id')
//                  ->orOn('messages.to_id', '=', 'users.id');
//         })
//         ->where(function($query) {
//             $query->where('messages.from_id', Auth::user()->id)
//                   ->orWhere('messages.to_id', Auth::user()->id);
//         })
//         ->where('users.id', '!=', Auth::user()->id)
//         ->select(
//             'users.*',
//             'messages.body as last_message',
//             'messages.created_at as last_message_time',
//             'messages.from_id as last_message_from_id',
//             'messages.attachment as attachment'
//         )
//         ->orderBy('messages.created_at', 'desc')
//         ->groupBy('users.id')
//         ->get()
//         ->map(function ($user) {
//             $isOnline = false;
//             if ($user->last_seen_at) {
//                 $lastSeen = $user->last_seen_at instanceof Carbon
//                     ? $user->last_seen_at
//                     : Carbon::parse($user->last_seen_at);
//                 $isOnline = $lastSeen->gt(now()->subMinutes(2));
//             }

//             $lastMessageFromId = Message::where('from_id', Auth::user()->id)->where('to_id', $user->id)
//             ->orWhere('from_id', $user->id)->where('to_id', Auth::user()->id)
//             ->latest()->first();
//             $lastMessage = $user->attachment ? 'Image' : ($user->last_message ? substr($user->last_message, 0, 30) . '...' : 'No messages yet');

//             return [
//                 'id' => $user->id,
//                 'prenom' => $user->prenom,
//                 'pseudo' => $user->pseudo,
//                 'nom_salon' => $user->nom_salon,
//                 'avatar' => $user->avatar,
//                 'is_online' => $isOnline,
//                 'last_message' => $lastMessageFromId,
//                 'last_message_time' => $lastMessageFromId->created_at,
//                 'viewer_id' => Auth::user()->id,
//             ];
//         });

//         $users = $users->sortByDesc('last_message_time');

//         if ($users->isEmpty()) {
//             return response()->json(['contacts' => 'No contacts found']);
//         }
//         $users = $users->values()->all(); // Convert the collection to an array

//         return response()->json(['contacts' => $users]);

//     } catch (\Exception $e) {
//         Log::error('Error fetching contacts: ' . $e->getMessage());
//         return response()->json(['error' => 'An error occurred while fetching contacts.', 'message' => $e->getMessage()], 500);
//     }
// }
// public function fetchContacts(Request $request)
// {
//     try {
//         $users = Message::join('users', function($join) {
//             $join->on('messages.from_id', '=', 'users.id')
//                  ->orOn('messages.to_id', '=', 'users.id');
//         })
//         ->where(function($query) {
//             $query->where('messages.from_id', Auth::user()->id)
//                   ->orWhere('messages.to_id', Auth::user()->id);
//         })
//         ->where('users.id', '!=', Auth::user()->id)
//         ->select(
//             'users.*',
//             'messages.body as last_message',
//             'messages.created_at as last_message_time',
//             'messages.from_id as last_message_from_id',
//             DB::raw("jsonb_build_object('attachment', messages.attachment) as attachment")
//         )
//         ->orderBy('messages.created_at', 'desc')
//         ->get()
//         ->unique('id')
//         ->map(function ($user) {
//             $isOnline = false;
//             if ($user->last_seen_at) {
//                 $lastSeen = $user->last_seen_at instanceof Carbon
//                     ? $user->last_seen_at
//                     : Carbon::parse($user->last_seen_at);
//                 $isOnline = $lastSeen->gt(now()->subMinutes(2));
//             }

//             $lastMessageFromId = Message::where(function($query) use ($user) {
//                 $query->where('from_id', Auth::user()->id)->where('to_id', $user->id)
//                       ->orWhere(function($query) use ($user) {
//                           $query->where('from_id', $user->id)->where('to_id', Auth::user()->id);
//                       });
//             })
//             ->latest()
//             ->first();

//             if($user->last_message){
//                 $lastMessage = isset($user->attachment['attachment']) ? 'Image' : ($user->last_message ? substr($user->last_message, 0, 30) . '...' : 'No messages yet');
//             }else if($user->attachment){
//                 $lastMessage = __('chat.attachment');
//             }else{
//                 $lastMessage = __('chat.no_messages_yet');
//             }
//             $datalog = [
//                 'id' => $user->id,
//                 'prenom' => $user->prenom,
//                 'pseudo' => $user->pseudo,
//                 'nom_salon' => $user->nom_salon,
//                 'avatar' => $user->avatar,
//                 'is_online' => $isOnline,
//                 'reellast_message' => $user->last_message,
//                 'last_message' => $lastMessage,
//                 'last_message_time' => $lastMessageFromId ? $lastMessageFromId->created_at : null,
//                 'viewer_id' => Auth::user()->id,
//             ];
//             Log::info($datalog);
//             return [
//                 'id' => $user->id,
//                 'prenom' => $user->prenom,
//                 'pseudo' => $user->pseudo,
//                 'nom_salon' => $user->nom_salon,
//                 'avatar' => $user->avatar,
//                 'is_online' => $isOnline,
//                 'last_message' => $lastMessage,
//                 'last_message_time' => $lastMessageFromId ? $lastMessageFromId->created_at : null,
//                 'viewer_id' => Auth::user()->id,
//             ];
//         });

//         $users = $users->sortByDesc('last_message_time')->values()->all();

//         if (empty($users)) {
//             return response()->json(['contacts' => 'No contacts found']);
//         }

//         return response()->json(['contacts' => $users]);
//     } catch (\Exception $e) {
//         Log::error('Error fetching contacts: ' . $e->getMessage());
//         return response()->json(['error' => 'An error occurred while fetching contacts.', 'message' => $e->getMessage()], 500);
//     }
// }


public function fetchContacts(Request $request)
{
    try {
        // Fonction utilitaire pour nettoyer les chaînes mal encodées
        function cleanUtf8($value) {
            return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'UTF-8') : $value;
        }

        $users = Message::join('users', function($join) {
            $join->on('messages.from_id', '=', 'users.id')
                 ->orOn('messages.to_id', '=', 'users.id');
        })
        ->where(function($query) {
            $query->where('messages.from_id', Auth::user()->id)
                  ->orWhere('messages.to_id', Auth::user()->id);
        })
        ->where('users.id', '!=', Auth::user()->id)
        ->select(
            'users.*',
            'messages.body as last_message',
            'messages.created_at as last_message_time',
            'messages.from_id as last_message_from_id',
            DB::raw("jsonb_build_object('attachment', messages.attachment) as attachment")
        )
        ->orderBy('messages.created_at', 'desc')
        ->get()
        ->unique('id')
        ->map(function ($user) {
            $isOnline = false;
            if ($user->last_seen_at) {
                $lastSeen = $user->last_seen_at instanceof Carbon
                    ? $user->last_seen_at
                    : Carbon::parse($user->last_seen_at);
                $isOnline = $lastSeen->gt(now()->subMinutes(2));
            }

            $lastMessageFromId = Message::where(function($query) use ($user) {
                $query->where('from_id', Auth::user()->id)->where('to_id', $user->id)
                      ->orWhere(function($query) use ($user) {
                          $query->where('from_id', $user->id)->where('to_id', Auth::user()->id);
                      });
            })
            ->latest()
            ->first();

            if ($user->last_message) {
                $lastMessage = isset($user->attachment['attachment']) ? 'Image' : (substr($user->last_message, 0, 30) . '...');
            } elseif ($user->attachment) {
                $lastMessage = __('chat.attachment');
            } else {
                $lastMessage = __('chat.no_messages_yet');
            }

            // Nettoyage des données avant retour JSON
            return [
                'id' => $user->id,
                'prenom' => cleanUtf8($user->prenom),
                'pseudo' => cleanUtf8($user->pseudo),
                'nom_salon' => cleanUtf8($user->nom_salon),
                'avatar' => $user->avatar,
                'is_profil_pause' => $user->is_profil_pause,
                'is_online' => $isOnline,
                'last_message' => cleanUtf8($lastMessage),
                'last_message_time' => $lastMessageFromId
                    ? Carbon::parse($lastMessageFromId->created_at)->diffInSeconds(now())
                    : null,
                'viewer_id' => Auth::user()->id,
            ];
            
        });

        $users = collect($users)->sortByDesc('last_message_time')->values()->all();

        if (empty($users)) {
            return response()->json(['contacts' => 'No contacts found']);
        }

        return response()->json(['contacts' => $users], 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
    } catch (\Exception $e) {
        Log::error('Error fetching contacts: ' . $e->getMessage());
        return response()->json([
            'error' => 'An error occurred while fetching contacts.',
            'message' => $e->getMessage()
        ], 500);
    }
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
