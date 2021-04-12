<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BannerTrackController extends Controller
{
    public function setup(Request $request)
    {
        $banners = Banner::all();

        if ($request->has('banner_id')) {
            $banner_id = $request->get('banner_id');
            $banner = $banners->first(function ($b) use ($banner_id) {
                return $b->id == $banner_id;
            });
        } else {
            $banner = $banners->first();
        }
        $banner->load(['teams.troop', 'teams.district'])->get();

        return Inertia::render('orga/bannertrack/Setup', [
            'banners' => $banners,
            'banner' => $banner,
        ]);
    }
}
