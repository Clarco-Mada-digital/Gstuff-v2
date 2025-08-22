<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\TaxonomyController as AdminTaxonomyController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\EscortController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessengerApiController;

use App\Http\Controllers\DistanceMaxController;

use App\Http\Controllers\ProfileVisibilityController;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\OtherController;

use App\Models\Genre;
use Livewire\Livewire;

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

Route::get('livewire/update', function(){
    return redirect()->back();
})->middleware(['web'])->name('livewire.update.custom');


// =================================== Routes public =========================================
// Home
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/create-account', [HomeController::class, 'nextStep'])->name('nextStep');
// Glossaires
Route::get('/glossaires', [ArticleController::class, 'index'])->name('glossaires.index');
Route::get('/glossaire/{article:slug}', [ArticleController::class, 'show'])->name('glossaires.show');
// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
// About
Route::get('/about', [AboutController::class, 'index'])->name('about');
// Galerie
Route::get('/galerie', [AuthController::class, 'showGallery'])->name('gallery.show');
Route::get('/api/gallery/public', [AuthController::class, 'apiPublicGallery']);
Route::get('/api/gallery/private', [AuthController::class, 'apiPrivateGallery']);
// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('users.index');
// Commentaires
Route::get('/commentaires', [CommentaireController::class, 'index'])->name('commentaires.index');
// Langue
Route::get('lang/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang.switch');




// ============================== Routes admin ===========================================

// Static page
Route::get('/static-pages', [StaticPageController::class, 'index'])->name('static.index');


// Roles
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles-edit', [RoleController::class, 'update'])->name('roles.edit');


// Route::put('/roles/{role:id}', [RoleController::class, 'update'])->name('roles.edit');
// Route::get('/roles/{role}/edit', [RoleController::class, 'editRole'])->name('roles.editRoleview');
Route::get('/roles/{role}/edit', [RoleController::class, 'editRole'])->name('roles.edit');

Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');



Route::post('/roles-store', [RoleController::class, 'store'])->name('roles.store');
Route::delete('/roles-destroy/{role:id}', [RoleController::class, 'destroy'])->name('roles.destroy');

// Activity
Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
Route::get('/activity/edit', [ActivityController::class, 'update'])->name('activity.edit');
Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
Route::post('/activity/destroy', [ActivityController::class, 'destroy'])->name('activity.destroy');

// Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/edit', [UserController::class, 'update'])->name('users.edit');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{iduser}/demande', [UserController::class, 'showDemande'])->name('users.demande');
Route::get('/users/approved/{iduser}', [UserController::class, 'approvedProfile'])->name('users.approvedProfile');
Route::get('/users/notApproved/{iduser}', [UserController::class, 'notApprovedProfile'])->name('users.notApprovedProfile');
Route::delete('/notifications/{iduser}', [NotificationController::class, 'destroy'])->name('notifications.destroy');


// ============================== Routes admin protégées =====================================

