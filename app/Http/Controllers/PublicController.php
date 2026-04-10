<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function homepage()
    {
        return view('welcome');
    }

    public function chiSiamo()
{
    return view('chi-siamo');
}

    public function contact()
{
    return view('contact');
}

    public function dashboard()
    {
        return redirect()->route('profile.edit');
    }
}