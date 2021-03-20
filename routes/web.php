<?php

use App\Http\Controllers\App\ChallengeController;
use App\Http\Controllers\App\ChallengeSelectController;
use App\Http\Controllers\App\TeamController;
use App\Http\Controllers\App\TeamJoinController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImprintController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrivacyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);
Route::get('karte', [MapController::class, 'index']);
Route::get('teilnehmer', [ParticipantController::class, 'index']);
Route::get('challenges', [ChallengesController::class, 'index']);
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
    Route::get('challenge', [ChallengeController::class, 'index'])->name('challenge.index');

    Route::get('challenge/create', [ChallengeController::class, 'create'])->name('challenge.create');
    Route::post('challenge', [ChallengeController::class, 'store'])->name('challenge.store');

    Route::get('challenge/edit/{id}', [ChallengeController::class, 'edit'])->name('challenge.edit');
    Route::get('challenge/publish/{id}', [ChallengeController::class, 'publish'])->name('challenge.publish');
    Route::get('challenge/unpublish/{id}', [ChallengeController::class, 'unpublish'])->name('challenge.unpublish');
    Route::post('challenge/update', [ChallengeController::class, 'update'])->name('challenge.update');
    Route::get('challenge/delete/{id}', [ChallengeController::class, 'delete'])->name('challenge.delete');

    Route::get('challenge/selection/{team_id}', [ChallengeSelectController::class, 'selection'])->name('challenge.selection');
    Route::get('challenge/select/{team_id}/{challenge_id}', [ChallengeSelectController::class, 'select'])->name('challenge.select');
});
