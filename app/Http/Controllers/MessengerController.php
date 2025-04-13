<?php

namespace App\Http\Controllers;

use App\Events\MessageSent as MessageEvent;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessengerController extends Controller
{
    use FileUploadTrait;

    function index(): View
    {
        $favoriteList = Favorite::with('user:id,pseudo,prenom,nom_salon,avatar')->where('user_id', Auth::user()->id)->get();
        return view('components.messenger', compact('favoriteList'));
    }

    /** Search user profiles */
    function search(Request $request)
    {
        $getRecords = null;
        $input = $request['query'];
        $records = User::where('id', '!=', Auth::user()->id)
            ->where('profile_type', '=', 'escorte')
            ->orWhere('profile_type', '=', 'salon')
            ->where('pseudo', 'LIKE', "%" .$input. "%")
            ->orWhere('prenom', 'LIKE', "%". $input. "%")
            ->orWhere('nom_salon', 'LIKE', "%".$input."%")
            ->orWhere('profile_type', 'LIKE', "%".$input."%")
            ->paginate(10);

        if ($records->total() < 1) {
            $getRecords .= "<p class='text-center'>Rien a voir - Aucun resultat.</p>";
        }

        foreach ($records as $record) {
            $getRecords .= view('messenger.components.search-item', compact('record'))->render();
        }

        return response()->json([
            'records' => $getRecords,
            'last_page' => $records->lastPage()
        ]);
    }

    // fetch user by id
    function fetchIdInfo(Request $request)
    {
        $userId = Auth::id();
        $contactId = $request->id;

        // Récupération des informations de base
        $fetch = User::where('id', $contactId)->firstOrFail();
        $favorite = Favorite::where([
            'user_id' => $userId,
            'favorite_user_id' => $contactId
        ])->exists();

        // Récupération des médias partagés
        $sharedPhotos = Message::where(function($query) use ($userId, $contactId) {
            $query->where([
                'from_id' => $userId,
                'to_id' => $contactId
            ])->orWhere([
                'from_id' => $contactId,
                'to_id' => $userId
            ]);
        })
        ->whereNotNull('attachment')
        ->latest()
        ->get();

        $photosContent = $sharedPhotos->map(function($photo) {
            return view('messenger.components.gallery-item', compact('photo'))->render();
        })->implode('');

        // Récupération des liens partagés
        $sharedLinks = Message::betweenUsers($userId, $contactId)
        ->whereNotNull('body')
        ->where(function($query) {
            $query->where('body', 'like', '%http://%')
                ->orWhere('body', 'like', '%https://%');
        })
        ->latest()
        ->get()
        ->map(function($message) {
            preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $message->body, $matches);
            
            return [
                'id' => $message->id,
                'urls' => $matches[0] ?? [],
                'body' => $message->body,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
                // 'sender' => [
                //     'id' => $message->sender->id,
                //     'name' => $message->sender->pseudo ?? $message->sender->prenom ?? $message->sender->nom_salon,
                //     'avatar' => $message->sender->avatar
                // ]
            ];
        })
        ->filter(fn($item) => !empty($item['urls']));

    // Comptage des messages avec la scope
    $totalMessages = Message::betweenUsers($userId, $contactId)->count();

    return response()->json([
        'fetch' => $fetch,
        'favorite' => $favorite,
        'shared_photos' => $photosContent,
        'shared_links' => $sharedLinks->values()->all(),
        'stats' => [
            'photos_count' => $sharedPhotos->count(),
            'links_count' => $sharedLinks->count(),
            'total_messages' => $totalMessages
        ]
    ]);
    }

    function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required'],
            'id' => ['required', 'integer'],
            'temporaryMsgId' => ['required'],
            'attachment' => ['nullable', 'max:1024', 'image']
        ]);

        // store the message in DB
        $attachmentPath = $this->uploadFile($request, 'attachment');
        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;
        if ($attachmentPath) $message->attachment = json_encode($attachmentPath);
        $message->save();

        // broadcast event
        MessageEvent::dispatch($message);

        return response()->json([
            'message' => $message->attachment ? $this->messageCard($message, true) : $this->messageCard($message),
            'tempID' => $request->temporaryMsgId
        ]);
    }

    function messageCard($message, $attachment = false)
    {
        return view('messenger.components.message-card', compact('message', 'attachment'))->render();
    }

    // fetch messages from database
    function fetchMessages(Request $request)
    {
        $messages = Message::where('from_id', Auth::user()->id)->where('to_id', $request->id)
            ->orWhere('from_id', $request->id)->where('to_id', Auth::user()->id)
            ->latest()->paginate(20);

        $response = [
            'last_page' => $messages->lastPage(),
            'last_message' => $messages->last(),
            'messages' => ''
        ];

        if (count($messages) < 1) {
            $response['messages'] = "<div class='flex justify-center font-bold font-dm-serif text-3xl items-center h-100'><p>Dis 'bonjour' et commence à échanger des messages.</p></div>";
            return response()->json($response);
        }

        $allMessages = '';
        foreach ($messages->reverse() as $message) {

            $allMessages .= $this->messageCard($message, $message->attachment ? true : false);
        }

        $response['messages'] = $allMessages;

        return response()->json($response);
    }

    // fetch contacts from database
    function fetchContacts(Request $request)
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
        ->select('users.*', DB::raw('MAX(messages.created_at) max_created_at'))
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.id', 
        'users.pseudo', 
        'users.prenom', 
        'users.nom_salon', 
        'users.email', 
        'users.profile_type', 
        'users.avatar', 
        'users.date_naissance', 
        'users.genre', 
        'users.intitule', 
        'users.nom_proprietaire', 
        'users.telephone',
        'users.adresse',
        'users.npa',
        'users.canton',
        'users.ville',
        'users.categorie',
        'users.service',
        'users.recrutement',
        'users.nombre_filles',
        'users.pratique_sexuelles',
        'users.oriantation_sexuelles',
        'users.tailles',
        'users.origine',
        'users.couleur_yeux',
        'users.couleur_cheveux',
        'users.mensuration',
        'users.poitrine',
        'users.taille_poitrine',
        'users.pubis',
        'users.tatouages',
        'users.mobilite',
        'users.tarif',
        'users.paiement',
        'users.langues',
        'users.apropos',
        'users.autre_contact',
        'users.complement_adresse',
        'users.lien_site_web',
        'users.localisation',
        'users.email_verified_at',
        'users.password',
        'users.lat',
        'users.lon',
        'users.couverture_image',
        'users.remember_token', 
        'users.created_at', 
        'users.profile_verifie',
        'users.image_verification',
        'users.updated_at')
        ->paginate(10);

        if(count($users) > 0) {
            $contacts = '';
            foreach($users as $user) {
                $contacts .= $this->getContactItem($user);
            }

        }else {
            $contacts = "<p class='text-center no_contact'>Votre liste de contact est vide !</p>";
        }

        return response()->json([
            'contacts' => $contacts,
            'last_page' => $users->lastPage()
        ]);

    }

    function getContactItem($user) 
    {
        $lastMessage = Message::where('from_id', Auth::user()->id)->where('to_id', $user->id)
        ->orWhere('from_id', $user->id)->where('to_id', Auth::user()->id)
        ->latest()->first();
        $unseenCounter = Message::where('from_id', $user->id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();

        return view('messenger.components.contact-list-item', compact('lastMessage', 'unseenCounter', 'user'))->render();

    }

    // update contact item
    function updateContactItem(Request $request) 
    {
        // get user data
        $user = User::where('id', $request->user_id)->first();

        if(!$user) {
            return response()->json([
                'message' => 'Utilisateur introuvable!'
            ], 401);
        }
        $contactItem = $this->getContactItem($user);
        return response()->json([
            'contact_item' => $contactItem
        ], 200);
    }

    function makeSeen(Request $request) 
    {
        Message::where('from_id', $request->id)
            ->where('to_id', Auth::user()->id)
            ->where('seen', 0)->update(['seen' => 1]);

        return true;
    }

    // add/remove to favorite list
    function favorite(Request $request) 
    {
        $query = Favorite::where(['user_id' => Auth::user()->id, 'favorite_user_id' => $request->id]);
        $favoriteStatus = $query->exists();

        if(!$favoriteStatus) {
            $star = new Favorite();
            $star->user_id = Auth::user()->id;
            $star->favorite_user_id = $request->id;
            $star->save();
            return response(['status' => 'added']);
        }else {
            $query->delete();
            return response(['status' => 'removed']);
        }
    }

    // delete message
    function deleteMessage(Request $request) 
    {
        $message = Message::findOrFail($request->message_id);
        if($message->from_id == Auth::user()->id) {
            $message->delete();
            return response()->json([
                'id' => $request->message_id,
                'status' => 'success',
                'message' => 'Message supprimé avec succès'
            ], 200);
        }
        return;
    }

}
