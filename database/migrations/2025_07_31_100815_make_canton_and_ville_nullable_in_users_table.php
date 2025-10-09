<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop existing foreign key constraints
            $table->dropForeign(['canton']);
            $table->dropForeign(['ville']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Make columns nullable
            $table->unsignedBigInteger('canton')->nullable()->change();
            $table->unsignedBigInteger('ville')->nullable()->change();
            
            // Re-add foreign key constraints with nullable
            $table->foreign('canton')->references('id')->on('cantons')->onDelete('set null');
            $table->foreign('ville')->references('id')->on('villes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['canton']);
            $table->dropForeign(['ville']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Make columns not nullable again
            $table->unsignedBigInteger('canton')->nullable(false)->change();
            $table->unsignedBigInteger('ville')->nullable(false)->change();
            
            // Re-add foreign key constraints without nullable
            $table->foreign('canton')->references('id')->on('cantons');
            $table->foreign('ville')->references('id')->on('villes');
        });
    }
};
