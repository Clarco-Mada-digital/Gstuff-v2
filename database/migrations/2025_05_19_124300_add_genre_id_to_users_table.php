<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Genre;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajouter la colonne genre_id
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('genre_id')
                  ->nullable()
                  ->after('date_naissance')
                  ->constrained('genres')
                  ->onDelete('set null');
        });

        // Mettre à jour les données existantes
        $this->migrateExistingData();

        // Supprimer l'ancienne colonne genre
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('genre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recréer l'ancienne colonne
            $table->string('genre')->nullable()->after('date_naissance');
            
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['genre_id']);
        });

        // Rétablir les anciennes valeurs
        $this->rollbackData();

        // Supprimer la colonne genre_id
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('genre_id');
        });
    }

    /**
     * Migre les données existantes de l'ancienne colonne vers la nouvelle relation
     */
    private function migrateExistingData(): void
    {
        // Récupérer tous les utilisateurs avec un genre défini
        $users = \DB::table('users')
            ->whereNotNull('genre')
            ->get();

        foreach ($users as $user) {
            // Trouver le genre correspondant au slug
            $genre = Genre::where('slug', $user->genre)->first();
            
            if ($genre) {
                // Mettre à jour l'utilisateur avec le nouvel ID de genre
                \DB::table('users')
                    ->where('id', $user->id)
                    ->update(['genre_id' => $genre->id]);
            }
        }
    }

    /**
     * Rétablit les anciennes valeurs lors du rollback
     */
    private function rollbackData(): void
    {
        // Récupérer tous les utilisateurs avec un genre_id défini
        $users = \DB::table('users')
            ->whereNotNull('genre_id')
            ->join('genres', 'users.genre_id', '=', 'genres.id')
            ->select('users.id', 'genres.slug as genre_slug')
            ->get();

        foreach ($users as $user) {
            // Mettre à jour l'utilisateur avec l'ancienne valeur de genre
            \DB::table('users')
                ->where('id', $user->id)
                ->update(['genre' => $user->genre_slug]);
        }
    }
};
