<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $trip = auth()->user()->trips()->latest()->first();

        $dest = strtolower($trip->destination ?? '');
        $heroImage = 'paris.jpg';
        foreach ([
            'santorini' => 'santorini.jpg',
            'grèce'     => 'santorini.jpg',
            'greece'    => 'santorini.jpg',
            'paris'     => 'paris.jpg',
        ] as $keyword => $file) {
            if (str_contains($dest, $keyword)) {
                $heroImage = $file;
                break;
            }
        }

        $lat = 48.8566;
        $lng = 2.3522;
        if ($trip) {
            try {
                $geo = Http::withHeaders(['User-Agent' => 'Trivy-App/1.0'])
                    ->timeout(3)
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q' => $trip->destination, 'format' => 'json', 'limit' => 1,
                    ])->json();
                if (! empty($geo)) {
                    $lat = (float) $geo[0]['lat'];
                    $lng = (float) $geo[0]['lon'];
                }
            } catch (\Exception) {}
        }

        return view('pages.dashboard', compact('trip', 'heroImage', 'lat', 'lng'));
    }
}
