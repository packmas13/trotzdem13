<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Support\Carbon;

class HomeController
{
    public function index()
    {
        $bannerStart = Carbon::createFromDate(2021, 4, 23, 'Europe/Berlin');
        $bannerEnd = Carbon::createFromDate(2021, 9, 18, 'Europe/Berlin');

        if ($bannerStart->isFuture() || $bannerStart->isToday()) {
            $start_days_left = $bannerStart->diffInDays();
        } else {
            $start_days_left = -1;
        }

        $teams = Team::whereNotNull('approved_at')->get();

        return view('home', [
            'banner_start' => $bannerStart,
            'start_days_left' => $start_days_left,

            'banner_end' => $bannerEnd,
            'end_days_left' => $bannerEnd->diffInDays(),

            'participant_count' => $teams->sum('size'),
            'team_count' => $teams->count(),
            'challenge_count' => Challenge::published()->has('teams')->count(),
            'banner_count' => Banner::sum('variants'),
        ]);
    }
}
