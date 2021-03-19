<?php

namespace App\Http\Controllers;

use App\Models\Challenge;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with('banners')->with('category')->whereNotNull('published_at');

        return view('challenge.index', [
            'challenges' => $challenges->getModels()
        ]);
    }
}
