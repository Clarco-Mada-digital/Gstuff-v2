<?php

namespace App\Livewire;

use App\Events\MessageSent;
use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mailer\Event\MessageEvent;

class Chat extends Component
{
    public $message;
    public $messages =[];
    public $open = false;  // Variable pour suivre si le chat est ouvert ou non
    public $user;
    public $users;
    public $contacts;
    public $lastMessage;
    public $unseenCounter;
    public $userReceved;

    protected $listeners = ['loadForSender', 'messageReceived'];

    public function toggleChat()
    {
        $this->open = !$this->open;  // Change l'état (ouvert/fermé)
    }

    public function loadForSender($idUser)
    {
        $this->open = true;
        $this->userReceved = User::findOrFail($idUser);
        $this->loadMessages();
    }

    public function resetSender()
    {
        $this->userReceved = null;
        $this->loadMessages();
    }

    public function messageReceived($message)
    {
        if ($message['from_id'] == Auth()->user()->id){
            $this->loadMessages();
        }elseif($message['to_id'] == Auth()->user()->id){
            if($this->userReceved == null){
                $this->loadForSender($message['from_id']);
            }elseif($this->userReceved == $message['from_id']){
                $this->loadMessages();
            }
        }
    }

    public function sendMessage()
    {
        if ($this->userReceved)
        {
            $message = new Message();
            $message->from_id = Auth::user()->id;
            $message->to_id = $this->userReceved->id;
            $message->body = $this->message;
            $message->save();

            // broadcast event
            event(new MessageSent($message));
            $this->dispatch('messageReceived', $message);
            // MessageEvent::dispatch($message);
        }else{
            $this->message = '';
            return null;
        }

        $this->message = '';
    }

    public function loadMessages()
    {
        if ($this->userReceved == null) {
            $this->messages = [];
        }else{
            $this->messages = Message::where('from_id', Auth::user()->id)->where('to_id', $this->userReceved->id)
            ->orWhere('from_id', $this->userReceved->id)->where('to_id', Auth::user()->id)
            ->latest()
            ->take(20)
            ->get()->reverse(); // Charger les messages du chat
            $this->dispatch('messages-loaded');
            // $this->userReceved = User::find($id);
        }
    }

    // delete message
    function deleteMessage($id) 
    {
        $message = Message::findOrFail($id);
        if($message->from_id == Auth::user()->id) {
            $message->delete();
            $this->dispatch('messageReceived', $message);
        }
        $this->loadMessages(); // Charger les messages du chat
        return;
    }

    function getContactItem($user) 
    {
        $lastMessage = Message::where('from_id', Auth::user()->id)->where('to_id', $user->id)
        ->orWhere('from_id', $user->id)->where('to_id', Auth::user()->id)
        ->latest()->first();
        $unseenCounter = Message::where('from_id', $user->id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();

        return view('messenger.components.contact-list-item', compact('lastMessage', 'unseenCounter', 'user'))->render();

    }

    public function render()
    {
        //$this->loadMessages(); // Charger les messages du chat
        $this->user = auth()->user(); // Charger l'utilisateur authentifié

        if($this->user)
        {
            $this->users = Message::join('users', function($join) {
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
            ->groupBy('users.id')
            ->get();

            if(count($this->users) > 0) {
                $this->contacts = '';
                foreach($this->users as $user) {
                    $this->contacts .= $this->getContactItem($user);
                }
    
            }else {
                $this->contacts = "<p class='text-center no_contact'>Votre liste de contact est vide !</p>";
            }

            $this->lastMessage = Message::where('from_id', Auth::user()->id)->where('to_id', $this->user->id)
            ->orWhere('from_id', $this->user->id)->where('to_id', Auth::user()->id)
            ->latest()->first();
            $this->unseenCounter = Message::where('from_id', $this->user->id)->where('to_id', Auth::user()->id)->where('seen', 0)->count();
        }else{
            $this->contacts = [];
        }
        

        
        return view('livewire.chat');
    }
}
