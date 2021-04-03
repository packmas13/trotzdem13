<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ChallengeApprovalController extends Controller
{
    public function index(Request $request)
    {
        $challenges = Challenge::with(['team', 'category', 'banners', 'team.banner', 'team.troop', 'team.district'])->has('team')->orderBy('approved_at')->get();

        return Inertia::render('orga/challenge/custom/List', [
            'challenges' => $challenges,
        ]);
    }

    public function approve(Request $request)
    {
        $data = $this->validate($request, [
            'approved' => ['required', 'bool'],
            'challenge_id' => ['required', 'exists:challenges,id'],
            'reason' => [Rule::requiredIf(!$request->boolean('approved')), 'nullable', 'string'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge_id']);
        if ($request->boolean('approved')) {
            $challenge->update(['approved_at' => now()]);
        } else {
            $challenge->delete();
        }
        return redirect()->back();
    }

    /**
     * Convert a custom challenge into a catalog challenge.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function convert(Request $request)
    {
        $data = $this->validate($request, [
            'challenge_id' => ['required', 'exists:challenges,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge_id']);

        $challenge->quantity = $data['quantity'];
        $challenge->team_id = null;
        $challenge->source = 'Converted';
        $challenge->published_at = now();
        $challenge->save();

        return redirect()->back();
    }
}
