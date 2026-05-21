<?php

namespace App\Livewire\Assistant;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

/*
 * DEVBOOK — Assistant IA Trivy
 *
 * Chat en temps réel avec Claude (Haiku — rapide et économique).
 * Le système prompt ancre l'IA dans le contexte du voyage courant.
 * On conserve les 10 derniers messages pour ne pas exploser les tokens.
 */
class Chat extends Component
{
    public array $messages  = [];
    public string $input    = '';
    public bool $thinking   = false;

    public function mount(): void
    {
        $user = auth()->user();
        $trip = $user->trips()->latest()->first();

        $greeting = 'Bonjour ' . $user->name . ' !';
        if ($trip) {
            $greeting .= ' Je vois que vous partez à **' . $trip->destination . '**.'
                       . ' Que puis-je faire pour vous — valise, météo, activités, restos ?';
        } else {
            $greeting .= ' Planifiez votre prochain voyage et je vous accompagnerai à chaque étape.';
        }

        $this->messages[] = ['from' => 'ai', 'text' => $greeting];
    }

    public function sendMessage(): void
    {
        $text = trim($this->input);
        if ($text === '') return;

        $this->messages[] = ['from' => 'user', 'text' => $text];
        $this->input      = '';
        $this->thinking   = true;

        $this->js("setTimeout(() => \$wire.callClaude(), 50)");
    }

    public function callClaude(): void
    {
        $user = auth()->user();
        $trip = $user->trips()->latest()->first();

        // Contexte voyage pour le prompt système
        $tripContext = '';
        if ($trip) {
            $tripContext = "\nVoyage en cours : destination={$trip->destination}"
                . ", transport={$trip->transport_type}"
                . ", hébergement={$trip->accommodation}"
                . ", du {$trip->start_date} au {$trip->end_date}.";
        }

        $systemPrompt = "Tu es l'assistant IA de Trivy, une application mobile de voyage intelligente. "
            . "Tu réponds uniquement en français, de façon concise (3 phrases max). "
            . "Tu aides l'utilisateur à gérer sa valise, trouver des activités, anticiper la météo, et planifier son séjour.{$tripContext} "
            . "Ton ton est chaleureux, expert, proactif. Tu tututoies l'utilisateur.";

        // Garder les 10 derniers messages (5 échanges) pour le contexte
        $history = collect($this->messages)
            ->takeLast(10)
            ->filter(fn($m) => in_array($m['from'], ['user', 'ai']))
            ->map(fn($m) => [
                'role'    => $m['from'] === 'user' ? 'user' : 'assistant',
                'content' => $m['text'],
            ])
            ->values()
            ->toArray();

        try {
            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.api_key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->timeout(20)->post('https://api.anthropic.com/v1/messages', [
                'model'      => config('services.anthropic.model'),
                'max_tokens' => 300,
                'system'     => $systemPrompt,
                'messages'   => $history,
            ]);

            $aiText = $response->json('content.0.text')
                ?? 'Désolé, je rencontre un problème technique. Réessaie dans un instant.';
        } catch (\Exception) {
            $aiText = 'Je ne suis pas disponible pour le moment. Vérifie ta connexion internet.';
        }

        $this->messages[] = ['from' => 'ai', 'text' => $aiText];
        $this->thinking   = false;
    }

    public function render()
    {
        return view('livewire.assistant.chat')
            ->layout('components.layouts.app', ['title' => 'Trivy — Assistant']);
    }
}