Route::middleware(['auth'])->prefix('admin')->group(function() {
    // Gestion des sauvegardes
    Route::prefix('backups')->name('backups.')->group(function() {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/', [BackupController::class, 'create'])->name('create');
        Route::get('/download/{id}', [BackupController::class, 'download'])->name('download');
        Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
        Route::post('/restore/upload', [BackupController::class, 'Upload'])->name('restore.upload');
        Route::delete('/{id}', [BackupController::class, 'destroy'])->name('destroy');
        Route::post('/restore/upload/chunk', [BackupController::class, 'uploadChunk'])->name('restore.upload.chunk');
        Route::post('/restore/upload/complete', [BackupController::class, 'uploadComplete'])->name('restore.upload.complete');
    });

    Route::get('/others', [OtherController::class, 'index'])->name('others.index');
    Route::put('/dropdown/{type}/{id}', [OtherController::class, 'updateItem']);
    Route::post('/dropdown/{type}', [OtherController::class, 'addItem']);
    Route::delete('/dropdown/{type}/{id}', [OtherController::class, 'deleteItem']);
    // Static page
    Route::resource('static-pages', StaticPageController::class);
    Route::get('/static-create', [StaticPageController::class, 'create'])->name('static.create');
    Route::post('/static-store', [StaticPageController::class, 'store'])->name('static.store');
    Route::get('/static-edit/{pages:id}', [StaticPageController::class, 'edit'])->name('static.edit');
    Route::put('/static-update/{staticPage}', [StaticPageController::class, 'update'])->name('static.update');
    route::resource('activity', ActivityController::class);
    Route::delete('/static-pg/{id}', [StaticPageController::class, 'destroy'])->name('static-pg.destroy');
  
    // Articles
    Route::get('/articles/json', [ArticleController::class, 'indexJson'])->name('articles.indexJson');
    Route::get('/articles', [ArticleController::class, 'admin'])->name('articles.admin');
    Route::patch('/articles/{article}/status', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::post('/articles/update/{article:id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

    // Route::get('/articles/{article:id}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::get('/articles/{article:id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    // Catégories
    Route::post('categories', [AdminTaxonomyController::class, 'storeCategory'])->name('categories.store');
    Route::put('categories/{category}', [AdminTaxonomyController::class, 'updateCategory'])->name('categories.update');
    Route::delete('categories/{category}', [AdminTaxonomyController::class, 'destroyCategory'])->name('categories.destroy');
    Route::post('categories/{category}/toggle', [AdminTaxonomyController::class, 'toggleCategoryStatus'])->name('categories.toggle');
    Route::get('fetchCategories', [AdminTaxonomyController::class, 'fetchCategories'])->name('categories.fetch');
    Route::get('/categories/{articleCategory:slug}', [ArticleCategoryController::class, 'show'])->name('article-categories.show');
    
    // Tags
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::put('tags/{id}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('fetchTags', [AdminTaxonomyController::class, 'fetchTags'])->name('tags.fetch');
    
    // Recherche taxonomy
    Route::get('taxonomy', [AdminTaxonomyController::class, 'index'])->name('taxonomy');
    Route::get('taxonomy/search', [AdminTaxonomyController::class, 'search'])->name('taxonomy.search');

    // Gestion des utilisateurs
    Route::resource('users', UserController::class)->except(['show']);
    
    // Rôles et permissions
    Route::resource('permissions', PermissionController::class);
    
    // Assignation des permissions aux rôles
    Route::post('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions.store');
    Route::delete('roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.destroy');
    Route::get('/new-users-count', [UserController::class, 'newUsersCount'])->name('unread.notifications.count');

    // Commentaires
    Route::get('/unread-comments', [CommentaireController::class, 'unreadCommentsCount'])->name('unread.comments');
    Route::get('/commentaires/approved', [CommentaireController::class, 'getCommentApproved'])->name('commentaires.approved');
    Route::get('/commentaires/{id}', [CommentaireController::class, 'show'])->name('commentaires.show');
    Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
    Route::get('/commentaires/{id}/approve', [CommentaireController::class, 'approve'])->name('commentaires.approve');
});




// ============================== Routes Auth ===========================================
// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/log-out', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/registerForm', [AuthController::class, 'showRegistrationForm'])->name('registerForm');

// Route pour servir les émojis
Route::get('/emojis.json', function() {
    return response()->file(public_path('emojis.json'), [
        'Content-Type' => 'application/json'
    ]);
})->name('emojis.json');
Route::get('/escort-register', function(){ $genres = Genre::all(); return view('auth.escort_register', compact('genres'));})->name('escort_register');
Route::post('/reset_password', [AuthController::class, 'sendPasswordResetLink'])->name('reset_password');
Route::get('/reset-password/{token}', [AuthController::class, 'showPasswordResetForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::get('/salon-register', function(){return view('auth.salon_register');})->name('salon_register');





// ============================== Routes Profile ===========================================
// Profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/edit-service', [AuthController::class, 'editService'])->name('profile.edit-service');
Route::post('/profile/update', [ProfileCompletionController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/update-photo', [ProfileCompletionController::class, 'updatePhoto'])->name('profile.update-photo');
Route::get('/profile-completion-percentage', [ProfileCompletionController::class, 'getProfileCompletionPercentage'])->name('profile.completion.percentage');
Route::get('/dropdown-data', [ProfileCompletionController::class, 'getDropdownData'])->name('dropdown.data');
Route::get('/dropdown-data-admin', [ProfileCompletionController::class, 'getDropdownDataAdmin'])->name('dropdown.data.admin');
Route::post('/profile/update-verification', [ProfileCompletionController::class, 'updateVerification'])->name('profile.updateVerification');
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
Route::delete('/stories/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');
Route::post('/stories/{id}/status', [StoryController::class, 'updateStatus'])->name('stories.updateStatus');


// ============================== Routes necessite une authentification ===========================================
Route::middleware('auth')->group(function () {
    // Media uploads
    Route::post('/media/upload', [MediaController::class, 'storeGallery'])->name('media.upload');
    Route::delete('/profile/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

    
    // Profile
    Route::get('/profile', [ProfileCompletionController::class, 'index'])->name('profile.index');
    Route::post('/profile/pause', [ProfileCompletionController::class, 'pauseProfile'])->name('profile.pause');
    // Messenger
    Route::get('messenger', [MessengerController::class, 'index'])->name('home-messenger');
    Route::get('messenger/search', [MessengerController::class, 'search'])->name('messenger.search');
    Route::get('messenger/id-info', [MessengerController::class, 'fetchIdInfo'])->name('messenger.id-info');
    Route::post('messenger/send-message', [MessengerController::class, 'sendMessage'])->name('messenger.send-message');
    Route::get('messenger/fetch-messages', [MessengerController::class, 'fetchMessages'])->name('messenger.fetch-messeges');
    Route::get('messenger/fetch-contacts', [MessengerController::class, 'fetchContacts'])->name('messenger.fetch-contacts');
    Route::get('messenger/update-contact-item', [MessengerController::class, 'updateContactItem'])->name('messenger.update-contact-item');
    Route::post('messenger/make-seen', [MessengerController::class, 'makeSeen'])->name('messenger.make-seen');
    Route::post('messenger/favorite', [MessengerController::class, 'favorite'])->name('messenger.favorite');
    Route::get('messenger/fetch-favorite', [MessengerController::class, 'fetchFavoritesList'])->name('messenger.fetch-favorite');
    Route::delete('messenger/delete-message', [MessengerController::class, 'deleteMessage'])->name('messenger.delete-message');

    Route::post('api/send-message', [MessengerApiController::class, 'sendMessage']);
    Route::get('api/fetch-messages', [MessengerApiController::class, 'fetchMessages']);
    Route::get('api/fetch-contacts', [MessengerApiController::class, 'fetchContacts']);
    Route::post('api/make-seen', [MessengerApiController::class, 'makeSeen']);
    Route::get('api/fetch-unread-counts', [MessengerApiController::class, 'fetchUnreadMessagesCount']);
    Route::get('api/fetch-user-info/{id}', [MessengerApiController::class, 'fetchUserInfo']);
  

    // Profile visibility
    Route::get('/profile/visibility', [ProfileVisibilityController::class, 'edit'])->name('profile.visibility.edit');
    Route::put('/profile/visibility', [ProfileVisibilityController::class, 'update'])->name('profile.visibility.update');

    // Commentaires
    Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');

    // Invitations
    Route::post('/inviterEscort', [EscortController::class, 'inviterEscorte'])->name('inviter.escorte');
    Route::post('/inviterSalon', [EscortController::class, 'inviterSalon'])->name('inviter.salon');
    Route::post('/invitations/accepter/{id}', [EscortController::class, 'accepter'])->name('accepter.invitation');
    Route::post('/invitations/refuser/{id}', [EscortController::class, 'refuser'])->name('annuler.invitation');
    Route::post('/invitations/supprimer/{id}', [EscortController::class, 'supprimerRelation'])->name('supprimer.invitation');
    Route::delete('/invitations/{id}/cancel', [EscortController::class, 'cancel'])->name('invitations.cancel');
    Route::post('/registerEscorteBySalon', [AuthController::class, 'createEscorteBySalon'])->name('createEscorteBySalon');

    // Distances
    Route::post('/update-distance', [DistanceMaxController::class, 'update'])->name('distance.update');
    
    // Escortes
    Route::get('/escorte/gerer/{id}', [EscortController::class, 'gererEscorte'])->name('escortes.gerer');
    Route::get('/goBack/{id}', [EscortController::class, 'revenirSalon'])->name('salon.revenirSalon');
    Route::delete('/escorte/delete/{id}', [EscortController::class, 'deleteEscorteCreateBySalon'])->name('escorte.delete');
    Route::post('/escorte/autonomiser/{id}', [EscortController::class, 'autonomiser'])->name('escorte.autonomiser');

    Route::get('/notifications/markAsRead/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::post('/test', [AuthController::class, 'test'])->name('test');

// ============================== Routes public ===========================================
// Recherche
Route::get('search', function(){return view('search_page');})->middleware(['web'])->name('search');
Route::get('search02', function(){return view('search_page02');})->middleware(['web'])->name('search02');

// Approximate
Route::get('/approximiter/{id}', function ($id) { return view('components.approximate', ['userId' => $id]);})->name('approximiter');

// Escort
Route::match(['get', 'post'], '/escort/{id}', [EscortController::class, 'show'])->name('show_escort');
Route::get('/salon/{id}', [SalonController::class, 'show'])->name('show_salon');
Route::match(['get', 'post'], '/escortes', [EscortController::class, 'search_escort'])->name('escortes');
Route::get('/salons', [SalonController::class, 'search_salon'])->name('salons');

// Statiques
Route::get('/{slug}', function ($slug) {
    $page = \App\Models\StaticPage::findBySlug($slug);
    return view('statique_page', compact('page'));
})->name('static.page');

