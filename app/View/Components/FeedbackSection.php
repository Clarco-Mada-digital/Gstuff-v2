<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Commentaire; // Assurez-vous d'importer le modèle Commentaire

class FeedbackSection extends Component
{
    public $listcommentApprouved;
    public $currentIndex;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Récupérer les commentaires approuvés
        $this->listcommentApprouved = Commentaire::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->with('user') // Charge les données de l'utilisateur lié
            ->get();

        // Initialiser l'index courant
        $this->currentIndex = 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feedback-section', [
            'listcommentApprouved' => $this->listcommentApprouved,
            'currentIndex' => $this->currentIndex,
        ]);
    }
}
