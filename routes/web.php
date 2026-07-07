<?php

use App\Http\Controllers\Auth\GoogleOAuthController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\NovinkyController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SosController;
use App\Http\Controllers\UserPublicController;
use App\Http\Controllers\WalksController;
use Illuminate\Support\Facades\Route;

// Beta access gate — shared password screen shown before the site is usable.
Route::get('/gate', function () {
    if (! config('platform.gate_password') || session('site_gate_unlocked')) {
        return redirect()->route('home');
    }

    return view('gate');
})->name('gate.show');

Route::post('/gate', function (\Illuminate\Http\Request $request) {
    $request->validate(['password' => ['required', 'string']]);

    if (hash_equals((string) config('platform.gate_password'), $request->input('password'))) {
        $request->session()->put('site_gate_unlocked', true);

        return redirect()->intended(route('home'));
    }

    return back()->withErrors(['password' => 'Nesprávne prístupové heslo.']);
})->name('gate.unlock');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/support', 'support')->name('support');
Route::view('/cookies', 'cookies')->name('cookies');

// Novinky (public read)
Route::get('/novinky', [NovinkyController::class, 'index'])->name('novinky.index');
Route::get('/novinky/{novinka:slug}', [NovinkyController::class, 'show'])->name('novinky.show');

Route::get('/learn', [LearnController::class, 'index'])->name('learn.index');
Route::get('/learn/{topic:slug}', [LearnController::class, 'show'])->name('learn.show');

// Places (public)
Route::get('/places', [PlacesController::class, 'index'])->name('places.index');
Route::get('/places/{place}', [PlacesController::class, 'show'])->name('places.show');

// Search (public — auth not required, but app shell hides if not logged in)
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Walks / Forum (public read)
Route::get('/walks', [WalksController::class, 'index'])->name('walks.index');
Route::get('/walks/{topic}', [WalksController::class, 'show'])->name('walks.show');

// SOS (public read)
Route::get('/sos', [SosController::class, 'index'])->name('sos.index');
Route::get('/sos/help', [SosController::class, 'help'])->name('sos.help');

// Signed links sent by e-mail (GDPR export download + account-deletion confirm).
// Authorised by the temporary signature, so they work straight from the inbox.
Route::middleware('signed')->group(function () {
    Route::get('/odhlasit/{user}/{pref}', \App\Http\Controllers\UnsubscribeController::class)
        ->name('notifications.unsubscribe');
    Route::get('/settings/export/download/{user}', [SettingsController::class, 'downloadExport'])
        ->name('settings.export.download');
    Route::get('/settings/account/confirm-delete/{user}', [SettingsController::class, 'confirmDeleteShow'])
        ->name('settings.account.delete.confirm');
    Route::post('/settings/account/confirm-delete/{user}', [SettingsController::class, 'confirmDeletePerform'])
        ->name('settings.account.delete.perform');
});

