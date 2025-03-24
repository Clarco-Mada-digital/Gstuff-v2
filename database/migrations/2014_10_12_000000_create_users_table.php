<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('pseudo')->nullable(); // Pour Invité
            $table->string('prenom')->nullable(); // Pour Escorte
            $table->date('date_naissance');
            $table->string('genre')->nullable(); // Pour Escorte
            $table->string('nom_salon')->nullable(); // Pour Salon
            $table->string('intitule')->nullable(); // Pour Salon (Monsieur, Madame, etc.)
            $table->string('nom_proprietaire')->nullable(); // Pour Salon
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->enum('profile_type', ['invite', 'escorte', 'salon'])->default('invite'); // Type de profil
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
