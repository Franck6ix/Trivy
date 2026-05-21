<div style="height:100dvh; display:flex; flex-direction:column; background:var(--bg-cream); overflow:hidden;"
     x-data
     x-init="$watch('$wire.messages', () => { $nextTick(() => { let el = document.getElementById('chat-scroll'); if(el) el.scrollTop = el.scrollHeight; }) })">

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
            <p style="font-size:10px; color:var(--text-muted); margin-top:1px;">Proactif · Claude Haiku</p>
        </div>
        <span style="width:8px; height:8px; border-radius:50%; background:#10b981; flex-shrink:0;"></span>
    </div>

    {{-- ── MESSAGES ── --}}
    <div id="chat-scroll" style="flex:1; overflow-y:auto; padding:16px 16px 0;">
        @foreach($messages as $msg)
            @if($msg['from'] === 'user')
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <div style="max-width:80%; background:var(--gradient-gold); border-radius:16px; border-top-right-radius:4px; padding:10px 14px; font-size:12px; font-weight:500; color:var(--navy); box-shadow:var(--shadow-card);">
                        {{ $msg['text'] }}
                    </div>
                </div>
            @else
                <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
                    <div style="max-width:82%; background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:10px 14px; font-size:12px; color:var(--navy); box-shadow:var(--shadow-card); line-height:1.55;">
                        {{ $msg['text'] }}
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Indicateur "en train d'écrire…" --}}
        @if($thinking)
            <div style="display:flex; justify-content:flex-start; margin-bottom:10px;">
                <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:16px; border-top-left-radius:4px; padding:12px 16px; display:flex; gap:4px; align-items:center;">
                    <span style="width:6px; height:6px; border-radius:50%; background:var(--gold); animation:trivy-bob 0.9s ease-in-out infinite;"></span>
                    <span style="width:6px; height:6px; border-radius:50%; background:var(--gold); animation:trivy-bob 0.9s ease-in-out 0.2s infinite;"></span>
                    <span style="width:6px; height:6px; border-radius:50%; background:var(--gold); animation:trivy-bob 0.9s ease-in-out 0.4s infinite;"></span>
                </div>
            </div>
        @endif

        <div style="height:16px;"></div>
    </div>

    {{-- ── BARRE DE SAISIE ── --}}
    <div style="flex-shrink:0; padding:10px 16px; background:var(--bg-cream);">
        <div style="display:flex; align-items:center; gap:10px; background:var(--bg-card); border:1px solid var(--border); border-radius:99px; padding:8px 8px 8px 16px; box-shadow:var(--shadow-card);">
            <input wire:model="input"
                   wire:keydown.enter="sendMessage"
                   type="text"
                   placeholder="Demandez à l'IA…"
                   style="flex:1; border:none; outline:none; font-size:12px; background:transparent; color:var(--navy);"
                   @disabled($thinking)>
            <button wire:click="sendMessage"
                    @disabled($thinking)
                    style="width:34px; height:34px; border-radius:50%; background:var(--gradient-gold); border:none; cursor:pointer; display:grid; place-items:center; color:var(--navy); flex-shrink:0; transition:opacity 0.2s;"
                    :style="{ opacity: $wire.thinking ? '0.5' : '1' }">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9l20-7z"/>
                </svg>
            </button>
        </div>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gold);">
                    <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/>
                    <path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>
                </svg>
                <span style="font-size:10px; font-weight:600; color:var(--navy);">Assistant</span>
            </a>
            <a href="{{ route('profil') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);">
                    <circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/>
                </svg>
                <span style="font-size:10px; color:var(--text-muted);">Profil</span>
            </a>
        </div>
    </div>
</div>
