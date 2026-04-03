<?php

namespace App\Http\Controllers;

use App\Models\AnnuncioImmagine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnuncioImmagineController extends Controller
{
    public function destroy(AnnuncioImmagine $immagine)
    {
        Storage::disk('public')->delete($immagine->path);
        $immagine->delete();

        return back()->with('success', 'Immagine eliminata.');
    }
}
