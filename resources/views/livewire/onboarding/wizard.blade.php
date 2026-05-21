{{--
    Vue : Onboarding Wizard — 10 étapes
    Référence : IdentityScreen → PreferencesScreen dans PhoneScreens.tsx
    Composant PHP : app/Livewire/Onboarding/OnboardingWizard.php
--}}
<div style="height:100dvh; display:flex; flex-direction:column; background:var(--gradient-sand); overflow:hidden;">

    {{-- ── HEADER --}}
    <div style="padding:48px 20px 0; flex-shrink:0; display:flex; align-items:center; justify-content:space-between;">
        @if($step > 1)
            <button wire:click="prevStep"
                    class="grid h-8 w-8 place-items-center rounded-full"
                    style="background: rgba(28,43,74,0.08)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
        @else
            <a href="{{ route('home') }}"
               class="grid h-8 w-8 place-items-center rounded-full"
               style="background: rgba(28,43,74,0.08)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
        @endif

        {{-- Barre de progression --}}
        <div class="flex gap-1">
            @for($i = 1; $i <= $totalSteps; $i++)
                <span class="h-1 w-3 rounded-full transition-all duration-300"
                      style="{{ $i < $step ? 'background: var(--gold-deep)' : ($i === $step ? 'background: var(--gold)' : 'background: rgba(28,43,74,0.15)') }}">
                </span>
            @endfor
        </div>

        {{-- Icône micro --}}
        <button class="grid h-8 w-8 place-items-center rounded-full"
                style="background: rgba(28,43,74,0.08)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">
                <rect width="10" height="16" x="7" y="2" rx="5"/>
                <path d="M19 10v2a7 7 0 0 1-14 0v-2M12 19v3M8 22h8"/>
            </svg>
        </button>
    </div>

    {{-- Générateur d'icônes SVG Lucide (identique à la maquette journey-weaver) --}}
    @php
    $ico = fn(string $p): string => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">'.$p.'</svg>';
    @endphp

    <div wire:key="step-{{ $step }}" class="animate-fadein" style="flex:1; overflow-y:auto; padding:28px 20px 0;">

        {{-- ════ ÉTAPE 1 — Identité ════ --}}
        @if($step === 1)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Qui voyage ?</h2>
            <p class="mt-2 text-xs text-muted">Pour personnaliser votre dashboard.</p>

            <div class="mt-6 space-y-3">
                <div class="rounded-2xl border px-4 py-3" style="background: var(--bg-card)">
                    <p class="text-[10px] uppercase tracking-widest text-muted">Prénom</p>
                    <input wire:model.live="data.name" type="text" placeholder="Ex : Léa"
                           class="mt-1 w-full border-0 bg-transparent font-display text-lg font-semibold text-navy outline-none placeholder:font-normal placeholder:text-gray-400">
                </div>
                @error('data.name')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                <div class="rounded-2xl border px-4 py-3" style="background: var(--bg-card)">
                    <p class="text-[10px] uppercase tracking-widest text-muted">Âge (optionnel)</p>
                    <input wire:model.live="data.age" type="number" placeholder="Ex : 29"
                           class="mt-1 w-full border-0 bg-transparent font-display text-lg font-semibold text-navy outline-none placeholder:font-normal placeholder:text-gray-400">
                </div>
            </div>

        {{-- ════ ÉTAPE 2 — Pourquoi voyager ════ --}}
        @elseif($step === 2)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Vous voyagez…</h2>
            @error('data.travel_type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror

            @php
                $travelTypes = [
                    ['value' => 'solo',     'label' => 'Solo',          'icon' => $ico('<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>')],
                    ['value' => 'couple',   'label' => 'En couple',     'icon' => $ico('<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>')],
                    ['value' => 'famille',  'label' => 'En famille',    'icon' => $ico('<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/>')],
                    ['value' => 'amis',     'label' => 'Entre amis',    'icon' => $ico('<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>')],
                    ['value' => 'affaires', 'label' => 'Pour affaires', 'icon' => $ico('<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/>')],
                    ['value' => 'retraite', 'label' => 'En retraite',   'icon' => $ico('<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"/><path d="M20 2v4"/><path d="M22 4h-4"/><circle cx="4" cy="20" r="2"/>')],
                ];
            @endphp
            <div class="mt-6 grid grid-cols-3 gap-2.5">
                @foreach($travelTypes as $type)
                    <button wire:click="selectChoice('travel_type', '{{ $type['value'] }}')"
                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border p-3 transition"
                            style="{{ $data['travel_type'] === $type['value'] ? 'background: var(--gradient-gold); border-color: transparent; box-shadow: var(--shadow-card)' : 'background: var(--bg-card); border-color: var(--border)' }}">
                        <span class="flex h-5 w-5 items-center justify-center">{!! $type['icon'] !!}</span>
                        <span class="text-[10px] font-medium text-navy leading-tight text-center">{{ $type['label'] }}</span>
                    </button>
                @endforeach
            </div>

        {{-- ════ ÉTAPE 3 — Destination ════ --}}
        @elseif($step === 3)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Où allons‑nous ?</h2>

            {{-- Champ de recherche --}}
            <div class="mt-5 flex items-center gap-2 rounded-2xl border px-3.5 py-3"
                 style="background: var(--bg-card)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted); flex-shrink:0">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <input wire:model.live.debounce.400ms="data.destination"
                       type="text"
                       placeholder="Paris, Tokyo, Maroc…"
                       autocomplete="off"
                       class="flex-1 border-0 bg-transparent text-sm text-navy outline-none placeholder:text-gray-400">
                {{-- Spinner pendant la recherche --}}
                <svg wire:loading wire:target="data.destination"
                     class="h-4 w-4 animate-spin shrink-0" viewBox="0 0 24 24" fill="none"
                     style="color:var(--gold)">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </div>
            @error('data.destination')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror

            {{-- Destination confirmée --}}
            @if(strlen($data['destination']) >= 2 && count($suggestions) === 0)
                <div class="mt-4 flex items-center gap-3 rounded-2xl p-3"
                     style="background:var(--gradient-gold)">
                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl"
                         style="background:rgba(28,43,74,0.15)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" style="color:var(--navy)">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-navy truncate">{{ $data['destination'] }}</p>
                        <p class="text-[11px]" style="color:rgba(28,43,74,0.6)">Destination sélectionnée</p>
                    </div>
                    <button wire:click="selectDestination('')"
                            class="grid h-7 w-7 shrink-0 place-items-center rounded-full"
                            style="background:rgba(28,43,74,0.12)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" style="color:var(--navy)">
                            <path d="M18 6 6 18M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Résultats Nominatim --}}
            @if(count($suggestions) > 0)
                <p class="mt-4 text-[10px] uppercase tracking-widest font-semibold" style="color:var(--gold)">Résultats</p>
                <div class="mt-2 space-y-2">
                    @foreach($suggestions as $s)
                        <button wire:click="selectDestination('{{ addslashes($s['value']) }}')"
                                class="flex w-full items-center gap-3 rounded-2xl border p-3 text-left transition"
                                style="{{ $data['destination'] === $s['value'] ? 'background:var(--gradient-gold);border-color:transparent' : 'background:var(--bg-card);border-color:var(--border)' }}">
                            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl"
                                 style="background:var(--gradient-gold)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--navy)">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-navy">{{ $s['city'] }}</p>
                                <p class="text-[11px] text-muted">{{ $s['country'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>

            {{-- Suggestions par défaut (champ vide) --}}
            @elseif(strlen($data['destination']) < 2)
                <p class="mt-4 text-[10px] uppercase tracking-widest font-semibold" style="color:var(--gold)">Suggestions</p>
                <div class="mt-2 space-y-2">
                    @foreach([['city'=>'Santorin','country'=>'Grèce'],['city'=>'Kyoto','country'=>'Japon'],['city'=>'Marrakech','country'=>'Maroc']] as $dest)
                        <button wire:click="selectDestination('{{ $dest['city'] }}, {{ $dest['country'] }}')"
                                class="flex w-full items-center gap-3 rounded-2xl border p-3 text-left transition"
                                style="background:var(--bg-card);border-color:var(--border)">
                            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl"
                                 style="background:var(--gradient-gold)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--navy)">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-navy">{{ $dest['city'] }}</p>
                                <p class="text-[11px] text-muted">{{ $dest['country'] }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif

        {{-- ════ ÉTAPE 4 — Dates ════ --}}
        @elseif($step === 4)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Quand partez‑vous ?</h2>

            <div class="mt-6 space-y-3">
                <div class="rounded-2xl border px-4 py-3" style="background: var(--bg-card)">
                    <p class="text-[10px] uppercase tracking-widest text-muted">Date de départ</p>
                    <input wire:model.live="data.start_date" type="date"
                           class="mt-1 w-full border-0 bg-transparent font-display text-lg font-semibold text-navy outline-none">
                </div>
                @error('data.start_date')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                <div class="rounded-2xl border px-4 py-3" style="background: var(--bg-card)">
                    <p class="text-[10px] uppercase tracking-widest text-muted">Date de retour</p>
                    <input wire:model.live="data.end_date" type="date"
                           class="mt-1 w-full border-0 bg-transparent font-display text-lg font-semibold text-navy outline-none">
                </div>
                @error('data.end_date')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                @if($data['start_date'] && $data['end_date'])
                    <div class="rounded-2xl border px-4 py-3 text-center" style="background: var(--bg-card)">
                        <p class="text-[10px] uppercase tracking-widest text-muted">Durée du séjour</p>
                        <p class="mt-1 font-display text-lg font-semibold text-navy">
                            {{ \Carbon\Carbon::parse($data['start_date'])->diffInDays($data['end_date']) }} nuits
                        </p>
                    </div>
                @endif
            </div>

        {{-- ════ ÉTAPE 5 — Transport ════ --}}
        @elseif($step === 5)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Comment voyageons‑nous ?</h2>
            @error('data.transport_type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror

            @php
                $transports = [
                    ['value' => 'avion',   'label' => 'En avion',   'icon' => $ico('<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>')],
                    ['value' => 'voiture', 'label' => 'En voiture', 'icon' => $ico('<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>')],
                    ['value' => 'train',   'label' => 'En train',   'icon' => $ico('<path d="M8 3.1V7a4 4 0 0 0 8 0V3.1"/><path d="m9 15-1-1"/><path d="m15 15 1-1"/><path d="M9 19c-2.8 0-5-2.2-5-5v-4a8 8 0 0 1 16 0v4c0 2.8-2.2 5-5 5Z"/><path d="m8 19-2 3"/><path d="m16 19 2 3"/>')],
                    ['value' => 'bateau',  'label' => 'En bateau',  'icon' => $ico('<path d="M12 10.189V14"/><path d="M12 2v3"/><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-8.188-3.639a2 2 0 0 0-1.624 0L3 14a11.6 11.6 0 0 0 2.81 7.76"/><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1s1.2 1 2.5 1c2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>')],
                    ['value' => 'vélo',    'label' => 'À vélo',     'icon' => $ico('<circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>')],
                    ['value' => 'autre',   'label' => 'Autre',      'icon' => $ico('<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"/><path d="M20 2v4"/><path d="M22 4h-4"/><circle cx="4" cy="20" r="2"/>')],
                ];
            @endphp
            <div class="mt-6 grid grid-cols-3 gap-2.5">
                @foreach($transports as $t)
                    <button wire:click="selectChoice('transport_type', '{{ $t['value'] }}')"
                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border p-3 transition"
                            style="{{ $data['transport_type'] === $t['value'] ? 'background: var(--gradient-gold); border-color: transparent; box-shadow: var(--shadow-card)' : 'background: var(--bg-card); border-color: var(--border)' }}">
                        <span class="flex h-5 w-5 items-center justify-center">{!! $t['icon'] !!}</span>
                        <span class="text-[10px] font-medium text-navy leading-tight text-center">{{ $t['label'] }}</span>
                    </button>
                @endforeach
            </div>

        {{-- ════ ÉTAPE 6 — Type de voyage ════ --}}
        @elseif($step === 6)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Type de voyage</h2>
            <p class="mt-1 text-xs text-muted">Plusieurs choix possibles.</p>
            @error('data.trip_types')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror

            @php
                $tripTypes = [
                    ['value' => 'loisirs',   'label' => 'Loisirs',   'icon' => $ico('<path d="M13 8c0-2.76-2.46-5-5.5-5S2 5.24 2 8h2l1-1 1 1h4"/><path d="M13 7.14A5.82 5.82 0 0 1 16.5 6c3.04 0 5.5 2.24 5.5 5h-3l-1-1-1 1h-3"/><path d="M5.89 9.71c-2.15 2.15-2.3 5.47-.35 7.43l4.24-4.25.7-.7.71-.71 2.12-2.12c-1.95-1.96-5.27-1.8-7.42.35"/><path d="M11 15.5c.5 2.5-.17 4.5-1 6.5h4c2-5.5-.5-12-1-14"/>')],
                    ['value' => 'aventure',  'label' => 'Aventure',  'icon' => $ico('<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>')],
                    ['value' => 'culturel',  'label' => 'Culturel',  'icon' => $ico('<path d="M10 18v-7"/><path d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M3 22h18"/><path d="M6 18v-7"/>')],
                    ['value' => 'relax',     'label' => 'Relax',     'icon' => $ico('<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>')],
                    ['value' => 'croisière', 'label' => 'Croisière', 'icon' => $ico('<path d="M12 6v16"/><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"/><path d="M9 11h6"/><circle cx="12" cy="4" r="2"/>')],
                    ['value' => 'retraite',  'label' => 'Retraite',  'icon' => $ico('<path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"/><path d="M7 16v6"/><path d="M13 19v3"/><path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"/>')],
                ];
            @endphp
            <div class="mt-6 grid grid-cols-3 gap-2.5">
                @foreach($tripTypes as $type)
                    <button wire:click="toggleChoice('trip_types', '{{ $type['value'] }}')"
                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border p-3 transition"
                            style="{{ in_array($type['value'], $data['trip_types']) ? 'background: var(--gradient-gold); border-color: transparent; box-shadow: var(--shadow-card)' : 'background: var(--bg-card); border-color: var(--border)' }}">
                        <span class="flex h-5 w-5 items-center justify-center">{!! $type['icon'] !!}</span>
                        <span class="text-[11px] font-medium text-navy">{{ $type['label'] }}</span>
                    </button>
                @endforeach
            </div>

        {{-- ════ ÉTAPE 7 — Voyageurs ════ --}}
        @elseif($step === 7)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Profil des voyageurs</h2>

            <div class="mt-6 space-y-3">
                @foreach([['field'=>'adults','label'=>'Adultes'],['field'=>'children','label'=>'Enfants'],['field'=>'babies','label'=>'Bébés']] as $row)
                    <div class="flex items-center justify-between rounded-2xl border px-4 py-3.5"
                         style="background: var(--bg-card)">
                        <span class="text-sm font-medium text-navy">{{ $row['label'] }}</span>
                        <div class="flex items-center gap-3">
                            <button wire:click="decrement('{{ $row['field'] }}')"
                                    class="grid h-7 w-7 place-items-center rounded-full border text-sm text-navy"
                                    style="border-color: var(--border)">−</button>
                            <span class="w-4 text-center text-sm font-semibold text-navy">
                                {{ $data[$row['field']] }}
                            </span>
                            <button wire:click="increment('{{ $row['field'] }}')"
                                    class="grid h-7 w-7 place-items-center rounded-full text-sm font-semibold"
                                    style="background: var(--gradient-gold); color: var(--navy)">+</button>
                        </div>
                    </div>
                @endforeach

                @if($data['children'] > 0 || $data['babies'] > 0)
                    <div class="rounded-2xl border px-4 py-3" style="background: var(--bg-card)">
                        <p class="text-[10px] uppercase tracking-widest text-muted">Besoins spécifiques</p>
                        <input wire:model.live="data.specific_needs" type="text"
                               placeholder="Ex : siège auto, chaise haute…"
                               class="mt-1 w-full border-0 bg-transparent text-sm text-navy outline-none placeholder:text-gray-400">
                    </div>
                @endif
            </div>

        {{-- ════ ÉTAPE 8 — Logement ════ --}}
        @elseif($step === 8)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Type de logement</h2>
            @error('data.accommodation')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror

            @php
                $lodgings = [
                    ['value' => 'hotel',    'label' => 'Hôtel',    'icon' => $ico('<path d="M10 22v-6.57"/><path d="M12 11h.01"/><path d="M12 7h.01"/><path d="M14 15.43V22"/><path d="M15 16a5 5 0 0 0-6 0"/><path d="M16 11h.01"/><path d="M16 7h.01"/><path d="M8 11h.01"/><path d="M8 7h.01"/><rect x="4" y="2" width="16" height="20" rx="2"/>')],
                    ['value' => 'famille',  'label' => 'Famille',  'icon' => $ico('<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>')],
                    ['value' => 'camping',  'label' => 'Camping',  'icon' => $ico('<path d="M3.5 21 14 3"/><path d="M20.5 21 10 3"/><path d="M15.5 21 12 15l-3.5 6"/><path d="M2 21h20"/>')],
                    ['value' => 'location', 'label' => 'Location', 'icon' => $ico('<path d="M10 12h4"/><path d="M10 8h4"/><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/>')],
                    ['value' => 'gite',     'label' => 'Gîte',     'icon' => $ico('<path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"/><path d="M7 16v6"/><path d="M13 19v3"/><path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"/>')],
                    ['value' => 'autre',    'label' => 'Autre',    'icon' => $ico('<path d="M5 12h14"/><path d="M12 5v14"/>')],
                ];
            @endphp
            <div class="mt-6 grid grid-cols-3 gap-2.5">
                @foreach($lodgings as $l)
                    <button wire:click="selectChoice('accommodation', '{{ $l['value'] }}')"
                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border p-3 transition"
                            style="{{ $data['accommodation'] === $l['value'] ? 'background: var(--gradient-gold); border-color: transparent; box-shadow: var(--shadow-card)' : 'background: var(--bg-card); border-color: var(--border)' }}">
                        <span class="flex h-5 w-5 items-center justify-center">{!! $l['icon'] !!}</span>
                        <span class="text-[11px] font-medium text-navy">{{ $l['label'] }}</span>
                    </button>
                @endforeach
            </div>

        {{-- ════ ÉTAPE 9 — Commodités ════ --}}
        @elseif($step === 9)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Équipements sur place</h2>

            @php
                $amenities = [
                    ['value' => 'lave-linge',    'label' => 'Lave‑linge',    'icon' => $ico('<path d="M3 6h3"/><path d="M17 6h.01"/><rect width="18" height="20" x="3" y="2" rx="2"/><circle cx="12" cy="13" r="5"/><path d="M12 18a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 1 0-5"/>')],
                    ['value' => 'spa',           'label' => 'Spa',           'icon' => $ico('<path d="M10 4 8 6"/><path d="M17 19v2"/><path d="M2 12h20"/><path d="M7 19v2"/><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/>')],
                    ['value' => 'piscine',       'label' => 'Piscine',       'icon' => $ico('<path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.4 2 5 2 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>')],
                    ['value' => 'berceau',       'label' => 'Berceau',       'icon' => $ico('<path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M15 12h.01"/><path d="M19.38 6.813A9 9 0 0 1 20.8 10.2a2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/><path d="M9 12h.01"/>')],
                    ['value' => 'sèche-cheveux', 'label' => 'Sèche‑cheveux', 'icon' => $ico('<path d="M12.8 19.6A2 2 0 1 0 14 16H2"/><path d="M17.5 8a2.5 2.5 0 1 1 2 4H2"/><path d="M9.8 4.4A2 2 0 1 1 11 8H2"/>')],
                    ['value' => 'cuisine',       'label' => 'Cuisine',       'icon' => $ico('<path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"/><path d="M6 17h12"/>')],
                ];
            @endphp
            <div class="mt-6 space-y-2"
                 wire:loading.class="opacity-60 pointer-events-none" wire:target="toggleChoice">
                @foreach($amenities as $a)
                    <button wire:click="toggleChoice('amenities', '{{ $a['value'] }}')"
                            class="flex w-full items-center justify-between rounded-2xl border px-4 py-3.5 text-left transition"
                            style="background: var(--bg-card); border-color: var(--border)">
                        <div class="flex items-center gap-3">
                            <div class="grid h-8 w-8 place-items-center rounded-xl"
                                 style="background: var(--bg-secondary)">
                                {!! $a['icon'] !!}
                            </div>
                            <span class="text-sm font-medium text-navy">{{ $a['label'] }}</span>
                        </div>
                        <span class="relative h-5 w-9 rounded-full transition-colors"
                              style="{{ in_array($a['value'], $data['amenities']) ? 'background: var(--gradient-gold)' : 'background: var(--bg-secondary)' }}">
                            <span class="absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition-all"
                                  style="left: {{ in_array($a['value'], $data['amenities']) ? '18px' : '2px' }}">
                            </span>
                        </span>
                    </button>
                @endforeach
            </div>

        {{-- ════ ÉTAPE 10 — Activités ════ --}}
        @elseif($step === 10)
            <h2 class="font-display text-[26px] font-semibold leading-tight text-navy">Activités préférées</h2>

            @php
                $activities = [
                    ['value' => 'plage',       'label' => 'Plage',       'icon' => $ico('<path d="M13 8c0-2.76-2.46-5-5.5-5S2 5.24 2 8h2l1-1 1 1h4"/><path d="M13 7.14A5.82 5.82 0 0 1 16.5 6c3.04 0 5.5 2.24 5.5 5h-3l-1-1-1 1h-3"/><path d="M5.89 9.71c-2.15 2.15-2.3 5.47-.35 7.43l4.24-4.25.7-.7.71-.71 2.12-2.12c-1.95-1.96-5.27-1.8-7.42.35"/><path d="M11 15.5c.5 2.5-.17 4.5-1 6.5h4c2-5.5-.5-12-1-14"/>')],
                    ['value' => 'rando',       'label' => 'Rando',       'icon' => $ico('<path d="m8 3 4 8 5-5 5 15H2L8 3z"/>')],
                    ['value' => 'gastronomie', 'label' => 'Gastronomie', 'icon' => $ico('<path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/>')],
                    ['value' => 'ski',         'label' => 'Ski',         'icon' => $ico('<path d="m10 20-1.25-2.5L6 18"/><path d="M10 4 8.75 6.5 6 6"/><path d="m14 20 1.25-2.5L18 18"/><path d="m14 4 1.25 2.5L18 6"/><path d="m17 21-3-6h-4"/><path d="m17 3-3 6 1.5 3"/><path d="M2 12h6.5L10 9"/><path d="m20 10-1.5 2 1.5 2"/><path d="M22 12h-6.5L14 15"/><path d="m4 10 1.5 2L4 14"/><path d="m7 21 3-6-1.5-3"/><path d="m7 3 3 6h4"/>')],
                    ['value' => 'kayak',       'label' => 'Kayak',       'icon' => $ico('<path d="M12 6v16"/><path d="m19 13 2-1a9 9 0 0 1-18 0l2 1"/><path d="M9 11h6"/><circle cx="12" cy="4" r="2"/>')],
                    ['value' => 'bien-être',   'label' => 'Bien‑être',   'icon' => $ico('<path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/>')],
                ];
            @endphp
            <div class="mt-6 grid grid-cols-3 gap-2.5"
                 wire:loading.class="opacity-60 pointer-events-none" wire:target="toggleChoice">
                @foreach($activities as $a)
                    <button wire:click="toggleChoice('activities', '{{ $a['value'] }}')"
                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border p-3 transition-all duration-150"
                            style="{{ in_array($a['value'], $data['activities']) ? 'background: var(--gradient-gold); border-color: transparent; box-shadow: var(--shadow-card)' : 'background: var(--bg-card); border-color: var(--border)' }}">
                        <span class="flex h-5 w-5 items-center justify-center">{!! $a['icon'] !!}</span>
                        <span class="text-[11px] font-medium text-navy">{{ $a['label'] }}</span>
                    </button>
                @endforeach
            </div>
        @endif

    </div>

    {{-- ── FOOTER : toujours visible en bas --}}
    <div style="flex-shrink:0; padding:12px 20px 28px; background:var(--gradient-sand);">
        <button wire:click="nextStep"
                class="flex w-full items-center justify-center rounded-full py-3.5 text-sm font-semibold shadow-card transition-transform active:scale-[0.98]"
                style="background: var(--gradient-gold); color: var(--navy)">
            <span wire:loading.remove wire:target="nextStep">
                {{ $step === $totalSteps ? 'Générer mon voyage ✦' : 'Suivant →' }}
            </span>
            <span wire:loading wire:target="nextStep" class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Chargement…
            </span>
        </button>

        {{-- FAB vocal --}}
        <div class="mt-4 flex justify-center">
            <button class="grid h-14 w-14 place-items-center rounded-full shadow-card"
                    style="background: var(--gradient-gold)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color: var(--navy)">
                    <rect width="10" height="16" x="7" y="2" rx="5"/>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2M12 19v3M8 22h8"/>
                </svg>
            </button>
        </div>
    </div>

</div>
