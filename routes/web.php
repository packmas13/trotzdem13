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



Route::prefix('app')->middleware(['auth:sanctum', 'verified'])->name('app.')->group(function () {
    Route::redirect('/', '/app/team');
    Route::get('team', [TeamController::class, 'index'])->name('team.index');

    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team', [TeamController::class, 'store'])->name('team.store');

    Route::get('team/join', [TeamJoinController::class, 'show'])->name('team.join');
    Route::post('team/join', [TeamJoinController::class, 'store']);

    // Challenge
    Route::get('challenge', [App\ChallengeController::class, 'index'])->name('challenge.index');

    Route::get('challenge/create', [App\ChallengeController::class, 'create'])->name('challenge.create');
    Route::post('challenge', [App\ChallengeController::class, 'store'])->name('challenge.store');

    Route::get('challenge/edit/{id}', [App\ChallengeController::class, 'edit'])->name('challenge.edit');
    Route::get('challenge/publish/{id}', [App\ChallengeController::class, 'publish'])->name('challenge.publish');
    Route::get('challenge/unpublish/{id}', [App\ChallengeController::class, 'unpublish'])->name('challenge.unpublish');
    Route::post('challenge/update', [App\ChallengeController::class, 'update'])->name('challenge.update');
    Route::get('challenge/delete/{id}', [App\ChallengeController::class, 'delete'])->name('challenge.delete');
});
