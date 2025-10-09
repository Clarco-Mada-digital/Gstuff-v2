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

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'message' => 'required|string|max:1000',
        ];
    }
    
    protected function messages()
    {
        return [
            'name.required' => __('contact.validation.name.required'),
            'name.string' => __('contact.validation.name.string'),
            'name.max' => __('contact.validation.name.max', ['max' => 100]),
            'email.required' => __('contact.validation.email.required'),
            'email.email' => __('contact.validation.email.email'),
            'email.max' => __('contact.validation.email.max', ['max' => 150]),
            'subject.required' => __('contact.validation.subject.required'),
            'subject.string' => __('contact.validation.subject.string'),
            'subject.max' => __('contact.validation.subject.max', ['max' => 100]),
            'message.required' => __('contact.validation.message.required'),
            'message.string' => __('contact.validation.message.string'),
            'message.max' => __('contact.validation.message.max', ['max' => 1000]),
        ];
    }

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

        session()->flash('success', __('contact.success.message_sent'));

        $this->reset(['name', 'email', 'subject', 'message']);
    }
    
    public function render()
    {
        return view('livewire/contact');
    }
}