// One-time onboarding for Google-OAuth users (birth year + consents).
Route::middleware('auth')->group(function () {
    Route::get('/onboarding', [\App\Http\Controllers\Auth\OnboardingController::class, 'show'])->name('onboarding.show');
    Route::post('/onboarding', [\App\Http\Controllers\Auth\OnboardingController::class, 'store'])->name('onboarding.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/sos', [SosController::class, 'store'])->name('sos.store');
    // Learn interactivity
    Route::post('/learn/{topic:slug}/like', [LearnController::class, 'toggleLike'])->name('learn.like');
    Route::post('/learn/{topic:slug}/comments', [LearnController::class, 'storeComment'])->name('learn.comments.store');
    Route::post('/learn/comments/{comment}/report', [LearnController::class, 'reportComment'])->name('learn.comments.report');
    Route::post('/learn/suggest', [LearnController::class, 'storeSuggestion'])->name('learn.suggest');

    // Profile (own)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/with-dog-photo', [ProfileController::class, 'addWithDogPhoto'])->name('profile.with-dog-photo.add');
    Route::delete('/profile/with-dog-photo', [ProfileController::class, 'removeWithDogPhoto'])->name('profile.with-dog-photo.remove');

    // Dog (own — single)
    Route::get('/dog/new', [DogController::class, 'create'])->name('dog.create');
    Route::post('/dog', [DogController::class, 'store'])->name('dog.store');
    Route::get('/dog/{dog}/edit', [DogController::class, 'edit'])->name('dog.edit');
    Route::patch('/dog/{dog}', [DogController::class, 'update'])->name('dog.update');
    Route::delete('/dog/{dog}/photo', [DogController::class, 'removePhoto'])->name('dog.photo.destroy');
    Route::delete('/dog/{dog}', [DogController::class, 'destroy'])->name('dog.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/account', [SettingsController::class, 'account'])->name('settings.account');
    Route::get('/settings/email', [SettingsController::class, 'emailForm'])->name('settings.email');
    Route::patch('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::get('/settings/password', [SettingsController::class, 'passwordForm'])->name('settings.password');
    Route::post('/settings/password', [SettingsController::class, 'sendPasswordReset'])->name('settings.password.send');
    Route::get('/settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::post('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::get('/settings/blocked', [SettingsController::class, 'blocked'])->name('settings.blocked');
    Route::get('/settings/two-factor', [\App\Http\Controllers\Auth\TwoFactorController::class, 'show'])->name('settings.two-factor');
    Route::post('/settings/two-factor/enable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'enable'])->name('settings.two-factor.enable');
    Route::post('/settings/two-factor/confirm', [\App\Http\Controllers\Auth\TwoFactorController::class, 'confirm'])->name('settings.two-factor.confirm');
    Route::post('/settings/two-factor/disable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'disable'])->name('settings.two-factor.disable');
    Route::get('/settings/export', [SettingsController::class, 'export'])->name('settings.export');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.account.delete');

    // Public user profile
    Route::get('/u/{user}', [UserPublicController::class, 'show'])->name('users.show');
    Route::post('/u/{user}/friend', [UserPublicController::class, 'addFriend'])->name('users.friend');
    Route::post('/u/{user}/block', [UserPublicController::class, 'block'])->name('users.block');
    Route::delete('/u/{user}/block', [UserPublicController::class, 'unblock'])->name('users.unblock');

    // Novinky write (admin only — enforced in controller)
    Route::post('/novinky', [NovinkyController::class, 'store'])->name('novinky.store');
    Route::patch('/novinky/{novinka}', [NovinkyController::class, 'update'])->name('novinky.update');
    Route::delete('/novinky/{novinka}', [NovinkyController::class, 'destroy'])->name('novinky.destroy');

    // Friends
    Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
    Route::post('/friends/{friendship}/{action}', [FriendsController::class, 'respond'])
        ->whereIn('action', ['accept', 'decline'])->name('friends.respond');
    Route::delete('/friends/{friendship}', [FriendsController::class, 'unfriend'])->name('friends.unfriend');

    // Place suggestion
    Route::post('/places/suggest', [PlacesController::class, 'suggest'])->name('places.suggest');

    // Walks/Forum write
    Route::post('/walks', [WalksController::class, 'store'])->name('walks.store');
    Route::delete('/walks/{topic}', [WalksController::class, 'destroy'])->name('walks.destroy');
    Route::post('/walks/{topic}/comments', [WalksController::class, 'storeComment'])->name('walks.comments.store');
    Route::delete('/walks/comments/{comment}', [WalksController::class, 'deleteComment'])->name('walks.comments.delete');
    Route::post('/walks/comments/{comment}/report', [WalksController::class, 'reportComment'])->name('walks.comments.report');
    Route::post('/walks/{topic}/report', [WalksController::class, 'reportTopic'])->name('walks.topics.report');
});

// Google OAuth (Socialite)
Route::get('/auth/google/redirect', [GoogleOAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleOAuthController::class, 'callback'])->name('auth.google.callback');

require __DIR__.'/auth.php';
