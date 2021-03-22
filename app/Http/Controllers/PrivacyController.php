<?php

namespace App\Http\Controllers;

class PrivacyController
{
    public function index()
    {
        return view('privacy');
    }
    public function leader()
    {
        return view('privacy.leader');
    }
}
