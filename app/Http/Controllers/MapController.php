<?php

namespace App\Http\Controllers;

use App\MapHelper;
use App\Models\Banner;
use App\Models\Team;

class MapController
{
    public function index()
    {
        $map = new MapHelper;
        return view('map', [
            'center' => $map->center(),
            'boundNorthEast' => $map->boundNorthEast(),
            'boundSouthWest' => $map->boundSouthWest(),
            'banners' => Banner::all(),
            'teams' => Team::whereNotNull('approved_at')->select('location', 'banner_id')->get(),
        ]);
    }
}
