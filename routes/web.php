<?php

use App\Http\Controllers\App\ChallengeCustomController;
use App\Http\Controllers\App\ChallengeSelectController;
use App\Http\Controllers\App\PostController;
use App\Http\Controllers\App\TeamController;
use App\Http\Controllers\App\TeamJoinController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\ConditionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImprintController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Orga\BannerTrackController;
use App\Http\Controllers\Orga\ChallengeApprovalController;
use App\Http\Controllers\Orga\ChallengeController;
use App\Http\Controllers\Orga\HandoverController;
use App\Http\Controllers\Orga\TeamApprovalController;
use App\Http\Controllers\Orga\TeamExportController;
use App\Http\Controllers\Orga\TeamUsersEmailsController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PrivacyController;
use App\Http\Middleware\OnlyOrgaTeam;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index']);
Route::get('karte', [MapController::class, 'index']);
Route::get('teilnehmer', [ParticipantController::class, 'index']);
Route::get('projekte', [ChallengesController::class, 'index']);
Route::get('ablauf', [ConditionsController::class, 'index']);

Route::get('impressum', [ImprintController::class, 'index']);
Route::get('datenschutz', [PrivacyController::class, 'index']);
Route::get('datenschutz/leiter', [PrivacyController::class, 'leader']);

Route::redirect('datenschutz/einwilligung-foto', 'https://dpsg.de/fileadmin/daten/dokumente/infopool/corporatedesign/Oeffentlichkeitsarbeit/DPSG_Einwilligung_Foto_Video.pdf');



Route::prefix('app')->middleware(['auth:sanctum', 'verified'])->name('app.')->group(function () {
    Route::redirect('/', '/app/team');
    Route::get('team', [TeamController::class, 'index'])->name('team.index');

    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team', [TeamController::class, 'store'])->name('team.store');

    Route::post('team/image/{team}', [TeamController::class, 'image'])->name('team.image');

    Route::get('team/join', [TeamJoinController::class, 'show'])->name('team.join');
    Route::post('team/join', [TeamJoinController::class, 'store']);

    Route::prefix('orga')->middleware(OnlyOrgaTeam::class)->name('orga.')->group(function () {
        Route::get('team/approval/pending', [TeamApprovalController::class, 'pending'])->name('team.pending');
        Route::post('team/approval', [TeamApprovalController::class, 'store'])->name('team.approve');
        Route::get('team/list', [TeamApprovalController::class, 'index'])->name('team.list');

        Route::get('bannertrack/setup', [BannerTrackController::class, 'setup'])->name('bannertrack.setup');

        Route::post('handover', [HandoverController::class, 'store'])->name('handover.store');
        Route::put('handover/{handover}', [HandoverController::class, 'update'])->name('handover.update');

        Route::get('challenge', [ChallengeController::class, 'index'])->name('challenge.index');

        Route::get('challenge/create', [ChallengeController::class, 'create'])->name('challenge.create');
        Route::post('challenge', [ChallengeController::class, 'store'])->name('challenge.store');

        Route::get('challenge/edit/{id}', [ChallengeController::class, 'edit'])->name('challenge.edit');
        Route::get('challenge/publish/{id}', [ChallengeController::class, 'publish'])->name('challenge.publish');
        Route::get('challenge/unpublish/{id}', [ChallengeController::class, 'unpublish'])->name('challenge.unpublish');
        Route::post('challenge/update', [ChallengeController::class, 'update'])->name('challenge.update');
        Route::post('challenge/delete/{id}', [ChallengeController::class, 'delete'])->name('challenge.delete');

        Route::get('challenge/custom', [ChallengeApprovalController::class, 'index'])->name('challenge.custom');
        Route::post('challenge/custom/approve', [ChallengeApprovalController::class, 'approve'])->name('challenge.approve');
        Route::post('challenge/custom/convert', [ChallengeApprovalController::class, 'convert'])->name('challenge.convert');

        Route::get('export/team-users-emails', [TeamUsersEmailsController::class, 'index']);
        Route::get('export/teams.ods', [TeamExportController::class, 'ods']);
    });

    Route::get('challenge/selection/{team_id}', [ChallengeSelectController::class, 'selection'])->name('challenge.selection');
    Route::get('challenge/select/{team_id}/{challenge_id}', [ChallengeSelectController::class, 'select'])->name('challenge.select');

    Route::get('challenge/custom/{team_id}', [ChallengeCustomController::class, 'create'])->name('challenge.custom');
    Route::post('challenge/custom/{team_id}', [ChallengeCustomController::class, 'store'])->name('challenge.custom.store');

    Route::get('post', [PostController::class, 'index'])->name('post.index');
    Route::post('post', [PostController::class, 'store'])->name('post.store');

    Route::get('post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('post/update/{post}', [PostController::class, 'update'])->name('post.update');

    Route::post('post/delete/{post}', [PostController::class, 'delete'])->name('post.delete');

    Route::post('post/react', [PostController::class, 'react'])->name('post.react');
    Route::post('post/unreact', [PostController::class, 'unreact'])->name('post.unreact');

    Route::post('comment', [PostController::class, 'comment'])->name('comment.store');
});
