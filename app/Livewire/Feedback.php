<?php

namespace App\Livewire;

use App\Models\Feedback as ModelsFeedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;


use App\Services\DeepLTranslateService;
use App\Helpers\Locales;

class Feedback extends Component
{
    #[Locked]
    public User $userFromId; // id d'utilisateur qui post
    #[locked]
    public User $userToId; // id d'utilisateur qui est noté
    public $rating = 0; // Note par défaut
    public $comment = ''; // Commentaire par défaut
    public $feedbacks;
    public $lang;

    protected $listeners = ['feedbackSubmitted' => '$refresh'];
    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ];
    
    protected function validationAttributes()
    {
        return [
            'rating' => __('feedback.validation.rating_required'),
            'comment' => __('feedback.validation.comment_max'),
        ];
    }
    
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


    protected $translateService;

    public function boot(DeepLTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }


    public function mount($userToId)
    {
        $this->userToId = $userToId;
        $this->loadFeedbacks();
        $this->lang = app()->getLocale();
    }

    public function loadFeedbacks()
    {
        $this->feedbacks = ModelsFeedback::where('userToid', $this->userToId->id)
            ->latest()->get();
        foreach ($this->feedbacks as $feedback) {
            $feedback['userFromId'] = User::find($feedback->userFromid);
        }

    }

    public function submit()
    {
        try {
            // Validation des champs requis
            $validatedData = $this->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:500'
            ], [
                'rating.required' => __('feedback.validation.rating_required'),
                'rating.integer' => __('feedback.validation.rating_integer'),
                'rating.min' => __('feedback.validation.rating_min'),
                'rating.max' => __('feedback.validation.rating_max'),
                'comment.required' => __('feedback.validation.comment_required'),
                'comment.max' => __('feedback.validation.comment_max'),
            ]);

            $this->userFromId = Auth::user();

            // Langues cibles pour les traductions
            $locales = Locales::SUPPORTED_CODES;
            $sourceLocale = $this->lang; // Langue source par défaut

            // Traduire le contenu dans toutes les langues cibles
            $translatedContent = [];
            foreach ($locales as $locale) {
                if ($locale !== $sourceLocale) {
                    $translatedContent[$locale] = $this->translateService->translate($this->comment, $locale);
                } else {
                    $translatedContent[$locale] = $this->comment;
                }
            }

            ModelsFeedback::create([
                'userToId' => $this->userToId->id,
                'userFromId' => $this->userFromId->id,
                'rating' => $this->rating,
                'comment' => $translatedContent,
            ]);

            // Réinitialiser les champs après soumission
            $this->reset(['rating', 'comment']);
            
            // Émettre un événement de succès
            $this->dispatch('showSuccess', message: __('feedback.success.submitted'));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Pour les erreurs de validation, on affiche la première erreur
            $firstError = collect($e->errors())->first()[0] ?? 'Une erreur de validation est survenue.';
            $this->dispatch('showError', message: $firstError);
        } catch (\Exception $e) {
            // Pour les autres erreurs
            $this->dispatch('showError', message: 'An error occurred while saving your feedback. Please try again.');
        }
    }

    public function render()
    {
        $this->loadFeedbacks(); // Rafraîchit la liste

        return view('livewire.feedback');
    }
}
