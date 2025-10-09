<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTattoosTable extends Migration
{
    public function up()
    {
        Schema::create('tattoos', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tattoos');
    }
}
