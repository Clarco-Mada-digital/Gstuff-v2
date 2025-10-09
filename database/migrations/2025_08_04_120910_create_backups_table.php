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
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path_db');
            $table->string('file_name_db');
            $table->string('file_path_storage');
            $table->string('file_name_storage');
            $table->string('type')->comment('database, storage, full');
            $table->bigInteger('size_db')->default(0)->comment('Taille en octets');
            $table->bigInteger('size_storage')->default(0)->comment('Taille en octets');
            $table->string('disk')->default('local');
            $table->string('status')->default('completed')->comment('completed, failed, in_progress');
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable()->comment('Informations supplémentaires sur la sauvegarde');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            
            // Index pour les recherches courantes
            $table->index(['type', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
