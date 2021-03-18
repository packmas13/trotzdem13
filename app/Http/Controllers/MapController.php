<?php

namespace App\Http\Controllers;

use App\MapHelper;

class MapController
{
    public function index()
    {
        $map = new MapHelper;
        return view('map', [
            'center' => $map->center(),
            'boundNorthEast' => $map->boundNorthEast(),
            'boundSouthWest' => $map->boundSouthWest(),
        ]);
    }
}
