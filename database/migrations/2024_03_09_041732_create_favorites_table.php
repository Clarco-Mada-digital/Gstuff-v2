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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'utilisateur qui ajoute en favori
            $table->foreignId('favorite_user_id')->constrained('users')->onDelete('cascade'); // L'utilisateur favori
            $table->timestamps();
            
            // Empêche les doublons dans la table favorites (un utilisateur peut avoir un favori unique)
            $table->unique(['user_id', 'favorite_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
