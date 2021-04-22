<?php

namespace App\Http\Controllers\Orga;

use App\Http\Controllers\Controller;
use App\Models\Handover;
use Illuminate\Http\Request;

class HandoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
            'banner_id' => ['required', 'exists:banners,id'],
            'received_at' => ['required', 'date'],
            'variant' => ['required','integer', 'min:1'],
        ]);
        return Handover::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Handover  $handover
     * @return \Illuminate\Http\Response
     */
    public function show(Handover $handover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Handover  $handover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Handover $handover)
    {
        $data = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
            'banner_id' => ['required', 'exists:banners,id'],
            'received_at' => ['required', 'date'],
            'variant' => ['required','integer', 'min:1'],
        ]);
        $handover->update($data);
        return $handover;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Handover  $handover
     * @return \Illuminate\Http\Response
     */
    public function destroy(Handover $handover)
    {
        //
    }
}
