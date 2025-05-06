<?php

namespace App\Livewire;

use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|max:100',
        'subject' => 'required|string|max:100',
        'email' => 'required|email|max:150',
        'message' => 'required|string|max:1000',
    ];

    public function send()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        Mail::to('infogerance.madadigital@gmail.com')->send(new ContactMessageMail($data));

        session()->flash('success', 'Votre message a été envoyé avec succès !');

        $this->reset(['name', 'email', 'subject', 'message']);
    }
    
    public function render()
    {
        return view('livewire/contact');
    }
}
