<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CouleurYeux;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si la colonne couleur_yeux existe encore
        if (Schema::hasColumn('users', 'couleur_yeux')) {
            // Mettre à jour les données existantes avant de supprimer la colonne
            $this->migrateExistingData();
            
            // Supprimer l'ancienne colonne
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('couleur_yeux');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recréer l'ancienne colonne
        if (!Schema::hasColumn('users', 'couleur_yeux')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('couleur_yeux')->nullable()->after('couleur_yeux_id');
            });
            
            // Rétablir les anciennes valeurs
            $this->rollbackData();
        }
    }

    /**
     * Migre les données existantes de l'ancienne colonne vers la nouvelle relation
     */
    private function migrateExistingData(): void
    {
        // Récupérer tous les utilisateurs avec une couleur_yeux définie
        $users = \DB::table('users')
            ->whereNotNull('couleur_yeux')
            ->get();

        foreach ($users as $user) {
            // Trouver la couleur des yeux correspondante au slug
            $couleurYeux = CouleurYeux::where('slug', $user->couleur_yeux)->first();
            
            if ($couleurYeux) {
                // Mettre à jour l'utilisateur avec le nouvel ID de couleur_yeux
                \DB::table('users')
                    ->where('id', $user->id)
                    ->update(['couleur_yeux_id' => $couleurYeux->id]);
            }
        }
    }

    /**
     * Rétablit les anciennes valeurs lors du rollback
     */
    private function rollbackData(): void
    {
        // Récupérer tous les utilisateurs avec un couleur_yeux_id défini
        $users = \DB::table('users')
            ->whereNotNull('couleur_yeux_id')
            ->join('couleur_yeuxes', 'users.couleur_yeux_id', '=', 'couleur_yeuxes.id')
            ->select('users.id', 'couleur_yeuxes.slug as couleur_yeux_slug')
            ->get();

        foreach ($users as $user) {
            // Mettre à jour l'utilisateur avec l'ancienne valeur de couleur_yeux
            \DB::table('users')
                ->where('id', $user->id)
                ->update(['couleur_yeux' => $user->couleur_yeux_slug]);
        }
    }
};
