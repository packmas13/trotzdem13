<?php

namespace App\Http\Controllers\Orga;

use App\Exports\TeamExport;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeamExportController extends Controller
{
    public function ods(Request $request)
    {
        $teams = Team::whereNotNull('approved_at')
            ->select([
                'id',
                'name',
                'troop_id',
                'banner_id',
                'size',
                'contact_phone',
                'contact_email',
                'contact_name',
                'contact_street',
                'contact_zip',
                'contact_city',
            ])
            ->get()
            ->load('banner', 'troop')
            ->map(function ($t) {
                $t = $t->toArray();
                $t['banner'] = $t['banner']['name'];
                $t['troop'] = $t['troop']['name'];
                return $t;
            })
            ->toArray();

        $export = new TeamExport($teams);

        return Excel::download($export, "trotzdem13-teams.ods");
    }
}
