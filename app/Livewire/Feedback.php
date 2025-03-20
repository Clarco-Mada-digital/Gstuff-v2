<?php

namespace App\Livewire;

use App\Models\Feedback as ModelsFeedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Feedback extends Component
{
    #[Locked]
    public User $userFromId; // id d'utilisateur qui post
    #[locked]
    public User $userToId; // id d'utilisateur qui est noté
    public $rating = 0; // Note par défaut
    public $comment = ''; // Commentaire par défaut
    public $feedbacks;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ];

    public function mount($userToId)
    {
        $this->userToId = $userToId;
        $this->loadFeedbacks();
    }

    public function loadFeedbacks()
    {
        $this->feedbacks = ModelsFeedback::where('userToId', $this->userToId->id)
            ->latest()->get();
        foreach ($this->feedbacks as $feedback) {
            $feedback['userFromId'] = User::find($feedback->userFromid);
        }

    }

    public function submit()
    {
        $this->validate();

        $this->userFromId = Auth::user();

        ModelsFeedback::create([
            'userToId' => $this->userToId->id,
            'userFromId' => $this->userFromId->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        // Réinitialiser les champs après soumission
        $this->reset(['rating', 'comment']);

        session()->flash('success', 'Votre feedback a été soumis avec succès.');
    }

    public function render()
    {
        return view('livewire.feedback');
    }
}
