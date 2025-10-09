<?php 
namespace App\Console\Commands;
use App\Models\User;
use Carbon\Carbon;

// public function handle()
// {
//     User::whereNotNull('last_seen_at')
//         ->chunk(100, function ($users) {
//             foreach ($users as $user) {
//                 if (is_string($user->last_seen_at)) {
//                     $user->update([
//                         'last_seen_at' => Carbon::parse($user->last_seen_at)
//                     ]);
//                 }
//             }
//         });
// }