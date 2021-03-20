<?php

namespace App\Http\Controllers;

use App\Models\Challenge;

class ChallengesController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with('banners')->with('category')->whereNotNull('published_at');

        return view('challenge.index', [
            'challenges' => $challenges->get()
        ]);
    }
}
