<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{
    protected function disableForeignKeys()
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET CONSTRAINTS ALL DEFERRED');
        } else {
            // SQLite
            DB::statement('PRAGMA foreign_keys = OFF');
        }
    }

    protected function enableForeignKeys()
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'pgsql') {
            DB::statement('SET CONSTRAINTS ALL IMMEDIATE');
        } else {
            // SQLite
            DB::statement('PRAGMA foreign_keys = ON');
        }
    }
}
