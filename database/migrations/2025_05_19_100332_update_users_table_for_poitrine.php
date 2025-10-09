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
            // Vérifier si la colonne poitrine existe avant de la supprimer
            if (Schema::hasColumn('users', 'poitrine')) {
                $table->dropColumn('poitrine');
            }
            
            // Ajouter la nouvelle colonne poitrine_id
            $table->foreignId('poitrine_id')
                  ->nullable()
                  ->after('mensuration_id')
                  ->constrained('poitrines')
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
            $table->dropForeign(['poitrine_id']);
            $table->dropColumn('poitrine_id');
            
            // Recréer l'ancienne colonne
            $table->string('poitrine')->nullable()->after('mensuration_id');
        });
    }
};
