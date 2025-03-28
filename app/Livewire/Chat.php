<?php

namespace App\Livewire;

use App\Events\MessageSent;
use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\Event\MessageEvent;

class Chat extends Component
{
    public $message;
    public $messages =[];
    public $open = false;  // Variable pour suivre si le chat est ouvert ou non
    public $user;
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
    function deleteMessage($id) {
        $message = Message::findOrFail($id);
        if($message->from_id == Auth::user()->id) {
            $message->delete();
            $this->dispatch('messageReceived', $message);
        }
        $this->loadMessages(); // Charger les messages du chat
        return;
    }

    public function render()
    {
        //$this->loadMessages(); // Charger les messages du chat
        $this->user = auth()->user(); // Charger l'utilisateur authentifié
        return view('livewire.chat');
    }
}
