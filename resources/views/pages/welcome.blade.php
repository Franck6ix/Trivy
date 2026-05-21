{{--
    PAGE : Splash / Welcome — Phase 0
    Référence : WelcomeScreen() dans journey-weaver/src/components/PhoneScreens.tsx
    Layout : layouts/app.blade.php (mobile-shell)

    Structure :
    ┌─────────────────────┐
    │  Photo plein écran  │  ← image Santorini avec overlay gradient
    │  (blur + fade)      │
    │                     │
    │  Logo TRIVY         │  ← en haut, centré
    │                     │
    │  ✦  Bonjour.        │  ← titre serif italique doré
    │  Créez votre compte │  ← sous-titre
    │                     │
    │  [S'inscrire]       │  ← bouton gradient gold
    │  [Apple][Google][✉] │  ← 3 boutons auth sociaux
    │  Déjà inscrit ?     │  ← lien connexion
    └─────────────────────┘
--}}

<x-layouts.app title="Trivy — Bienvenue">

    {{--
        Conteneur plein écran relatif.
        Tout est positionné en absolute par-dessus la photo.
    --}}
    <div class="relative min-h-dvh w-full overflow-hidden"
         x-data="{ ready: false }"
         x-init="setTimeout(() => ready = true, 100)">

        {{-- ── FOND : photo Santorini plein écran ── --}}
        <img
            src="{{ asset('images/santorini.jpg') }}"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 h-full w-full object-cover"
        >

        {{--
            Overlay gradient :
            - transparent en haut (la photo respire)
            - navy foncé en bas (pour lire le texte)
            Identique au prototype : rgba(10,15,40,0) → rgba(10,15,40,0.85)
        --}}
        <div
            class="absolute inset-0"
            style="background: linear-gradient(180deg, rgba(10,15,40,0) 0%, rgba(10,15,40,0.15) 40%, rgba(10,15,40,0.88) 100%)"
        ></div>

        {{-- ── CONTENU par-dessus la photo ── --}}
        <div class="relative flex min-h-dvh flex-col px-6 pt-14 pb-10 text-white">

            {{-- Logo TRIVY en haut centré --}}
            <div class="flex items-center justify-center gap-2"
                 :class="ready ? 'animate-fadein' : 'opacity-0'"
                 style="animation-delay: 0.1s">
                {{-- Icône avion SVG inline (lucide Plane) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="text-gold" style="color: var(--gold)">
                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8 2.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 7.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
                </svg>
                <span class="font-display text-sm font-semibold tracking-brand">TRIVY</span>
            </div>

            {{-- Espace flexible : pousse le contenu vers le bas --}}
            <div class="mt-auto">

                {{-- Icône sparkles --}}
                <div :class="ready ? 'animate-fadein' : 'opacity-0'"
                     style="animation-delay: 0.2s">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="mb-3" style="color: var(--gold)">
                        <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>
                    </svg>
                </div>

                {{--
                    Titre principal : "Bonjour."
                    Instrument Serif italique, grand, couleur or.
                    Reproduit exactement le prototype React.
                --}}
                <h1 class="font-serif italic leading-none tracking-tight"
                    style="font-size: 64px; color: var(--gold)"
                    :class="ready ? 'animate-fadein' : 'opacity-0'"
                    style2="animation-delay: 0.3s">
                    Bonjour<span class="text-white/90">.</span>
                </h1>

                {{-- Sous-titre --}}
                <p class="mt-4 max-w-[260px] text-sm leading-relaxed text-white/80"
                   :class="ready ? 'animate-fadein' : 'opacity-0'"
                   style="animation-delay: 0.35s">
                    Créez votre compte. Votre prochain voyage commence en un seul geste.
                </p>

                {{-- ── BOUTONS ── --}}
                <div class="mt-7 space-y-3"
                     :class="ready ? 'animate-fadein' : 'opacity-0'"
                     style="animation-delay: 0.45s">

                    {{--
                        Bouton principal : S'inscrire
                        Gradient gold, rounded-full, ombre légère.
                    --}}
                    <a href="{{ route('register') }}"
                       class="flex w-full items-center justify-center rounded-full py-3.5 text-sm font-semibold shadow-card transition-transform active:scale-[0.98]"
                       style="background: var(--gradient-gold); color: var(--navy)">
                        S'inscrire
                    </a>

                    {{-- 3 boutons auth sociaux --}}
                    <div class="grid grid-cols-3 gap-2">

                        {{-- Apple --}}
                        <a href="#"
                           class="flex items-center justify-center gap-1.5 rounded-full bg-black py-2.5 text-[11px] font-medium text-white transition-transform active:scale-[0.97]">
                            {{-- Logo Apple SVG --}}
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                <path d="M16.365 1.43c0 1.14-.42 2.22-1.26 3.06-.84.84-1.92 1.32-2.94 1.26-.06-1.08.42-2.22 1.26-3.06.84-.84 2.04-1.32 2.94-1.26zm3.51 16.86c-.6 1.32-1.32 2.52-2.34 3.66-1.02 1.14-2.16 1.92-3.42 1.92-1.2 0-1.62-.72-3.06-.72s-1.92.72-3.06.72c-1.32 0-2.4-.96-3.42-2.16-2.16-2.46-3.84-7.02-1.62-10.08 1.08-1.5 2.94-2.46 4.92-2.52 1.26 0 2.46.84 3.18.84.72 0 2.22-1.02 3.78-.84.66.06 2.46.24 3.66 1.86-3.18 1.74-2.7 6.18.38 7.32z"/>
                            </svg>
                            Apple
                        </a>

                        {{-- Google --}}
                        <a href="#"
                           class="flex items-center justify-center gap-1.5 rounded-full bg-white py-2.5 text-[11px] font-medium transition-transform active:scale-[0.97]"
                           style="color: #1f1f1f">
                            {{-- Logo Google SVG --}}
                            <svg viewBox="0 0 48 48" class="h-4 w-4" aria-hidden="true">
                                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3c-1.6 4.7-6.1 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
                                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 16 18.9 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.4 6.3 14.7z"/>
                                <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.3 35 26.8 36 24 36c-5.2 0-9.6-3.3-11.2-8l-6.5 5C9.6 39.6 16.2 44 24 44z"/>
                                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.3-4.1 5.6l6.2 5.2c-.4.4 6.6-4.8 6.6-14.8 0-1.3-.1-2.3-.4-3.5z"/>
                            </svg>
                            Google
                        </a>

                        {{-- Email --}}
                        <a href="{{ route('register') }}"
                           class="flex items-center justify-center gap-1.5 rounded-full py-2.5 text-[11px] font-medium text-white backdrop-blur transition-transform active:scale-[0.97]"
                           style="background: rgba(255,255,255,0.15)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            Email
                        </a>
                    </div>

                    {{-- Lien connexion --}}
                    <p class="pt-1 text-center text-[10px] text-white/60">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}"
                           class="font-semibold"
                           style="color: var(--gold)">
                            Se connecter
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
