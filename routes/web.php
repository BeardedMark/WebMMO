<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    UserController,
    PageController,
    CharacterController,
    LocationController,
    RoadController,
    TransitionController,
    ItemController,
    HideoutController
};

use App\Http\Middleware\{
    CheckCharacter,
    CheckAuth
};


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/authorization', [AuthController::class, 'authorization'])->name('auth.authorization');
    Route::get('/register',  [AuthController::class, 'register'])->name('auth.register');
    Route::post('/registration',  [AuthController::class, 'registration'])->name('auth.registration');
});

Route::middleware(CheckAuth::class)->group(function () {
});

Route::get('/auth', [AuthController::class, 'main'])->name('auth.main');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/', [PageController::class, 'main'])->name('pages.main');

Route::resource('/users', UserController::class);
Route::resource('/locations', LocationController::class);
Route::resource('/hideouts', HideoutController::class);
Route::resource('/transitions', TransitionController::class)->middleware(CheckAuth::class);

Route::post('/items/move', [ItemController::class, 'move'])->name('items.move');
Route::post('/items/moves', [ItemController::class, 'moves'])->name('items.moves');
Route::post('/items/swap', [ItemController::class, 'swap'])->name('items.swap');
Route::resource('/items', ItemController::class);

Route::get('/characters/select', [CharacterController::class, 'select'])->name('characters.select');
Route::post('/characters/selected/{character}',  [CharacterController::class, 'selected'])->name('characters.selected');
Route::resource('/characters', CharacterController::class);
Route::resource('/characters', CharacterController::class)->except(['index', 'show'])->middleware(CheckAuth::class);
