<?php

namespace App\Http\Controllers;

use App\Models\Annuncio;
use App\Models\BrandLogo;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function homepage()
    {
        return view('welcome', [
            'slides'   => HeroSlide::orderBy('posizione')->get(),
            'evidenza' => Annuncio::perHome(),
            'loghi'    => BrandLogo::orderBy('ordine')->orderBy('id')->get(),
        ]);
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

    public function gallery()
{
    return view('gallery');
}
}