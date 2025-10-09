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
            // Ajouter la nouvelle colonne pratique_sexuelle_id
            $table->unsignedBigInteger('pratique_sexuelle_id')->nullable()->after('pratique_sexuelles');
            
            // Ajouter la contrainte de clé étrangère
            $table->foreign('pratique_sexuelle_id')
                  ->references('id')
                  ->on('pratique_sexuelles')
                  ->onDelete('set null');
            
            // Supprimer l'ancienne colonne
            $table->dropColumn('pratique_sexuelles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recréer l'ancienne colonne
            $table->string('pratique_sexuelles')->nullable();
            
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['pratique_sexuelle_id']);
            
            // Supprimer la colonne pratique_sexuelle_id
            $table->dropColumn('pratique_sexuelle_id');
        });
    }
};
