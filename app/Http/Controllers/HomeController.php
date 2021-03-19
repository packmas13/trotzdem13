<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class HomeController
{
    public function index()
    {
        $bannerStart = Carbon::createFromDate(2021, 4, 23, 'Europe/Berlin');

        return view('home', ['days_left' => $bannerStart->diffInDays(), 'banner_start' => $bannerStart]);
    }
}
