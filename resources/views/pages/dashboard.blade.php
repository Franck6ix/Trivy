<x-layouts.app title="Trivy — Dashboard">
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush
<div style="height:100dvh; display:flex; flex-direction:column; background:var(--bg-cream); overflow:hidden;">

    {{-- ── HERO : photo destination + infos ── --}}
    <div style="position:relative; height:176px; width:100%; overflow:hidden; flex-shrink:0;">
        <img src="{{ asset('images/' . $heroImage) }}" alt="Destination"
             style="width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:linear-gradient(180deg,rgba(10,15,40,0.35),rgba(10,15,40,0.85))"></div>

        <div style="position:absolute; left:20px; right:20px; bottom:12px; display:flex; align-items:flex-end; justify-content:space-between; color:white;">
            <div>
                @if($trip)
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.2em; color:var(--gold); font-weight:600;">
                        {{ $trip->destination }}
                    </p>
                    <h1 style="font-family:'Outfit',sans-serif; font-size:22px; font-weight:600; margin-top:2px;">
                        Bonjour, {{ auth()->user()->name }}
                    </h1>
                    @php
                        $daysLeft = $trip->start_date ? now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($trip->start_date)->startOfDay(), false) : null;
                    @endphp
                    @if($daysLeft !== null && $daysLeft > 0)
                        <p style="font-size:11px; color:rgba(255,255,255,0.8); margin-top:2px;">
                            Départ dans <span style="color:var(--gold); font-weight:600;">{{ $daysLeft }} jours</span>
                        </p>
                    @elseif($daysLeft === 0)
                        <p style="font-size:11px; color:var(--gold); font-weight:600; margin-top:2px;">C'est aujourd'hui !</p>
                    @else
                        <p style="font-size:11px; color:rgba(255,255,255,0.8); margin-top:2px;">Bon voyage !</p>
                    @endif
                @else
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.2em; color:var(--gold); font-weight:600;">Trivy</p>
                    <h1 style="font-family:'Outfit',sans-serif; font-size:22px; font-weight:600; margin-top:2px;">
                        Bonjour, {{ auth()->user()->name }}
                    </h1>
                    <p style="font-size:11px; color:rgba(255,255,255,0.8); margin-top:2px;">Aucun voyage planifié</p>
                @endif
            </div>

            {{-- Bouton Nouveau voyage --}}
            <form method="POST" action="{{ route('nouveau-voyage') }}" style="flex-shrink:0;">
                @csrf
                <button type="submit" title="Nouveau voyage"
                        style="width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.2); backdrop-filter:blur(8px); border:none; cursor:pointer; display:grid; place-items:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="M12 5v14"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- ── CONTENU SCROLLABLE ── --}}
    <div style="flex:1; overflow-y:auto; padding:12px 16px 0;">

        {{-- Grille météo + documents --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">

            {{-- Météo --}}
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:12px;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted);">Météo</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                </div>
                <p style="font-family:'Outfit',sans-serif; font-size:22px; font-weight:600; color:var(--navy); margin-top:4px;">21°</p>
                <div style="display:flex; align-items:center; gap:8px; font-size:10px; color:var(--text-muted); margin-top:6px;">
                    <span>Min 18°</span>
                    <span>Hum. 35%</span>
                </div>
            </div>

            {{-- Documents --}}
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:12px;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted);">Documents</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4M10 9H8M16 13H8M16 17H8"/>
                    </svg>
                </div>
                <p style="font-family:'Outfit',sans-serif; font-size:13px; font-weight:600; color:var(--navy); margin-top:4px; line-height:1.3;">
                    Passeport<br>Billets
                </p>
                <p style="font-size:10px; color:var(--text-muted); margin-top:6px;">4 fichiers</p>
            </div>
        </div>

        {{-- Bannière valise --}}
        <a href="{{ route('valise') }}" style="margin-top:10px; display:flex; align-items:center; gap:12px; border-radius:16px; padding:14px; background:var(--gradient-gold); box-shadow:var(--shadow-card); text-decoration:none;">
            <div style="width:40px; height:40px; border-radius:12px; background:rgba(28,43,74,0.12); display:grid; place-items:center; flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.75" style="color:var(--navy);">
                    <path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    <line x1="12" x2="12" y1="12" y2="12"/>
                </svg>
            </div>
            <div style="flex:1; min-width:0;">
                <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:rgba(28,43,74,0.65);">Valise intelligente</p>
                <p style="font-size:14px; font-weight:600; color:var(--navy); margin-top:2px;">
                    @if($trip)
                        @php $tCount = $trip->travellers->count(); @endphp
                        {{ $tCount > 0 ? $tCount.' voyageur'.($tCount > 1 ? 's' : '') : 'À préparer' }} · 0% prêt
                    @else
                        À préparer
                    @endif
                </p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" style="color:var(--navy); flex-shrink:0;">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </a>

        {{-- Grille voyageurs + hébergement --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px;">

            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:12px;">
                <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted);">Voyageurs</p>
                <div style="display:flex; align-items:center; gap:6px; margin-top:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" style="color:var(--navy);">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    @php $tCount2 = $trip ? ($trip->travellers->count() ?: 1) : 1; @endphp
                    <span style="font-size:14px; font-weight:600; color:var(--navy);">
                        {{ $tCount2 }} voyageur{{ $tCount2 > 1 ? 's' : '' }}
                    </span>
                </div>
            </div>

            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; padding:12px;">
                <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.1em; color:var(--text-muted);">Hébergement</p>
                <div style="display:flex; align-items:center; gap:6px; margin-top:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span style="font-size:12px; font-weight:600; color:var(--navy); line-height:1.2;">
                        {{ $trip ? ucfirst($trip->accommodation ?? 'Non défini') : 'Non défini' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Carte Leaflet --}}
        <div style="margin-top:10px; border-radius:16px; overflow:hidden; border:1px solid var(--border); background:var(--bg-card); box-shadow:var(--shadow-card);">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 12px 0;">
                <p style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--navy);">Autour de votre hôtel</p>
                <span style="font-size:10px; color:var(--gold); font-weight:500;">{{ $trip ? $trip->destination : '' }}</span>
            </div>
            <div id="trivy-map" style="height:160px; margin-top:8px; z-index:0;"></div>
            <div style="display:flex; align-items:center; gap:8px; padding:10px 12px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                     fill="var(--gold)" stroke="var(--gold)" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                <span style="font-size:11px; font-weight:600; color:var(--navy);">{{ $trip ? ucfirst($trip->accommodation ?? 'Hébergement') : 'Hébergement' }}</span>
                <span style="font-size:10px; color:var(--text-muted);">· OpenStreetMap</span>
            </div>
        </div>

        @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
        (function(){
            var map = L.map('trivy-map', { zoomControl: false, attributionControl: false })
                       .setView([{{ $lat }}, {{ $lng }}], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);
            var icon = L.divIcon({
                className: '',
                html: '<div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#C9A84C,#E8C96A);display:grid;place-items:center;box-shadow:0 0 0 4px rgba(255,255,255,0.7),0 2px 8px rgba(0,0,0,0.25);"><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'14\' height=\'14\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#1C2B4A\' stroke-width=\'2\'><path d=\'M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z\'/><circle cx=\'12\' cy=\'10\' r=\'3\'/></svg></div>',
                iconSize: [28, 28], iconAnchor: [14, 14]
            });
            L.marker([{{ $lat }}, {{ $lng }}], { icon: icon }).addTo(map);
        })();
        </script>
        @endpush

        {{-- Espace sous le dernier élément avant la navbar --}}
        <div style="height:16px;"></div>

    </div>

    {{-- ── NAV BAR (flex-shrink:0, pas fixed) ── --}}
    <div style="flex-shrink:0; background:rgba(254,254,254,0.96); backdrop-filter:blur(12px); border-top:1px solid var(--border); padding:8px 24px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between;">

            {{-- Home (actif) --}}
            <a href="{{ route('dashboard') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span style="font-size:10px; font-weight:600; color:var(--navy);">Home</span>
            </a>

            {{-- Valise --}}
            <a href="{{ route('valise') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    <line x1="12" x2="12" y1="12" y2="12"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Valise</span>
            </a>

            {{-- Assistant --}}
            <a href="{{ route('assistant') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                    <path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Assistant</span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profil') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <circle cx="12" cy="8" r="5"/>
                    <path d="M20 21a8 8 0 1 0-16 0"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Profil</span>
            </a>

        </div>
    </div>

</div>
</x-layouts.app>
