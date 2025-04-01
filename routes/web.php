<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CgvController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GlossaireController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdcController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EscortController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\UserProfileController;

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

// Auth section
Route::get('/registerForm', [AuthController::class, 'showRegistrationForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/escort-register', function(){return view('auth.escort_register');})->name('escort_register');
Route::get('/salon-register', function(){return view('auth.salon_register');})->name('salon_register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/log-out', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/update', [ProfileCompletionController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/update-photo', [ProfileCompletionController::class, 'updatePhoto'])->name('profile.update-photo');
Route::get('/profile-completion-percentage', [ProfileCompletionController::class, 'getProfileCompletionPercentage'])->name('profile.completion.percentage');

Route::match(['get', 'post'], '/escort/{id}', [EscortController::class, 'show'])->name('show_escort');
Route::get('/salon/{id}', [SalonController::class, 'show'])->name('show_salon');
Route::match(['get', 'post'], '/escortes', [EscortController::class, 'search_escort'])->name('escortes');
Route::get('/salons', [SalonController::class, 'search_salon'])->name('salons');

Route::post('/reset_password', [AuthController::class, 'sendPasswordResetLink'])->name('reset_password');

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/glossaires', [GlossaireController::class, 'index'])->name('glossaires');
Route::get('/glossaire/{id}', [GlossaireController::class, 'item'])->name('glossaire');
Route::get('/cgv', [CgvController::class, 'index'])->name('cgv');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/pdc', [PdcController::class, 'index'])->name('pdc');



Route::post('/profile/update', [ProfileCompletionController::class, 'updateProfile'])->name('profile.update');
Route::get('/dropdown-data', [ProfileCompletionController::class, 'getDropdownData'])->name('dropdown.data'); // Route pour récupérer les données des selects
Route::get('/profile-completion-percentage', [ProfileCompletionController::class, 'getProfileCompletionPercentage'])->name('profile.completion.percentage'); // Route pour récupérer le pourcentage de completion
Route::get('/profile', [ProfileCompletionController::class, 'index'])->name('profile.index'); // Route to show profile page


//***************************************************************************************** */



Route::middleware('auth')->group(function () {
    // Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    // Route::get('/messages/{receiver_id}', [ChatController::class, 'getMessages'])->name('get.messages');
    // Route::get('/chat/{receiver}', [ChatController::class, 'showChatForm'])->name('chat.form'); // Route pour afficher le formulaire de chat
    // Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('messenger', [MessengerController::class, 'index'])->name('home-messenger');
    // Route::post('profile', [UserProfileController::class, 'update'])->name('profile.update');
    // search route
    Route::get('messenger/search', [MessengerController::class, 'search'])->name('messenger.search');
    // fetch user by id
    Route::get('messenger/id-info', [MessengerController::class, 'fetchIdInfo'])->name('messenger.id-info');
    // send message
    Route::post('messenger/send-message', [MessengerController::class, 'sendMessage'])->name('messenger.send-message');
    // fetch message
    Route::get('messenger/fetch-messages', [MessengerController::class, 'fetchMessages'])->name('messenger.fetch-messeges');
    // fetch contacts
    Route::get('messenger/fetch-contacts', [MessengerController::class, 'fetchContacts'])->name('messenger.fetch-contacts');
    Route::get('messenger/update-contact-item', [MessengerController::class, 'updateContactItem'])->name('messenger.update-contact-item');
    Route::post('messenger/make-seen', [MessengerController::class, 'makeSeen'])->name('messenger.make-seen');
    // favorite routes
    Route::post('messenger/favorite', [MessengerController::class, 'favorite'])->name('messenger.favorite');
    Route::get('messenger/fetch-favorite', [MessengerController::class, 'fetchFavoritesList'])->name('messenger.fetch-favorite');
    Route::delete('messenger/delete-message', [MessengerController::class, 'deleteMessage'])->name('messenger.delete-message');
});



Route::get('/approximiter1/{id}', [ApproximiterController::class, 'show'])->name('approximiter');
Route::get('/approximiter/{id}', function ($id) {
    return view('components.approximate', ['userId' => $id]);
})->name('approximiter');