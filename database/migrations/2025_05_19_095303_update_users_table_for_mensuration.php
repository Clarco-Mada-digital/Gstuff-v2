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
            // Vérifier si la colonne mensuration existe avant de la supprimer
            if (Schema::hasColumn('users', 'mensuration')) {
                $table->dropColumn('mensuration');
            }
            
            // Ajouter la nouvelle colonne mensuration_id
            $table->foreignId('mensuration_id')
                  ->nullable()
                  ->after('couleur_cheveux_id')
                  ->constrained('mensurations')
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
            $table->dropForeign(['mensuration_id']);
            $table->dropColumn('mensuration_id');
            
            // Recréer l'ancienne colonne
            $table->string('mensuration')->nullable()->after('couleur_cheveux_id');
        });
    }
};
