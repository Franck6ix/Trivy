<?php

namespace App\Livewire\Onboarding;

use App\Actions\CreateTripFromOnboardingAction;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/*
 * DEVBOOK — Pattern Livewire Multi-step Wizard
 *
 * Ce composant gère les 10 étapes d'onboarding.
 *
 * Principe :
 * - $step (1→10) : l'étape courante
 * - $data : tableau qui accumule toutes les réponses
 * - nextStep() : valide l'étape courante PUIS avance
 * - prevStep() : revient en arrière sans validation
 * - finish() : appelle l'Action qui crée le voyage en BDD
 *
 * Pourquoi un seul composant pour 10 étapes ?
 * → $data persiste en mémoire Livewire entre les étapes.
 *   Si on avait 10 composants séparés, on devrait passer les données
 *   via la session ou l'URL — plus complexe.
 */
class OnboardingWizard extends Component
{
    public int $step = 1;
    public int $totalSteps = 10;
    public array $suggestions = [];

    // Toutes les données collectées lors de l'onboarding
    public array $data = [
        // Étape 1 — Identité
        'name'             => '',
        'age'              => '',

        // Étape 2 — Pourquoi voyager
        'travel_type'      => '',   // solo|couple|famille|amis|affaires

        // Étape 3 — Destination
        'destination'      => '',

        // Étape 4 — Dates
        'start_date'       => '',
        'end_date'         => '',

        // Étape 5 — Transport
        'transport_type'   => '',   // avion|voiture|train|bateau|vélo|autre

        // Étape 6 — Type de voyage
        'trip_types'       => [],   // tableau multi-choix

        // Étape 7 — Voyageurs
        'adults'           => 1,
        'children'         => 0,
        'babies'           => 0,
        'specific_needs'   => '',

        // Étape 8 — Logement
        'accommodation'    => '',   // hotel|famille|camping|location|gite

        // Étape 9 — Commodités
        'amenities'        => [],   // tableau multi-choix

        // Étape 10 — Préférences / activités
        'activities'       => [],   // tableau multi-choix
    ];

    // Règles de validation par étape
    // Seules les règles de l'étape courante sont vérifiées
    protected function rulesForStep(): array
    {
        return match ($this->step) {
            1  => ['data.name' => 'required|string|max:100'],
            2  => ['data.travel_type' => 'required|string'],
            3  => ['data.destination' => 'required|string|max:255'],
            4  => ['data.start_date' => 'required|date', 'data.end_date' => 'required|date|after:data.start_date'],
            5  => ['data.transport_type' => 'required|string'],
            6  => ['data.trip_types' => 'required|array|min:1'],
            7  => ['data.adults' => 'required|integer|min:1'],
            8  => ['data.accommodation' => 'required|string'],
            9  => [],   // Commodités : optionnel
            10 => [],   // Préférences : optionnel
            default => [],
        };
    }

    // Avancer d'une étape après validation
    public function nextStep(): void
    {
        $rules = $this->rulesForStep();

        if (! empty($rules)) {
            $this->validate($rules);
        }

        if ($this->step < $this->totalSteps) {
            $this->step++;
        } else {
            $this->finish();
        }
    }

    // Reculer sans validation
    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    // Sélectionner/désélectionner un choix dans un tableau multi-choix
    public function toggleChoice(string $field, string $value): void
    {
        $current = $this->data[$field] ?? [];

        if (in_array($value, $current)) {
            $this->data[$field] = array_values(array_filter($current, fn($v) => $v !== $value));
        } else {
            $this->data[$field][] = $value;
        }
    }

    // Recherche de destination via Nominatim (OpenStreetMap)
    public function updatedDataDestination(string $value): void
    {
        $this->suggestions = [];

        if (strlen(trim($value)) < 2) {
            return;
        }

        try {
            $results = Http::withHeaders([
                'User-Agent'      => 'Trivy-App/1.0',
                'Accept-Language' => 'fr',
            ])->timeout(5)->get('https://nominatim.openstreetmap.org/search', [
                'q'            => $value,
                'format'       => 'json',
                'limit'        => 6,
                'addressdetails' => 1,
            ])->json();

            $this->suggestions = collect($results)
                ->filter(fn($r) => in_array($r['class'] ?? '', ['place', 'boundary']))
                ->take(5)
                ->map(fn($r) => [
                    'city'    => $r['address']['city']
                              ?? $r['address']['town']
                              ?? $r['address']['village']
                              ?? $r['address']['county']
                              ?? $r['name'],
                    'country' => $r['address']['country'] ?? '',
                    'value'   => ($r['address']['city']
                              ?? $r['address']['town']
                              ?? $r['address']['village']
                              ?? $r['name'])
                              . (isset($r['address']['country']) ? ', ' . $r['address']['country'] : ''),
                ])
                ->unique('value')
                ->values()
                ->toArray();
        } catch (\Exception) {
            // Réseau indisponible — on garde le champ texte libre
        }
    }

    // Sélectionner une destination depuis les suggestions
    public function selectDestination(string $value): void
    {
        $this->data['destination'] = $value;
        $this->suggestions = [];
    }

    // Sélection unique (radio-like)
    public function selectChoice(string $field, string $value): void
    {
        $this->data[$field] = $value;
    }

    // Modifier un compteur (adultes, enfants, bébés)
    public function increment(string $field): void
    {
        $this->data[$field] = ($this->data[$field] ?? 0) + 1;
    }

    public function decrement(string $field): void
    {
        $this->data[$field] = max(0, ($this->data[$field] ?? 0) - 1);
    }

    // Étape finale : créer le voyage et rediriger
    private function finish(): void
    {
        $action = new CreateTripFromOnboardingAction();
        $action->execute(auth()->user(), $this->data);

        $this->redirect(route('ai-generation'), navigate: false);
    }

    public function render()
    {
        return view('livewire.onboarding.wizard')
            ->layout('components.layouts.app', ['title' => 'Trivy — Onboarding']);
    }
}
