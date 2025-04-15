<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CgvController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdcController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\EscortController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentaireController;

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
Route::get('/glossaires', [ArticleController::class, 'index'])->name('glossaires.index');
Route::get('/glossaire/{article:slug}', [ArticleController::class, 'show'])->name('glossaires.show');
// Route::get('/cgv', [CgvController::class, 'index'])->name('cgv');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/about', [AboutController::class, 'index'])->name('about');
// Route::get('/pdc', [PdcController::class, 'index'])->name('pdc');


Route::get('/static-pages', [StaticPageController::class, 'index'])->name('static.index');
Route::get('/static-create', [StaticPageController::class, 'create'])->name('static.create');
Route::post('/static-store', [StaticPageController::class, 'store'])->name('static.store');
Route::get('/static-edit/{pages:id}', [StaticPageController::class, 'edit'])->name('static.edit');
Route::put('/static-update/{staticPage}', [StaticPageController::class, 'update'])->name('static.update');

Route::get('/cgv', function () {
    $page = \App\Models\StaticPage::findBySlug('cgv');
    return view('cgv', compact('page'));
})->name('static.cgv');

Route::get('/pdc', function () {
    $page = \App\Models\StaticPage::findBySlug('pdc');
    return view('pdc', compact('page'));
})->name('static.pdc');

Route::get('/cgu', function () {
    $page = \App\Models\StaticPage::findBySlug('cgu');
    return view('admin.static-pages.show', compact('page'));
})->name('static.cgu');



Route::post('/profile/update', [ProfileCompletionController::class, 'updateProfile'])->name('profile.update');
Route::get('/dropdown-data', [ProfileCompletionController::class, 'getDropdownData'])->name('dropdown.data'); // Route pour récupérer les données des selects
Route::get('/profile-completion-percentage', [ProfileCompletionController::class, 'getProfileCompletionPercentage'])->name('profile.completion.percentage'); // Route pour récupérer le pourcentage de completion
Route::post('/profile/update-verification', [ProfileCompletionController::class, 'updateVerification'])->name('profile.updateVerification');


// Routes publiques articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
Route::post('/articles/update/{article:id}', [ArticleController::class, 'update'])->name('articles.update');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/{article:id}', [ArticleController::class, 'edit'])->name('articles.edit');

Route::get('/categories/{articleCategory:slug}', [ArticleCategoryController::class, 'show'])->name('article-categories.show');

Route::post('/tags', [TagController::class, 'store'])->name('tags.store');

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles-edit', [RoleController::class, 'update'])->name('roles.edit');
Route::post('/roles-store', [RoleController::class, 'store'])->name('roles.store');
Route::delete('/roles-destroy/{role:id}', [RoleController::class, 'destroy'])->name('roles.destroy');

Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
Route::get('/activity/edit', [ActivityController::class, 'update'])->name('activity.edit');
Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
Route::post('/activity/destroy', [ActivityController::class, 'destroy'])->name('activity.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/edit', [UserController::class, 'update'])->name('users.edit');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/destroy', [UserController::class, 'destroy'])->name('users.destroy');

// Route::get('/stories', StoriesViewer::class)->name('stories.viewer');



//***************************************************************************************** */



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileCompletionController::class, 'index'])->name('profile.index'); // Route to show profile page
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

// Routes admin protégées
Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('static-pages', \App\Http\Controllers\Admin\StaticPageController::class)
    ->except(['destroy']);
    route::resource('activity', ActivityController::class);
    // route::resource('roles', RoleController::class);
    // Route::resource('articles', ArticleController::class)->except(['show']);
    // Route::resource('article-categories', ArticleCategoryController::class);
    // Route::resource('tags', TagController::class);

    // Gestion des utilisateurs
    Route::resource('users', UserController::class);
    
    // Rôles et permissions
    // Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class)->only(['index']);
    
    // Assignation des permissions aux rôles
    Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])
        ->name('roles.permissions.store');
    Route::delete('roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])
        ->name('roles.permissions.destroy');
});


Route::get('/approximiter/{id}', function ($id) {
    return view('components.approximate', ['userId' => $id]);
})->name('approximiter');

Route::get('/users', [UserController::class, 'index'])->name('users.index');


Route::get('/commentaires', [CommentaireController::class, 'index'])->name('commentaires.index');
Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
Route::get('/commentaires/approved', [CommentaireController::class, 'getCommentApproved'])->name('commentaires.approved');
Route::get('/commentaires/{id}', [CommentaireController::class, 'show'])->name('commentaires.show');
Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
Route::get('/commentaires/{id}/approve', [CommentaireController::class, 'approve'])->name('commentaires.approve');

Route::post('/inviterEscort', [EscortController::class, 'inviterEscorte'])->name('inviter.escorte');
Route::post('/inviterSalon', [EscortController::class, 'inviterSalon'])->name('inviter.salon');
Route::post('/invitations/accepter/{id}', [EscortController::class, 'accepter'])->name('accepter.invitation');
Route::post('/invitations/refuser/{id}', [EscortController::class, 'refuser'])->name('annuler.invitation');
Route::delete('/invitations/{id}/cancel', [EscortController::class, 'cancel'])->name('invitations.cancel');
Route::post('/registerEscorteBySalon', [AuthController::class, 'createEscorteBySalon'])->name('createEscorteBySalon');




// Route::post('/commentaires/{id}/reject', [CommentaireController::class, 'reject'])->name('commentaires.reject');


// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     // Routes CRUD pour les utilisateurs
//     Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Liste des utilisateurs
//     Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Ajout d'un utilisateur
//     Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // Formulaire de modification
//     Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // Mise à jour d'un utilisateur
//     Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Suppression d'un utilisateur

//     // // Routes CRUD pour les salons
//     // Route::get('/salons', [SalonController::class, 'index'])->name('salons.index');
//     // Route::get('/salons/create', [SalonController::class, 'create'])->name('salons.create');
//     // Route::post('/salons', [SalonController::class, 'store'])->name('salons.store');
//     // Route::get('/salons/{id}/edit', [SalonController::class, 'edit'])->name('salons.edit');
//     // Route::put('/salons/{id}', [SalonController::class, 'update'])->name('salons.update');
//     // Route::delete('/salons/{id}', [SalonController::class, 'destroy'])->name('salons.destroy');

//     // // // Routes CRUD pour les escortes
//     // // Route::get('/escortes', [EscortController::class, 'index'])->name('escortes.index');
//     // // Route::get('/escortes/create', [EscortController::class, 'create'])->name('escortes.create');
//     // // Route::post('/escortes', [EscortController::class, 'store'])->name('escortes.store');
//     // // Route::get('/escortes/{id}/edit', [EscortController::class, 'edit'])->name('escortes.edit');
//     // // Route::put('/escortes/{id}', [EscortController::class, 'update'])->name('escortes.update');
//     // // Route::delete('/escortes/{id}', [EscortController::class, 'destroy'])->name('escortes.destroy');
// });

