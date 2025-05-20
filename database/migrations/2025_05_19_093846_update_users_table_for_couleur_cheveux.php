<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Vérifier si la colonne couleur_cheveux existe avant de la supprimer
            if (Schema::hasColumn('users', 'couleur_cheveux')) {
                $table->dropColumn('couleur_cheveux');
            }
            
            // Ajouter la nouvelle colonne couleur_cheveux_id
            $table->foreignId('couleur_cheveux_id')
                  ->nullable()
                  ->after('couleur_yeux_id')
                  ->constrained('couleur_cheveuxes')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne
            $table->dropForeign(['couleur_cheveux_id']);
            $table->dropColumn('couleur_cheveux_id');
            
            // Recréer l'ancienne colonne
            $table->string('couleur_cheveux')->nullable()->after('couleur_yeux_id');
        });
    }
};
