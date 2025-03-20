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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userToid');
            $table->unsignedBigInteger('userFromid');
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();

            // Clé étrangère vers la table users
            $table->foreign('userToid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('userFromid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
