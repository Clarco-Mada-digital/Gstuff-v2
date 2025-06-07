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
            'content' => [
                'fr' => $this->faker->sentence(),
                'en' => $this->faker->sentence(),
                'es' => $this->faker->sentence(),
                'de' => $this->faker->sentence(),
                'it' => $this->faker->sentence()
            ],
            'user_id' => User::inRandomOrder()->first()->id, // Sélectionner un utilisateur existant
            'is_approved' => $this->faker->boolean(60), // 60% des commentaires validés
        ];
    }
}
