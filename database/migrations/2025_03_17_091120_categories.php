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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée (bigint unsigned)
            $table->string('nom'); // Colonne pour le nom du canton (varchar)
            $table->string('display_name'); // Colonne pour le nom du canton (varchar)
            $table->timestamps(); // Colonnes created_at et updated_at (timestamp)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
