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
        Schema::table('invitations', function (Blueprint $table) {
            // Ajouter la colonne 'type', qui peut être nulle , invite par salon ,associe au salon , creer par salon
            $table->string('type')->nullable()->after('accepted'); // Positionnée après 'accepted'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Supprime la colonne 'type' en cas de rollback
            $table->dropColumn('type');
        });
    }
};
