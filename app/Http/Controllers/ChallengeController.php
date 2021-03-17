<?php

namespace App\Http\Controllers;

use App\Models\Challenge;

class ChallengeController extends Controller
{
    public function index()
    {
        // TODO: reduce to only published
        $list = Challenge::whereNotNull('published_at');

        $challenges = [];
        foreach ($list as $challenge) {
            $challenges[] = [
                'title' => $challenge->title,
                'description' => $challenge->description,
            ];
        }

        return view('challenge.index', [
            'challenges' => $challenges
        ]);
    }
}
