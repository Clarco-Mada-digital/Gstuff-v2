<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id(); // ID unique pour chaque invitation
            $table->unsignedBigInteger('inviter_id'); // ID de l'utilisateur qui envoie l'invitation
            $table->unsignedBigInteger('invited_id'); // ID de l'utilisateur invité
            $table->boolean('accepted')->default(false); // Statut : invitation acceptée ou non (par défaut false)
            $table->timestamps(); // Colonnes created_at et updated_at (automatiquement gérées par Laravel)

            // Clés étrangères (relations avec la table users)
            $table->foreign('inviter_id')->references('id')->on('users')->onDelete('cascade'); // Suppression cascade si inviter supprimé
            $table->foreign('invited_id')->references('id')->on('users')->onDelete('cascade'); // Suppression cascade si invité supprimé
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations'); // Supprime la table invitations si rollback
    }
};
