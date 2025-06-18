<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public $unreadCount;
    public $unreadNotifications;
    public $notifications;
    
    protected $listeners = ['refreshNotifications' => 'refresh'];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->unreadCount = Auth::user()->unreadNotifications->count();
        $this->unreadNotifications = Auth::user()->unreadNotifications->take(5);
        $this->notifications = Auth::user()->notifications->take(5);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            
            $notification->markAsRead();
            $this->refresh();
        }
    }

    // Dans NotificationBell.php
    public function handleAction($notificationId)
    {
        $notification = Auth::user()->notifications->find($notificationId);
        
        match($notification->data['action_type']) {
            'link' => $this->emit('openLink', $notification->data['url']),
            'modal' => $this->emit('openModal', $notification->data['component']),
            default => null
        };
        
        $notification->markAsRead();
        $this->refresh();
    }


    public function render()
    {
        return view('livewire.notification');
    }
}
