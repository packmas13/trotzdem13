<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeamUsersEmailsController extends Controller
{
    public function index(Request $request)
    {
        $emails = User::whereHas('teams', function (Builder $query) {
            $query->whereNotNull('approved_at');
        })->pluck('email');

        return response($emails->join(",\r\n"))->header('Content-Type', 'text/plain');
    }
}
