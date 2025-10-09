<?php

namespace App\View\Components;

use App\Models\User;
use App\Models\Message;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class ContactListItem extends Component
{
    public $user;
    public $lastMessage;
    public $unseenCounter;
    public $isOnline;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->lastMessage = $this->getLastMessage();
        $this->unseenCounter = $this->getUnseenCounter();
        $this->isOnline = $this->checkIfUserIsOnline();
    }

    protected function getLastMessage()
    {
        return Message::where(function($query) {
                $query->where('from_id', Auth::id())
                      ->where('to_id', $this->user->id);
            })
            ->orWhere(function($query) {
                $query->where('from_id', $this->user->id)
                      ->where('to_id', Auth::id());
            })
            ->latest()
            ->first();
    }

    protected function getUnseenCounter()
    {
        return Message::where('from_id', $this->user->id)
            ->where('to_id', Auth::id())
            ->where('seen', 0)
            ->count();
    }

    protected function checkIfUserIsOnline()
    {
        if (!$this->user->last_seen_at) {
            return false;
        }
        return now()->diffInMinutes($this->user->last_seen_at) < 2;
    }

    public function render()
    {
        return view('components.contact-list-item', [
            'user' => $this->user,
            'lastMessage' => $this->lastMessage,
            'unseenCounter' => $this->unseenCounter,
            'isOnline' => $this->isOnline
        ]);
    }
}
