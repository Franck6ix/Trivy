<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class RegisterController extends Controller
{
     #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|string|email|max:255|unique:users')]
    public string $email = '';

    #[Rule('required|string|min:8|confirmed')]
    public string $password = '';

    #[Rule('required|string')]
    public string $password_confirmation = '';


    public function register(): void
    {
        // dd('register');
        // $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // $this->redirect(route('onboarding'), navigate: false);
    }

}
