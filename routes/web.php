<?php

// Importation des classes
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
// Importation des models
use App\Models\Gallery;
use App\Models\Genre;

// Importation des controllers
use App\Http\Controllers\{
    AuthController,
    MessengerController,
    AboutController,
    ArticleController,
    ArticleCategoryController,
    CgvController,
    ContactController,
    FaqController,
    HomeController,
    PdcController,
    ProfileCompletionController,
    ProfileVisibilityController,
    PratiqueSexuelleController,
    EscortController,
    SalonController,
    TagController,
    CommentaireController,
    NotificationController,
    DistanceMaxController,
    TaxonomyController,
};

// Importation des controllers admin
use App\Http\Controllers\Admin\{
    ActivityController,
    PermissionController,
    RoleController,
    StaticPageController,
    UserController,
};




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
})->middleware(['web'])->name('livewire.update');

// =================================== Routes public =========================================
// Home
Route::get('/', [HomeController::class, 'home'])->name('home');
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
    // Static page
    Route::resource('static-pages', StaticPageController::class);
    Route::get('/static-create', [StaticPageController::class, 'create'])->name('static.create');
    Route::post('/static-store', [StaticPageController::class, 'store'])->name('static.store');
    Route::get('/static-edit/{pages:id}', [StaticPageController::class, 'edit'])->name('static.edit');
    Route::put('/static-update/{staticPage}', [StaticPageController::class, 'update'])->name('static.update');
    route::resource('activity', ActivityController::class);
  
    // Articles
    Route::get('/articles/json', [ArticleController::class, 'indexJson'])->name('articles.indexJson');
    Route::get('/articles', [ArticleController::class, 'admin'])->name('articles.admin');
    Route::patch('/articles/{article}/status', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::post('/articles/update/{article:id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article:id}', [ArticleController::class, 'edit'])->name('articles.edit');

    // Catégories
    Route::post('categories', [TaxonomyController::class, 'storeCategory'])->name('categories.store');
    Route::put('categories/{category}', [TaxonomyController::class, 'updateCategory'])->name('categories.update');
    Route::delete('categories/{category}', [TaxonomyController::class, 'destroyCategory'])->name('categories.destroy');
    Route::post('categories/{category}/toggle', [TaxonomyController::class, 'toggleCategoryStatus'])->name('categories.toggle');
    Route::get('fetchCategories', [TaxonomyController::class, 'fetchCategories'])->name('categories.fetch');
    Route::get('/categories/{articleCategory:slug}', [ArticleCategoryController::class, 'show'])->name('article-categories.show');
    
    // Tags
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::get('fetchTags', [TagController::class, 'fetchTags'])->name('tags.fetch');
    
    // Recherche taxonomy
    Route::get('taxonomy', [TaxonomyController::class, 'index'])->name('taxonomy');
    Route::get('taxonomy/search', [TaxonomyController::class, 'search'])->name('taxonomy.search');

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
Route::get('/escort-register', function(){ $genres = Genre::all(); return view('auth.escort_register', compact('genres'));})->name('escort_register');
Route::post('/reset_password', [AuthController::class, 'sendPasswordResetLink'])->name('reset_password');
Route::get('/salon-register', function(){return view('auth.salon_register');})->name('salon_register');


// ============================== Routes Profile ===========================================
// Profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile/update', [ProfileCompletionController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/update-photo', [ProfileCompletionController::class, 'updatePhoto'])->name('profile.update-photo');
Route::get('/profile-completion-percentage', [ProfileCompletionController::class, 'getProfileCompletionPercentage'])->name('profile.completion.percentage');
Route::get('/dropdown-data', [ProfileCompletionController::class, 'getDropdownData'])->name('dropdown.data');
Route::post('/profile/update-verification', [ProfileCompletionController::class, 'updateVerification'])->name('profile.updateVerification');



// ============================== Routes necessite une authentification ===========================================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileCompletionController::class, 'index'])->name('profile.index');
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
    Route::delete('/invitations/{id}/cancel', [EscortController::class, 'cancel'])->name('invitations.cancel');
    Route::post('/registerEscorteBySalon', [AuthController::class, 'createEscorteBySalon'])->name('createEscorteBySalon');

    // Distances
    Route::post('/update-distance', [DistanceMaxController::class, 'update'])->name('distance.update');
    
    // Escortes
    Route::get('/escorte/gerer/{id}', [EscortController::class, 'gererEscorte'])->name('escortes.gerer');
    Route::get('/goBack/{id}', [EscortController::class, 'revenirSalon'])->name('salon.revenirSalon');
    Route::delete('/escorte/delete/{id}', [EscortController::class, 'deleteEscorteCreateBySalon'])->name('escorte.delete');
    Route::post('/escorte/autonomiser/{id}', [EscortController::class, 'autonomiser'])->name('escorte.autonomiser');
});


// ============================== Routes public ===========================================
// Recherche
Route::get('search', function(){return view('search_page');})->middleware(['web'])->name('search');

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

