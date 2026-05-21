{{-- Vue : formulaire de connexion --}}
<div class="relative min-h-dvh w-full overflow-hidden">

    <img src="{{ asset('images/santorini.jpg') }}" alt="" aria-hidden="true"
         class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0"
         style="background: linear-gradient(180deg, rgba(10,15,40,0) 0%, rgba(10,15,40,0.15) 40%, rgba(10,15,40,0.92) 100%)">
    </div>

    <div class="relative flex min-h-dvh flex-col px-6 pt-14 pb-10 text-white">

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
            <h1 class="font-display text-3xl font-bold">Bienvenue ✦</h1>
            <p class="mt-2 text-sm text-white/70">Votre voyage vous attend.</p>

            <form wire:submit="login" class="mt-7 space-y-3">

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

                <div>
                    <input
                        wire:model="password"
                        type="password"
                        placeholder="Mot de passe"
                        autocomplete="current-password"
                        class="w-full rounded-2xl border-0 px-4 py-3.5 text-sm placeholder-gray-400 outline-none focus:ring-2 focus:ring-yellow-400/50"
                        style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); color: white;"
                    >
                </div>

                <button
                    type="submit"
                    class="mt-2 flex w-full items-center justify-center rounded-full py-3.5 text-sm font-semibold shadow-card transition-transform active:scale-[0.98]"
                    style="background: var(--gradient-gold); color: var(--navy)"
                >
                    <span wire:loading.remove>Se connecter →</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        Connexion…
                    </span>
                </button>

            </form>

            <p class="mt-5 text-center text-xs text-white/60">
                Pas encore de compte ?
                <a href="{{ route('register') }}" wire:navigate
                   class="font-semibold" style="color: var(--gold)">
                    S'inscrire
                </a>
            </p>
        </div>
    </div>
</div>
