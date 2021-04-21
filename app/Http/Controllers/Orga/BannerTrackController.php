<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $banner->load(['teams.troop', 'teams.district', 'teams.banner', 'teams.handovers'])->get();

        $banner->teams->transform(function ($team) {
            $team->handover = $team->first_handover();
            if (!empty($team->image)) {
                $team->image = Storage::disk('upload')->url($team->image);
            }
            return $team;
        });

        $sorted_teams = $banner->teams->sortBy(function ($team) {
            $date = $team->handover->received_at ?? null;
            // with date first
            return [$date ? 0 : 1, $date];
        })->values();

        return Inertia::render('orga/bannertrack/Setup', [
            'banners' => $banners,
            'banner' => $banner,
            'sorted_teams' => $sorted_teams,
        ]);
    }
}
