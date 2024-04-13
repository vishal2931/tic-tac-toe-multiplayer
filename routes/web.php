<?php

use App\Http\Controllers\LobbyController;
use App\Livewire\GameComponent;
use App\Livewire\LobbyComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('lobby', LobbyController::class)->only(['create', 'store']);
Route::prefix('lobby')->controller(LobbyController::class)->group(function () {
    Route::get('/join', 'join')->name('lobby.join');
    Route::post('/join', 'join_post')->name('lobby.join');
});
Route::get('lobby/area/{joining_code}', LobbyComponent::class)->name('lobby.area');
Route::get('play/game/{joining_code}', GameComponent::class)->name('play.game');
