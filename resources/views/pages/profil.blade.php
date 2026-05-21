<x-layouts.app title="Trivy — Profil">
@php
$user = auth()->user();

$ico = fn(string $path, int $size = 16): string =>
    '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';

$travelTypeLabel = match($user->travel_type ?? '') {
    'solo'     => 'Voyageur solo',
    'couple'   => 'En couple',
    'famille'  => 'En famille',
    'amis'     => 'Entre amis',
    'affaires' => 'Voyages d\'affaires',
    'retraite' => 'En retraite',
    default    => 'Non renseigné',
};

$transportLabel = match($trip->transport_type ?? '') {
    'avion'   => 'Avion',
    'voiture' => 'Voiture',
    'train'   => 'Train',
    'bateau'  => 'Bateau',
    'vélo'    => 'Vélo',
    default   => 'Non renseigné',
};

$rows = [
    ['panel' => 'info',     'icon' => '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/>',        'label' => 'Informations personnelles'],
    ['panel' => 'payment',  'icon' => '<rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/>',   'label' => 'Moyens de paiement'],
    ['panel' => 'prefs',    'icon' => '<path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/>',  'label' => 'Préférences'],
    ['panel' => 'notifs',   'icon' => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',  'label' => 'Notifications'],
    ['panel' => 'privacy',  'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',                'label' => 'Confidentialité & sécurité'],
    ['panel' => 'help',     'icon' => '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>',  'label' => 'Aide & support'],
    ['panel' => 'about',    'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>',           'label' => 'À propos de Trivy'],
];

$activities = is_array($user->preferences) ? $user->preferences : (json_decode($user->preferences ?? '[]', true) ?: []);
@endphp

<div x-data="{
    panel: null,
    notif_depart: true,
    notif_meteo: true,
    notif_ia: true,
    notif_news: false,
    faq: null
}" style="height:100dvh; display:flex; flex-direction:column; background:var(--gradient-sand); overflow:hidden; position:relative;">

    {{-- ── HEADER ACTIONS ── --}}
    <div style="flex-shrink:0; padding:48px 20px 0; display:flex; align-items:center; justify-content:space-between;">
        <a href="{{ route('dashboard') }}"
           style="width:32px; height:32px; border-radius:50%; background:var(--bg-card); display:grid; place-items:center; text-decoration:none; color:var(--navy); border:1px solid var(--border);">
            {!! $ico('<path d="M15 18l-6-6 6-6"/>') !!}
        </a>
        {{-- Bouton paramètres → ouvre Informations personnelles --}}
        <button @click="panel = 'info'"
                style="width:32px; height:32px; border-radius:50%; background:var(--bg-card); border:1px solid var(--border); display:grid; place-items:center; color:var(--navy); cursor:pointer;">
            {!! $ico('<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>') !!}
        </button>
    </div>

    {{-- ── AVATAR + NOM ── --}}
    <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:center; padding:16px 24px 0;">
        <div style="position:relative; display:inline-block;">
            <img src="{{ asset('images/avatar-lea.jpg') }}" alt="{{ $user->name }}"
                 style="width:80px; height:80px; border-radius:50%; object-fit:cover; box-shadow:var(--shadow-card); border:3px solid var(--bg-card);">
            <span style="position:absolute; bottom:0; right:0; width:22px; height:22px; border-radius:50%; background:var(--gradient-gold); border:2px solid var(--bg-card); display:grid; place-items:center; color:var(--navy);">
                {!! $ico('<path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>', 10) !!}
            </span>
        </div>
        <h2 style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:600; color:var(--navy); margin-top:10px;">{{ $user->name }}</h2>
        <p style="font-size:11px; color:var(--text-muted); margin-top:2px;">{{ $user->email }}</p>
        <span style="margin-top:10px; display:inline-flex; align-items:center; gap:6px; background:var(--gradient-gold); border-radius:99px; padding:5px 14px; font-size:10px; font-weight:600; color:var(--navy); box-shadow:var(--shadow-card);">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
            </svg>
            Membre Premium
        </span>
    </div>

    {{-- ── LISTE PARAMÈTRES (scrollable) ── --}}
    <div style="flex:1; overflow-y:auto; padding:16px 16px 0;">
        <div style="display:flex; flex-direction:column; gap:6px;">
            @foreach($rows as $row)
                <button @click="panel = '{{ $row['panel'] }}'"
                        style="display:flex; align-items:center; gap:12px; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:12px 14px; text-align:left; width:100%; cursor:pointer;">
                    <div style="width:32px; height:32px; border-radius:10px; background:var(--bg-cream); display:grid; place-items:center; flex-shrink:0; color:var(--navy);">
                        {!! $ico($row['icon']) !!}
                    </div>
                    <span style="flex:1; font-size:13px; font-weight:500; color:var(--navy);">{{ $row['label'] }}</span>
                    {!! $ico('<path d="M9 18l6-6-6-6"/>', 14) !!}
                </button>
            @endforeach

            {{-- Déconnexion --}}
            <form method="POST" action="{{ route('logout') }}" style="margin-top:4px;">
                @csrf
                <button type="submit"
                        style="display:flex; align-items:center; gap:12px; background:var(--bg-card); border:1px solid #fecaca; border-radius:16px; padding:12px 14px; text-align:left; width:100%; cursor:pointer;">
                    <div style="width:32px; height:32px; border-radius:10px; background:#fff5f5; display:grid; place-items:center; flex-shrink:0; color:#ef4444;">
                        {!! $ico('<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>') !!}
                    </div>
                    <span style="flex:1; font-size:13px; font-weight:500; color:#ef4444;">Se déconnecter</span>
                </button>
            </form>
        </div>
        <div style="height:16px;"></div>
    </div>

    {{-- ── NAV BAR ── --}}
    <div style="flex-shrink:0; background:rgba(254,254,254,0.96); backdrop-filter:blur(12px); border-top:1px solid var(--border); padding:8px 24px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <a href="{{ route('dashboard') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Home</span>
            </a>
            <a href="{{ route('valise') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    <line x1="12" x2="12" y1="12" y2="12"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Valise</span>
            </a>
            <a href="{{ route('assistant') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                    <path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Assistant</span>
            </a>
            <a href="{{ route('profil') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                    <circle cx="12" cy="8" r="5"/>
                    <path d="M20 21a8 8 0 1 0-16 0"/>
                </svg>
                <span style="font-size:10px; font-weight:600; color:var(--navy);">Profil</span>
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- OVERLAY --}}
    <div x-show="panel !== null"
         @click="panel = null"
         style="position:absolute; inset:0; background:rgba(10,15,40,0.45); z-index:30; backdrop-filter:blur(2px);"
         x-transition:enter="transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         x-cloak></div>

    {{-- DRAWER --}}
    <div :style="{ transform: panel !== null ? 'translateY(0)' : 'translateY(105%)' }"
         style="position:absolute; bottom:0; left:0; right:0; max-height:82dvh; background:var(--bg-card); border-radius:20px 20px 0 0; z-index:40; overflow-y:auto; transition:transform 0.32s cubic-bezier(0.32,0.72,0,1);">

        {{-- Grip + close --}}
        <div style="display:flex; align-items:center; justify-content:center; padding:12px 20px 0; position:sticky; top:0; background:var(--bg-card); z-index:1;">
            <div style="width:36px; height:4px; border-radius:99px; background:var(--border);"></div>
        </div>
        <button @click="panel = null"
                style="position:absolute; top:10px; right:16px; width:28px; height:28px; border-radius:50%; background:var(--bg-cream); border:none; cursor:pointer; display:grid; place-items:center; color:var(--text-muted);">
            {!! $ico('<path d="M18 6 6 18"/><path d="m6 6 12 12"/>', 14) !!}
        </button>

        {{-- ────────────── PANEL : Informations personnelles ────────────── --}}
        <div x-show="panel === 'info'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Informations personnelles</h3>

            <div style="display:flex; flex-direction:column; gap:10px;">
                {{-- Nom --}}
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Nom</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $user->name }}</p>
                </div>
                {{-- Email --}}
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Email</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $user->email }}</p>
                </div>
                {{-- Type voyageur --}}
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Profil voyageur</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $travelTypeLabel }}</p>
                </div>
                {{-- Membre depuis --}}
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Membre depuis</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
                {{-- Nombre de voyages --}}
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Voyages planifiés</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $user->trips()->count() }} voyage{{ $user->trips()->count() > 1 ? 's' : '' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('nouveau-voyage') }}" style="margin-top:16px;">
                @csrf
                <button type="submit"
                        style="width:100%; padding:13px; background:var(--gradient-gold); border:none; border-radius:12px; font-size:13px; font-weight:600; color:var(--navy); cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="M12 5v14"/>
                    </svg>
                    Planifier un nouveau voyage
                </button>
            </form>
        </div>

        {{-- ────────────── PANEL : Moyens de paiement ────────────── --}}
        <div x-show="panel === 'payment'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Moyens de paiement</h3>
            <div style="display:flex; flex-direction:column; align-items:center; padding:32px 0; text-align:center;">
                <div style="width:56px; height:56px; border-radius:16px; background:var(--gradient-gold); display:grid; place-items:center; margin-bottom:14px; color:var(--navy);">
                    {!! $ico('<rect width="20" height="14" x="2" y="5" rx="2"/><path d="M2 10h20"/>', 24) !!}
                </div>
                <p style="font-size:15px; font-weight:600; color:var(--navy);">Bientôt disponible</p>
                <p style="font-size:12px; color:var(--text-muted); margin-top:6px; line-height:1.5;">Gérez vos cartes et moyens de<br>paiement pour réserver directement.</p>
            </div>
        </div>

        {{-- ────────────── PANEL : Préférences ────────────── --}}
        <div x-show="panel === 'prefs'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Préférences</h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:8px;">Style de voyage</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $travelTypeLabel }}</p>
                </div>
                @if($trip)
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:8px;">Transport préféré</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ $transportLabel }}</p>
                </div>
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:8px;">Hébergement préféré</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">{{ ucfirst($trip->accommodation ?? 'Non défini') }}</p>
                </div>
                @endif
                @if(count($activities) > 0)
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:8px;">Activités préférées</p>
                    <div style="display:flex; flex-wrap:wrap; gap:6px; margin-top:4px;">
                        @foreach($activities as $act)
                            <span style="background:var(--gradient-gold); padding:4px 10px; border-radius:99px; font-size:11px; font-weight:500; color:var(--navy);">{{ $act }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                <div style="background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted); margin-bottom:4px;">Langue</p>
                    <p style="font-size:14px; font-weight:600; color:var(--navy);">Français</p>
                </div>
            </div>
        </div>

        {{-- ────────────── PANEL : Notifications ────────────── --}}
        <div x-show="panel === 'notifs'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Notifications</h3>
            <div style="display:flex; flex-direction:column; gap:8px;">
                @php
                $notifRows = [
                    ['key' => 'notif_depart', 'label' => 'Rappels de départ',    'sub' => 'J-7, J-3, J-1 avant votre voyage'],
                    ['key' => 'notif_meteo',  'label' => 'Alertes météo',        'sub' => 'Changements importants sur la destination'],
                    ['key' => 'notif_ia',     'label' => 'Suggestions IA',       'sub' => 'Conseils personnalisés en temps réel'],
                    ['key' => 'notif_news',   'label' => 'Newsletter Trivy',     'sub' => 'Inspirations voyage et nouveautés'],
                ];
                @endphp
                @foreach($notifRows as $nr)
                <div style="display:flex; align-items:center; gap:12px; background:var(--bg-cream); border-radius:12px; padding:12px 14px;">
                    <div style="flex:1;">
                        <p style="font-size:13px; font-weight:500; color:var(--navy);">{{ $nr['label'] }}</p>
                        <p style="font-size:11px; color:var(--text-muted); margin-top:2px;">{{ $nr['sub'] }}</p>
                    </div>
                    {{-- Toggle --}}
                    <button @click="{{ $nr['key'] }} = !{{ $nr['key'] }}"
                            :style="{ background: {{ $nr['key'] }} ? 'var(--navy)' : 'var(--border)' }"
                            style="width:44px; height:24px; border-radius:99px; border:none; cursor:pointer; position:relative; transition:background 0.2s; flex-shrink:0;">
                        <span :style="{ transform: {{ $nr['key'] }} ? 'translateX(22px)' : 'translateX(2px)' }"
                              style="position:absolute; top:2px; width:20px; height:20px; border-radius:50%; background:white; transition:transform 0.2s; box-shadow:0 1px 3px rgba(0,0,0,0.2);"></span>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ────────────── PANEL : Confidentialité ────────────── --}}
        <div x-show="panel === 'privacy'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Confidentialité & sécurité</h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="background:var(--bg-cream); border-radius:12px; padding:14px;">
                    <p style="font-size:12px; font-weight:600; color:var(--navy); margin-bottom:6px;">Vos données</p>
                    <p style="font-size:12px; color:var(--text-muted); line-height:1.6;">Trivy collecte uniquement les données nécessaires à la planification de vos voyages. Vos informations ne sont jamais revendues à des tiers.</p>
                </div>
                <div style="background:var(--bg-cream); border-radius:12px; padding:14px;">
                    <p style="font-size:12px; font-weight:600; color:var(--navy); margin-bottom:6px;">Sécurité</p>
                    <p style="font-size:12px; color:var(--text-muted); line-height:1.6;">Votre mot de passe est chiffré. Nous n'y avons pas accès. En cas d'oubli, utilisez la fonction de réinitialisation.</p>
                </div>
                <button style="width:100%; padding:13px; background:transparent; border:1.5px solid #fecaca; border-radius:12px; font-size:13px; font-weight:500; color:#ef4444; cursor:pointer; margin-top:6px;">
                    Supprimer mon compte
                </button>
            </div>
        </div>

        {{-- ────────────── PANEL : Aide & support ────────────── --}}
        <div x-show="panel === 'help'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">Aide & support</h3>
            @php
            $faqs = [
                ['q' => 'Comment modifier mon voyage ?',         'a' => 'Depuis le dashboard, appuyez sur votre destination. Vous pouvez modifier les dates, l\'hébergement et les voyageurs à tout moment.'],
                ['q' => 'La valise se génère-t-elle seule ?',   'a' => 'Oui. À la fin de l\'onboarding, Trivy crée une liste de départ adaptée à votre destination, votre transport et vos voyageurs. Vous pouvez l\'ajuster librement.'],
                ['q' => 'L\'assistant IA est-il disponible hors ligne ?', 'a' => 'Non, l\'assistant nécessite une connexion internet. Vos données de voyage sont cependant accessibles hors ligne.'],
                ['q' => 'Comment contacter l\'équipe Trivy ?',  'a' => 'Envoyez-nous un email à support@trivy.app — nous répondons sous 24h en semaine.'],
            ];
            @endphp
            <div style="display:flex; flex-direction:column; gap:6px;">
                @foreach($faqs as $i => $faq)
                <div style="background:var(--bg-cream); border-radius:12px; overflow:hidden;">
                    <button @click="faq === {{ $i }} ? faq = null : faq = {{ $i }}"
                            style="display:flex; align-items:center; justify-content:space-between; width:100%; padding:12px 14px; background:transparent; border:none; cursor:pointer; text-align:left;">
                        <span style="font-size:13px; font-weight:500; color:var(--navy); flex:1;">{{ $faq['q'] }}</span>
                        <span :style="{ transform: faq === {{ $i }} ? 'rotate(90deg)' : 'rotate(0)' }"
                              style="transition:transform 0.2s; color:var(--text-muted); flex-shrink:0;">
                            {!! $ico('<path d="M9 18l6-6-6-6"/>', 14) !!}
                        </span>
                    </button>
                    <div x-show="faq === {{ $i }}" style="padding:0 14px 12px;">
                        <p style="font-size:12px; color:var(--text-muted); line-height:1.6;">{{ $faq['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ────────────── PANEL : À propos ────────────── --}}
        <div x-show="panel === 'about'" style="padding:8px 20px 32px;">
            <h3 style="font-family:'Outfit',sans-serif; font-size:16px; font-weight:600; color:var(--navy); margin-bottom:16px;">À propos de Trivy</h3>
            <div style="display:flex; flex-direction:column; align-items:center; text-align:center; padding:16px 0 24px;">
                <div style="width:64px; height:64px; border-radius:20px; background:var(--navy); display:grid; place-items:center; margin-bottom:14px;">
                    {!! $ico('<path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="12" x2="12" y1="12" y2="12"/>', 28) !!}
                </div>
                <p style="font-family:'Outfit',sans-serif; font-size:20px; font-weight:700; color:var(--navy); letter-spacing:0.15em;">TRIVY</p>
                <p style="font-size:11px; color:var(--text-muted); margin-top:4px;">Version 0.1.0 — MVP</p>
                <p style="font-size:12px; color:var(--text-muted); margin-top:14px; line-height:1.6;">Votre assistant de voyage intelligent.<br>Planifiez, préparez, voyagez sereinement.</p>
                <p style="font-size:11px; color:var(--text-muted); margin-top:20px;">Fait avec ♥ en France</p>
            </div>
            <div style="display:flex; flex-direction:column; gap:6px;">
                <button style="width:100%; padding:12px; background:var(--bg-cream); border:1px solid var(--border); border-radius:12px; font-size:12px; color:var(--navy); cursor:pointer;">Conditions d'utilisation</button>
                <button style="width:100%; padding:12px; background:var(--bg-cream); border:1px solid var(--border); border-radius:12px; font-size:12px; color:var(--navy); cursor:pointer;">Politique de confidentialité</button>
            </div>
        </div>

    </div>{{-- /drawer --}}

</div>
</x-layouts.app>
