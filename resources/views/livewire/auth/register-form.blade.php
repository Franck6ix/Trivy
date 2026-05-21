{{-- Vue : formulaire d'inscription --}}
<div class="relative min-h-dvh w-full overflow-hidden"
     x-data="{ ready: false }"
     x-init="setTimeout(() => ready = true, 100)">

    {{-- Fond photo + overlay (même que la splash) --}}
    <img src="{{ asset('images/santorini.jpg') }}" alt="" aria-hidden="true"
         class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0"
         style="background: linear-gradient(180deg, rgba(10,15,40,0) 0%, rgba(10,15,40,0.15) 40%, rgba(10,15,40,0.92) 100%)">
    </div>

    <div class="relative flex min-h-dvh flex-col px-6 pt-14 pb-10 text-white">

        {{-- Bouton retour vers la splash --}}
        <a href="{{ route('home') }}"
           class="absolute left-5 top-14 grid h-8 w-8 place-items-center rounded-full"
           style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </a>

        {{-- Logo --}}
        <div class="flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" style="color: var(--gold)">
                <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8 2.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 7.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
            </svg>
            <span class="font-display text-sm font-semibold tracking-brand">TRIVY</span>
        </div>

        <div class="mt-auto">
            <h1 class="font-display text-3xl font-bold">Créer mon compte</h1>
            <p class="mt-2 text-sm text-white/70">Votre aventure commence ici.</p>

            {{-- Formulaire Livewire --}}
            {{--
                wire:submit = appelle la méthode register() du composant PHP
                sans rechargement de page.
            --}}
            {{-- <form wire:submit="registe" class="mt-7 space-y-3"> --}}
 <form action="{{ route('register') }}" method="POST" class="mt-7 space-y-3">
                {{-- Prénom --}}
                <div>
                    <input
                        wire:model.live="name"
                        type="text"
                        placeholder="Votre prénom"
                        autocomplete="name"
                        class="w-full rounded-2xl border-0 px-4 py-3.5 text-sm text-navy placeholder-gray-400 outline-none ring-0 focus:ring-2 focus:ring-yellow-400/50"
                        style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white;"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <input
                        wire:model.live="email"
                        type="email"
                        placeholder="Votre email"
                        autocomplete="email"
                        class="w-full rounded-2xl border-0 px-4 py-3.5 text-sm placeholder-gray-400 outline-none focus:ring-2 focus:ring-yellow-400/50"
                        style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white;"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <input
                        wire:model.live="password"
                        type="password"
                        placeholder="Mot de passe (8 caractères min.)"
                        autocomplete="new-password"
                        class="w-full rounded-2xl border-0 px-4 py-3.5 text-sm placeholder-gray-400 outline-none focus:ring-2 focus:ring-yellow-400/50"
                        style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white;"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmation --}}
                <div>
                    <input
                        wire:model.live="password_confirmation"
                        type="password"
                        placeholder="Confirmer le mot de passe"
                        autocomplete="new-password"
                        class="w-full rounded-2xl border-0 px-4 py-3.5 text-sm placeholder-gray-400 outline-none focus:ring-2 focus:ring-yellow-400/50"
                        style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white;"
                    >
                </div>

                {{-- Bouton submit --}}
                {{--
                    wire:loading = classe ajoutée PENDANT la requête Livewire.
                    Donne un retour visuel à l'utilisateur que ça charge.
                --}}
                <button
                    type="submit"
                    class="mt-2 flex w-full items-center justify-center rounded-full py-3.5 text-sm font-semibold shadow-card transition-transform active:scale-[0.98]"
                    style="background: var(--gradient-gold); color: var(--navy)"
                >
                    <span wire:loading.remove>S'inscrire →</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        Création…
                    </span>
                </button>

            </form>

            <p class="mt-5 text-center text-xs text-white/60">
                Déjà un compte ?
                <a href="{{ route('login') }}" wire:navigate
                   class="font-semibold" style="color: var(--gold)">
                    Se connecter
                </a>
            </p>
        </div>
    </div>
</div>
