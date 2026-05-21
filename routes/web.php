<?php

use App\Http\Controllers\ImageController;
use App\Livewire\CreateItem;
use App\Livewire\EditItem;
use App\Livewire\SearchItems;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\ShowItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    // ログイン済みの場合はsearch-itemsへ
    if (Auth::check()) {
        return redirect('/search-items');
    }
    // 未ログインの場合はサインアップページへ
    return redirect()->route('register');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    // Route::get('settings/two-factor', TwoFactor::class)
    //     ->middleware(
    //         when(
    //             Features::canManageTwoFactorAuthentication()
    //                 && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
    //             ['password.confirm'],
    //             [],
    //         ),
    //     )
    //     ->name('two-factor.show');

    Route::get('/items/create', CreateItem::class)->name('items.create');
    Route::get('/items/{item}', ShowItem::class)->name('item');
    Route::get('/items/{item}/edit', EditItem::class)->name('items.edit');

    Route::get('/images/{filename}', [ImageController::class, 'show'])->name('image.show');

    Route::get('/search-items', SearchItems::class)->name('search-items');
});