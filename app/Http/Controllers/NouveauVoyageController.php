<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class NouveauVoyageController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        auth()->user()->update(['onboarding_completed' => false]);

        return redirect()->route('onboarding');
    }
}
