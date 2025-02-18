<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CgvController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GlossaireController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/glossaire', [GlossaireController::class, 'index'])->name('glossaire');
Route::get('/cgv', [CgvController::class, 'index'])->name('cgv');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/FAQ', [ContactController::class, 'index'])->name('faq');
Route::get('/about', [AboutController::class, 'index'])->name('about');


// {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2dzdHVmZi5jaCIsImlhdCI6MTczOTg2ODc4NiwibmJmIjoxNzM5ODY4Nzg2LCJleHAiOjE3NDA0NzM1ODYsImRhdGEiOnsidXNlciI6eyJpZCI6IjEyMzQ3NSJ9fX0._B-LGOQ3-wKgVU5ywKN__TYAeHyAqHwXtAcUJWevbWs",
//   "user_email":"clarco.dev@mada-digital.net",
//   "user_nicename":"clarco",
//   "user_display_name":"Bryan Clark"
// }
