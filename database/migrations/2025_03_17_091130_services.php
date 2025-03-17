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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom'); // Colonne pour le nom de la ville
            $table->foreignId('categorie_id')->constrained('categories')->nullable(); // Clé étrangère vers la table 'cantons'
            $table->timestamps(); // Colonnes created_at et updated_at

            // Index pour la clé étrangère (optionnel, mais recommandé pour la performance)
            // $table->index('categorie_id'); // Déjà créé par foreignId, pas nécessaire de le répéter ici
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
