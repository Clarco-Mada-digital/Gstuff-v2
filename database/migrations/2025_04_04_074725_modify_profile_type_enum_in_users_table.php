<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajoute 'admin' aux valeurs possibles de l'ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN profile_type ENUM('invite', 'escorte', 'salon', 'admin')");
    }
    
    public function down()
    {
        // Retire 'admin' des valeurs possibles de l'ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN profile_type ENUM('invite', 'escorte', 'salon')");
    }
    
};
