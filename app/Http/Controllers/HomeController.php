<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Support\Carbon;

class HomeController
{
    public function index()
    {
        $bannerStart = Carbon::create(2021, 4, 23, 18, 0, 0, 'Europe/Berlin');
        $bannerEnd = Carbon::create(2021, 9, 18, 0, 0, 0, 'Europe/Berlin');

        if($bannerStart->isFuture() || $bannerStart->isToday()){
            $start_days_left = $bannerStart->diffInDays();
        } else {
            $start_days_left = -1;
        }

        return view('home', [
            'banner_start' => $bannerStart,
            'start_days_left' => $start_days_left,

            'banner_end' => $bannerEnd,
            'end_days_left' => $bannerEnd->diffInDays(),

            'team_count' => Team::whereNotNull('approved_at')->count(),
            'challenge_count' => Challenge::published()->count(),
        ]);
    }
}
