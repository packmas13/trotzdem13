<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Http\Resources\orga\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TeamApprovalController extends Controller
{
    public function pending(Request $request)
    {
        $user = $request->user();
        $teams = $user->teams;
        $teams = Team::whereNull('approved_at')->get();
        $teams->load('users', 'troop', 'district', 'banner', 'currentChallenges.banners', 'currentChallenges.category');

        TeamResource::withoutWrapping();
        return Inertia::render('orga/team/ApprovalPending', [
            'teams' => TeamResource::collection($teams),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'approved' => ['required', 'bool'],
            'team_id' => ['required', 'exists:teams,id'],
            'reason' => [Rule::requiredIf(!$request->boolean('approved')), 'nullable', 'string'],
        ]);

        $team = Team::where(['id' => $data['team_id']]);
        if ($request->boolean('approved')) {
            $team->update(['approved_at' => now()]);
        } else {
            $team->update(['deletion_reason' => $data['reason']]);
            $team->delete();
        }
        return redirect()->back();
    }
}
