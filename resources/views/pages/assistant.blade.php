<x-layouts.app title="Trivy — Assistant IA">
<div style="height:100dvh; display:flex; flex-direction:column; background:var(--bg-cream); overflow:hidden;">

    {{-- ── HEADER ── --}}
    <div style="flex-shrink:0; background:var(--bg-card); border-bottom:1px solid var(--border); padding:48px 20px 14px; display:flex; align-items:center; gap:12px;">
        <div style="width:36px; height:36px; border-radius:50%; background:var(--navy); display:grid; place-items:center; flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                 style="color:var(--gold);">
                <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                <path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
            </svg>
        </div>
        <div style="flex:1;">
            <p style="font-family:'Outfit',sans-serif; font-size:14px; font-weight:600; color:var(--navy);">Assistant IA</p>
            <p style="font-size:10px; color:var(--text-muted); margin-top:1px;">Proactif · répond en 1s</p>
        </div>
        <span style="width:8px; height:8px; border-radius:50%; background:#10b981; flex-shrink:0;"></span>
    </div>

    {{-- ── MESSAGES (scrollable) ── --}}
    <div style="flex:1; overflow-y:auto; padding:16px 16px 0;" id="chat-messages">

        {{-- Message IA --}}
        <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:10px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card);">
                Bonjour {{ auth()->user()->name }} ! Je suis votre assistant de voyage. Je peux gérer votre valise, trouver des activités, vérifier la météo… Que puis-je faire pour vous ?
            </div>
        </div>

        {{-- Message utilisateur --}}
        <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--gradient-gold); border-radius:16px; border-top-right-radius:4px; padding:10px 14px; font-size:12px; font-weight:500; color:var(--navy); box-shadow:var(--shadow-card);">
                Ajoute un parapluie, il va pleuvoir.
            </div>
        </div>

        {{-- Message IA --}}
        <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:10px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card);">
                Valise mise à jour ✓
            </div>
        </div>

        {{-- Message utilisateur --}}
        <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--gradient-gold); border-radius:16px; border-top-right-radius:4px; padding:10px 14px; font-size:12px; font-weight:500; color:var(--navy); box-shadow:var(--shadow-card);">
                Je voyage avec un bébé, adapte la valise.
            </div>
        </div>

        {{-- Message IA --}}
        <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:10px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card);">
                Section bébé ajoutée — 12 objets.
            </div>
        </div>

        {{-- Message utilisateur --}}
        <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--gradient-gold); border-radius:16px; border-top-right-radius:4px; padding:10px 14px; font-size:12px; font-weight:500; color:var(--navy); box-shadow:var(--shadow-card);">
                Trouve un resto ouvert près de mon hôtel.
            </div>
        </div>

        {{-- Message IA --}}
        <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
            <div style="max-width:80%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:10px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card);">
                3 restaurants proposés sur le Dashboard.
            </div>
        </div>

        {{-- Carte "Anticipation IA" --}}
        <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
            <div style="max-width:85%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:12px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card);">
                <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.15em; color:var(--gold); font-weight:600; margin-bottom:6px;">Anticipation IA</p>
                J'anticipe vos besoins : pluie demain, activités outdoor adaptées, contraintes cabine respectées.
            </div>
        </div>

        <div style="height:16px;"></div>
    </div>

    {{-- ── BARRE DE SAISIE ── --}}
    <div style="flex-shrink:0; padding:10px 16px; background:var(--bg-cream);">
        <div style="display:flex; align-items:center; gap:10px; background:var(--bg-card); border:1px solid var(--border); border-radius:99px; padding:10px 16px; box-shadow:var(--shadow-card);">
            <span style="flex:1; font-size:12px; color:var(--text-muted);">Demandez à l'IA…</span>
            <button style="width:32px; height:32px; border-radius:50%; background:var(--gradient-gold); border:none; cursor:pointer; display:grid; place-items:center; color:var(--navy); flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2M12 19v3M8 22h8"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── NAV BAR ── --}}
    <div style="flex-shrink:0; background:rgba(254,254,254,0.96); backdrop-filter:blur(12px); border-top:1px solid var(--border); padding:8px 24px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between;">

            {{-- Home --}}
            <a href="{{ route('dashboard') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Home</span>
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

            {{-- Assistant (actif) --}}
            <a href="{{ route('assistant') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                    <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                    <path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
                </svg>
                <span style="font-size:10px; font-weight:600; color:var(--navy);">Assistant</span>
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
