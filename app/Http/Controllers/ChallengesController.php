<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ChallengesController extends Controller
{
    public function index(Request $request)
    {
        $challenges = Challenge::with('banners')->with('category')->published();

        $banner_id = $request->get('banner_id');
        if (!empty($banner_id)) {
            $challenges->whereHas('banners', function (Builder $query) use ($banner_id) {
                $query->where('id', '=', $banner_id);
            });
        }

        return view('challenges', [
            'challenges' => $challenges->inRandomOrder()->get(),
            'banners' => Banner::all(),
            'current_banner' => $banner_id,
        ]);
    }
}
