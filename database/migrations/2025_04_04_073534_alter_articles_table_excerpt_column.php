<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Modifier la colonne 'excerpt' pour accepter des chaînes plus longues
            $table->text('excerpt')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Revenir à l'état précédent si nécessaire
            $table->string('excerpt', 255)->change();
        });
    }
};
