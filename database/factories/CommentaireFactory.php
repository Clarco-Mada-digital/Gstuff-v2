<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Commentaire;

class CommentaireFactory extends Factory
{
    protected $model = Commentaire::class;

    public function definition()
    {
        return [
            'content' => $this->faker->sentence(),
            'user_id' => User::inRandomOrder()->first()->id, // Sélectionner un utilisateur existant
            'is_approved' => $this->faker->boolean(60), // 80% des commentaires validés
        ];
    }
}
