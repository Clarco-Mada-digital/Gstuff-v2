<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Commentaire;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    public function run()
    {
        // Vérifier s'il y a des utilisateurs existants
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('Aucun utilisateur trouvé, veuillez ajouter des utilisateurs avant de seed les commentaires.');
            return;
        }

        // Insérer des commentaires aléatoires
        Commentaire::factory()->count(9)->create();
    }
}
