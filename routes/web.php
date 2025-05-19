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
    HideoutController,
    MessageController,
    EnemyController
};

use App\Http\Middleware\{
    CheckCharacter,
    CheckAuth,
    CheckGuest,
    CheckAdmin
};

Route::get('/', [PageController::class, 'main'])->name('pages.main');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');

Route::resource('/locations', LocationController::class)->only(['index', 'show']);
Route::resource('/items', ItemController::class)->only(['index', 'show']);
Route::resource('/enemies', EnemyController::class)->only(['index', 'show']);

Route::middleware(CheckAuth::class)->group(function () {
    Route::get('/characters/card', [CharacterController::class, 'card'])->name('characters.card');
    Route::get('/characters/select', [CharacterController::class, 'select'])->name('characters.select');
    Route::get('/characters/inventory', [CharacterController::class, 'inventory'])->name('characters.inventory');
    Route::get('/characters/craft', [CharacterController::class, 'craft'])->name('characters.craft');
    Route::post('/characters/selected/{character}',  [CharacterController::class, 'selected'])->name('characters.selected');
    Route::resource('/characters', CharacterController::class);

    Route::resource('/users', UserController::class);
    Route::get('/auth', [AuthController::class, 'main'])->name('users.main');
    Route::post('/logout', [AuthController::class, 'logout'])->name('users.logout');

    Route::middleware(CheckCharacter::class)->group(function () {
        Route::resource('/hideouts', HideoutController::class);
        Route::resource('/transitions', TransitionController::class);
        Route::resource('/messages', MessageController::class);

        Route::post('/enemies/battle', [EnemyController::class, 'battle'])->name('enemies.battle');

        Route::post('/items/disassemble', [ItemController::class, 'disassemble'])->name('items.disassemble');
        Route::post('/items/assemble', [ItemController::class, 'assemble'])->name('items.assemble');
        Route::post('/items/move', [ItemController::class, 'move'])->name('items.move');
        Route::post('/items/equip', [ItemController::class, 'equip'])->name('items.equip');
        Route::post('/items/unequip', [ItemController::class, 'unequip'])->name('items.unequip');
    });

    Route::middleware(CheckAdmin::class)->group(function () {});
});

Route::middleware(CheckGuest::class)->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('users.login');
    Route::post('/authorization', [AuthController::class, 'authorization'])->name('users.authorization');
    Route::get('/register',  [AuthController::class, 'register'])->name('users.register');
    Route::post('/registration',  [AuthController::class, 'registration'])->name('users.registration');
});
