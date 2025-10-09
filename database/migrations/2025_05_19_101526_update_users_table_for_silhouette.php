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
            // Vérifier si la colonne silhouette existe avant de la supprimer
            if (Schema::hasColumn('users', 'silhouette')) {
                $table->dropColumn('silhouette');
            }
            
            // Ajouter la nouvelle colonne silhouette_id
            $table->foreignId('silhouette_id')
                  ->nullable()
                  ->after('poitrine_id')
                  ->constrained('silhouettes')
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
            $table->dropForeign(['silhouette_id']);
            $table->dropColumn('silhouette_id');
            
            // Recréer l'ancienne colonne
            $table->string('silhouette')->nullable()->after('poitrine_id');
        });
    }
};
