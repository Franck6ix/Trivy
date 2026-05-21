<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProfilController extends Controller
{
    public function __invoke(): View
    {
        $trip = auth()->user()->trips()->latest()->first();

        return view('pages.profil', compact('trip'));
    }
}
