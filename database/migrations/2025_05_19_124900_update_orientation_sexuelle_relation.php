<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\OrientationSexuelle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si la colonne oriantation_sexuelles existe
        if (Schema::hasColumn('users', 'oriantation_sexuelles')) {
            // Ajouter la colonne orientation_sexuelle_id si elle n'existe pas
            if (!Schema::hasColumn('users', 'orientation_sexuelle_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreignId('orientation_sexuelle_id')
                        ->nullable()
                        ->after('oriantation_sexuelles')
                        ->constrained('orientation_sexuelles')
                        ->onDelete('set null');
                });
            }
            
            // Mettre à jour les données existantes
            $this->migrateExistingData();
            
            // Supprimer l'ancienne colonne
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('oriantation_sexuelles');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recréer l'ancienne colonne
        if (!Schema::hasColumn('users', 'oriantation_sexuelles')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('oriantation_sexuelles')->nullable()->after('orientation_sexuelle_id');
            });
            
            // Rétablir les anciennes valeurs
            $this->rollbackData();
            
            // Supprimer la colonne orientation_sexuelle_id
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['orientation_sexuelle_id']);
                $table->dropColumn('orientation_sexuelle_id');
            });
        }
    }

    /**
     * Migre les données existantes de l'ancienne colonne vers la nouvelle relation
     */
    private function migrateExistingData(): void
    {
        // Récupérer tous les utilisateurs avec une orientation_sexuelle définie
        $users = \DB::table('users')
            ->whereNotNull('oriantation_sexuelles')
            ->get();

        foreach ($users as $user) {
            // Trouver l'orientation sexuelle correspondante au slug
            $orientation = OrientationSexuelle::where('slug', $user->oriantation_sexuelles)->first();
            
            if ($orientation) {
                // Mettre à jour l'utilisateur avec le nouvel ID d'orientation sexuelle
                \DB::table('users')
                    ->where('id', $user->id)
                    ->update(['orientation_sexuelle_id' => $orientation->id]);
            }
        }
    }

    /**
     * Rétablit les anciennes valeurs lors du rollback
     */
    private function rollbackData(): void
    {
        // Récupérer tous les utilisateurs avec un orientation_sexuelle_id défini
        $users = \DB::table('users')
            ->whereNotNull('orientation_sexuelle_id')
            ->join('orientation_sexuelles', 'users.orientation_sexuelle_id', '=', 'orientation_sexuelles.id')
            ->select('users.id', 'orientation_sexuelles.slug as orientation_slug')
            ->get();

        foreach ($users as $user) {
            // Mettre à jour l'utilisateur avec l'ancienne valeur d'orientation_sexuelle
            \DB::table('users')
                ->where('id', $user->id)
                ->update(['oriantation_sexuelles' => $user->orientation_slug]);
        }
    }
};
