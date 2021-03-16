<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImprintController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamJoinController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);
Route::get('karte', [MapController::class, 'index']);
Route::get('teilnehmer', [ParticipantController::class, 'index']);
Route::get('challenges', [ChallengeController::class, 'index']);
Route::get('impressum', [ImprintController::class, 'index']);
Route::get('datenschutz', [PrivacyController::class, 'index']);

// TODO below
//  function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::prefix('app')->middleware(['auth:sanctum', 'verified'])->name('app.')->group(function () {
    Route::get('team', [TeamController::class, 'index'])->name('team.index');

    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team', [TeamController::class, 'store'])->name('team.store');

    Route::get('team/join', [TeamJoinController::class, 'show'])->name('team.join');
    Route::post('team/join', [TeamJoinController::class, 'store']);

    Route::get('challenge/list', [ChallengeController::class, 'list'])->name('challenge.list');
    Route::get('challenge/create', [ChallengeController::class, 'create'])->name('challenge.create');
    Route::get('challenge/edit/{id}', [ChallengeController::class, 'edit'])->name('challenge.edit');
    Route::get('challenge/delete/{id}', [ChallengeController::class, 'delete'])->name('challenge.delete');
    Route::post('challenge', [ChallengeController::class, 'store'])->name('challenge.store');
});
