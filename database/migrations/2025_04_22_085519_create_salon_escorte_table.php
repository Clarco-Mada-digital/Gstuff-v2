<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salon_escorte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('escorte_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salon_escorte');
    }
};
