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

    protected $listeners = ['feedbackSubmitted' => '$refresh'];
    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ];
    
    protected $validationAttributes = [
        'rating' => __('feedback.validation.rating_required'),
        'comment' => __('feedback.validation.comment_max'),
    ];
    
    protected function getMessages()
    {
        return [
            'rating.required' => __('feedback.validation.rating_required'),
            'rating.integer' => __('feedback.validation.rating_integer'),
            'rating.min' => __('feedback.validation.rating_min'),
            'rating.max' => __('feedback.validation.rating_max'),
            'comment.max' => __('feedback.validation.comment_max'),
        ];
    }

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

        // $this->loadFeedbacks(); // Rafraîchit la liste

        session()->flash('success', __('feedback.success.submitted'));
    }

    public function render()
    {
        $this->loadFeedbacks(); // Rafraîchit la liste

        return view('livewire.feedback');
    }
}
