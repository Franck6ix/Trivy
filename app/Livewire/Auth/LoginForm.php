<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Trivy — Se connecter'])]
class LoginForm extends Component
{
    #[Rule('required|string|email')]
    public string $email = '';

    #[Rule('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // addError() ajoute une erreur sur un champ spécifique
            $this->addError('email', 'Ces identifiants ne correspondent à aucun compte.');
            return;
        }

        // Régénère la session pour éviter les attaques de fixation de session
        request()->session()->regenerate();

        // Si l'onboarding n'est pas fait → on y envoie
        $user = Auth::user();
        $redirect = $user->onboarding_completed
            ? route('dashboard')
            : route('onboarding');

        $this->redirect($redirect, navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}
