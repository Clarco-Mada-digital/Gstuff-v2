<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Events\Message as MessageSend;
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

    protected $listeners = ['messageReceived' => 'loadMessages', 'loadForSender'];

    public function toggleChat()
    {
        $this->open = !$this->open;  // Change l'état (ouvert/fermé)
    }

    public function loadForSender($idUser)
    {
        $this->open = true;
        $this->loadMessages($idUser);
    }

    public function sendMessage()
    {
        if ($this->userReceved)
        {
            // $message = Message::create([
            //     'receiver_id' => 3,
            //     'sender_id' => auth()->id(),
            //     'message' => $this->message,
            // ]);
            $message = new Message();
            $message->from_id = Auth::user()->id;
            $message->to_id = $this->userReceved->id;
            $message->body = $this->message;
            $message->save();

            // broadcast event
            broadcast(new MessageSend($message));
            $this->loadMessages($this->userReceved->id); // Charger les messages du chat
            // MessageEvent::dispatch($message);
        }else{
            $this->message = '';
            return null;
        }

        $this->message = '';
    }

    public function loadMessages($id=null)
    {
        if ($id == null) {
            $this->messages = [];
        }else{
            $this->messages = Message::where('from_id', Auth::user()->id)->where('to_id', $id)
            ->orWhere('from_id', $id)->where('to_id', Auth::user()->id)
            ->get(); // Charger les messages du chat
            $this->userReceved = User::find($id);
        }
    }

    // delete message
    function deleteMessage($id) {
        $message = Message::findOrFail($id);
        if($message->from_id == Auth::user()->id) {
            $message->delete();
        }
        return;
    }

    public function render()
    {
        //$this->loadMessages(); // Charger les messages du chat
        $this->user = auth()->user(); // Charger l'utilisateur authentifié
        return view('livewire.chat');
    }
}
