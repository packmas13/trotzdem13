<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Support\Carbon;

class HomeController
{
    public function index()
    {
        $bannerStart = Carbon::createFromDate(2021, 4, 23, 'Europe/Berlin');

        return view('home', [
            'days_left' => $bannerStart->diffInDays(),
            'banner_start' => $bannerStart,
            'team_count' => Team::whereNotNull('approved_at')->count(),
            'challenge_count' => Challenge::published()->count(),
        ]);
    }
}
