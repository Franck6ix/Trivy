<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class GeneratingController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.ai-generation');
    }
}
