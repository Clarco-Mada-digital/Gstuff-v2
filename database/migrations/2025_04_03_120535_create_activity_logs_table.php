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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->default('default');
            $table->text('description');
            $table->string('event'); // created, updated, deleted, etc.
            $table->string('subject_type'); // App\Models\Article, etc.
            $table->unsignedBigInteger('subject_id'); // ID de l'objet concerné
            $table->string('causer_type')->nullable(); // App\Models\User
            $table->unsignedBigInteger('causer_id')->nullable(); // ID de l'utilisateur
            $table->json('properties')->nullable(); // Anciennes/nouvelles valeurs
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
