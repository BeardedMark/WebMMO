<?php

use Illuminate\Support\Facades\Route;

use App\Domains\Locations\Http\Controllers\LocationController;
use App\Domains\Characters\Http\Controllers\CharacterController;
use App\Domains\Enemies\Http\Controllers\EnemyController;
use App\Domains\Items\Http\Controllers\ItemController;

use App\Http\Controllers\{
    AuthController,
    UserController,
    PageController,
    TransitionController,
    ContainerController,
    BattleController
};

use App\Http\Middleware\{
    CheckCharacter,
    CheckBattle,
    CheckAuth,
    CheckGuest,
    CheckAdmin
};

Route::get('/', [PageController::class, 'main'])->name('pages.main');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/gameplay', [PageController::class, 'gameplay'])->name('pages.gameplay');
Route::get('/lore', [PageController::class, 'lore'])->name('pages.lore');
Route::get('/gallery', [PageController::class, 'gallery'])->name('pages.gallery');


Route::resource('/locations', LocationController::class)->only(['index', 'show']);
Route::resource('/items', ItemController::class)->only(['index', 'show']);
Route::resource('/enemies', EnemyController::class)->only(['index', 'show']);
Route::resource('/containers', ContainerController::class)->only(['index', 'show']);

Route::middleware(CheckAuth::class)->group(function () {
    Route::get('/characters/values', [CharacterController::class, 'values'])->name('characters.values');
    Route::get('/characters/card', [CharacterController::class, 'card'])->name('characters.card');
    Route::get('/characters/select', [CharacterController::class, 'select'])->name('characters.select');
    Route::get('/characters/inventory', [CharacterController::class, 'inventory'])->name('characters.inventory');
    Route::get('/characters/craft', [CharacterController::class, 'craft'])->name('characters.craft');
    Route::post('/characters/selected/{character}',  [CharacterController::class, 'selected'])->name('characters.selected');
    Route::resource('/characters', CharacterController::class);

    Route::resource('/users', UserController::class);
    Route::get('/auth', [AuthController::class, 'main'])->name('users.main');
    Route::post('/logout', [AuthController::class, 'logout'])->name('users.logout');

    Route::resource('/battles', BattleController::class);
    Route::post('/battles/{battle}/apply', [BattleController::class, 'apply'])->name('battles.apply');
    Route::post('/battles/{battle}/confirm', [BattleController::class, 'confirm'])->name('battles.confirm');
    Route::post('/battles/{battle}/reject', [BattleController::class, 'reject'])->name('battles.reject');
    Route::post('/battles/{battle}/cancel', [BattleController::class, 'cancelApplication'])->name('battles.cancel');
    Route::post('/battles/{battle}/escape', [BattleController::class, 'escape'])->name('battles.escape');

    Route::middleware(CheckCharacter::class)->group(function () {
        Route::resource('/transitions', TransitionController::class);


        Route::middleware(CheckBattle::class)->group(function () {
            Route::resource('/transitions', TransitionController::class)->only(['store', 'update']);
            Route::resource('/battles', BattleController::class)->only(['create', 'store']);
        });

        Route::post('/enemies/{uuid}/battle', [EnemyController::class, 'battle'])->name('enemies.battle');
        Route::post('/enemies/{uuid}/autobattle', [BattleController::class, 'autobattle'])->name('enemies.autobattle');

        Route::post('/containers/{uuid}/interact', [ContainerController::class, 'interact'])->name('containers.interact');

        Route::post('/items/{code}/assemble', [ItemController::class, 'assemble'])->name('items.assemble');
        Route::post('/items/{uuid}/disassemble', [ItemController::class, 'disassemble'])->name('items.disassemble');

        Route::post('/items/move', [ItemController::class, 'move'])->name('items.move');
        Route::post('/items/equip', [ItemController::class, 'equip'])->name('items.equip');
        Route::post('/items/unequip', [ItemController::class, 'unequip'])->name('items.unequip');
    });

    Route::middleware(CheckAdmin::class)->group(function () {});
});

Route::middleware(CheckGuest::class)->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('users.login');
    Route::post('/authorization', [AuthController::class, 'authorization'])->name('users.authorization');
});
    Route::get('/register',  [AuthController::class, 'register'])->name('users.register');
    Route::post('/registration',  [AuthController::class, 'registration'])->name('users.registration');
