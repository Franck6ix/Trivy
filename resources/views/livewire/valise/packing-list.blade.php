@php
// SVG helper — Lucide icons
$ico = fn(string $path, int $size = 16): string =>
    '<svg xmlns="http://www.w3.org/2000/svg" width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">'.$path.'</svg>';

$icons = [
    'shirt'     => '<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>',
    'sparkles'  => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4M19 17v4M3 5h4M17 19h4"/>',
    'plug'      => '<path d="M12 22v-5"/><path d="M9 8V2"/><path d="M15 8V2"/><path d="M18 8H6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2z"/>',
    'file-text' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4M10 9H8M16 13H8M16 17H8"/>',
    'check'     => '<path d="M20 6 9 17l-5-5"/>',
    'plus'      => '<path d="M5 12h14"/><path d="M12 5v14"/>',
    'luggage'   => '<path d="M6 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2Z"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="12" x2="12" y1="12" y2="12"/>',
    'home'      => '<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
    'bot'       => '<path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2M20 14h2M15 13v2M9 13v2"/>',
    'user'      => '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/>',
    'x'         => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
];
@endphp

<div style="height:100dvh; display:flex; flex-direction:column; background:var(--bg-cream); overflow:hidden; position:relative;">

    {{-- ── HEADER ── --}}
    <div style="flex-shrink:0; background:var(--bg-card); border-bottom:1px solid var(--border); padding:48px 20px 12px; display:flex; align-items:center; justify-content:space-between;">
        <a href="{{ route('dashboard') }}"
           style="width:32px; height:32px; border-radius:50%; background:var(--bg-cream); display:grid; place-items:center; text-decoration:none; color:var(--navy);">
            {!! $ico('<path d="M15 18l-6-6 6-6"/>') !!}
        </a>
        <div style="text-align:center;">
            <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.2em; color:var(--gold); font-weight:600;">
                {{ $progress['pct'] >= 80 ? 'Niveau Expert' : ($progress['pct'] >= 40 ? 'En cours' : 'À commencer') }}
            </p>
            <p style="font-family:'Outfit',sans-serif; font-size:15px; font-weight:600; color:var(--navy);">Packing List</p>
        </div>
        <div style="width:32px; height:32px;"></div>{{-- spacer --}}
    </div>

    {{-- ── BARRE DE PROGRESSION GLOBALE ── --}}
    <div style="flex-shrink:0; padding:10px 20px 0; background:var(--bg-card); border-bottom:1px solid var(--border);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
            <span style="font-size:11px; color:var(--text-muted);">{{ $progress['done'] }} / {{ $progress['total'] }} articles</span>
            <span style="font-size:11px; font-weight:600; color:var(--gold);">{{ $progress['pct'] }}%</span>
        </div>
        <div style="height:4px; border-radius:99px; background:var(--border); margin-bottom:10px;">
            <div style="height:100%; border-radius:99px; background:var(--gradient-gold); width:{{ $progress['pct'] }}%; transition:width 0.4s ease;"></div>
        </div>

        {{-- Onglets catégories (scroll horizontal) --}}
        <div style="display:flex; gap:8px; overflow-x:auto; padding-bottom:10px; -webkit-overflow-scrolling:touch; scrollbar-width:none;">
            @foreach($categoryDefs as $cat)
                @php
                    $key = $cat['key'];
                    $summary = $categorySummary[$key] ?? null;
                    $count = $summary ? (int)$summary['total'] : 0;
                    $done  = $summary ? (int)$summary['done']  : 0;
                    $active = $activeCategory === $key;
                @endphp
                <button wire:click="switchCategory('{{ $key }}')"
                        style="flex-shrink:0; display:flex; align-items:center; gap:6px; padding:6px 12px; border-radius:99px; border:none; cursor:pointer; font-size:11px; font-weight:500; white-space:nowrap; transition:all 0.2s;
                               background:{{ $active ? 'var(--gradient-gold)' : 'var(--bg-cream)' }};
                               color:{{ $active ? 'var(--navy)' : 'var(--text-muted)' }};
                               box-shadow:{{ $active ? 'var(--shadow-card)' : 'none' }};">
                    <span style="display:flex;">{!! $ico($icons[$cat['icon']], 13) !!}</span>
                    {{ $key }}
                    <span style="padding:1px 6px; border-radius:99px; font-size:9px; background:{{ $active ? 'rgba(28,43,74,0.12)' : 'var(--bg-card)' }}; color:{{ $active ? 'var(--navy)' : 'var(--text-muted)' }};">{{ $count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- ── LISTE D'ITEMS (scrollable) ── --}}
    <div style="flex:1; overflow-y:auto; padding:12px 16px;">

        {{-- Titre de section --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
            <span style="font-size:10px; text-transform:uppercase; letter-spacing:0.12em; color:var(--text-muted); font-weight:500;">
                {{ $activeCategory }} · {{ $items->count() }} objets
            </span>
            @php
                $sum = $categorySummary[$activeCategory] ?? null;
                $catDone = $sum ? (int)$sum['done'] : 0;
                $catTotal = $sum ? (int)$sum['total'] : 0;
            @endphp
            @if($catTotal > 0 && $catDone === $catTotal)
                <span style="font-size:10px; font-weight:600; color:var(--gold);">{{ $catTotal }} / {{ $catTotal }} ✓</span>
            @else
                <span style="font-size:10px; color:var(--text-muted);">{{ $catDone }} / {{ $catTotal }}</span>
            @endif
        </div>

        {{-- Items --}}
        <div style="display:flex; flex-direction:column; gap:8px;">
            @forelse($items as $item)
                <div wire:key="item-{{ $item->id }}"
                     wire:click="toggleItem({{ $item->id }})"
                     style="display:flex; align-items:center; gap:12px; background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:12px 14px; cursor:pointer; transition:opacity 0.15s;">

                    {{-- Checkbox --}}
                    <div style="flex-shrink:0; width:20px; height:20px; border-radius:6px; display:grid; place-items:center;
                                background:{{ $item->is_checked ? 'var(--gradient-gold)' : 'transparent' }};
                                border:{{ $item->is_checked ? '0' : '1.5px solid var(--gold)' }};">
                        @if($item->is_checked)
                            <span style="color:var(--navy);">{!! $ico($icons['check'], 12) !!}</span>
                        @endif
                    </div>

                    {{-- Label --}}
                    <span style="font-size:13px; color:var(--navy); flex:1;
                                 text-decoration:{{ $item->is_checked ? 'line-through' : 'none' }};
                                 opacity:{{ $item->is_checked ? '0.55' : '1' }};">
                        {{ $item->label }}
                    </span>
                </div>
            @empty
                <div style="text-align:center; padding:32px 0; color:var(--text-muted); font-size:13px;">
                    Aucun article dans cette catégorie
                </div>
            @endforelse
        </div>

        {{-- Formulaire d'ajout inline --}}
        @if($showAddForm)
            <div style="display:flex; align-items:center; gap:8px; margin-top:10px; background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:8px 12px;">
                <input wire:model="newItemLabel"
                       wire:keydown.enter="addItem"
                       type="text"
                       placeholder="Nom de l'article…"
                       autofocus
                       style="flex:1; border:none; outline:none; font-size:13px; background:transparent; color:var(--navy);">
                <button wire:click="addItem"
                        style="padding:4px 12px; background:var(--gradient-gold); border:none; border-radius:8px; font-size:12px; font-weight:600; color:var(--navy); cursor:pointer;">
                    Ajouter
                </button>
                <button wire:click="$set('showAddForm', false)"
                        style="background:none; border:none; cursor:pointer; color:var(--text-muted); display:grid; place-items:center;">
                    {!! $ico($icons['x'], 14) !!}
                </button>
            </div>
        @endif

        {{-- Espace cabine (déco) --}}
        <div style="margin-top:16px; background:var(--bg-cream); border:1px solid var(--border); border-radius:16px; padding:14px;">
            <p style="font-size:10px; text-transform:uppercase; letter-spacing:0.12em; color:var(--text-muted); font-weight:500;">Espace cabine</p>
            <div style="display:flex; align-items:flex-end; gap:4px; height:48px; margin-top:10px;">
                @foreach([40, 65, 50, 80, 70, 55] as $h)
                    <div style="flex:1; border-radius:3px; background:var(--gradient-gold); height:{{ $h }}%;"></div>
                @endforeach
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:8px; font-size:10px; color:var(--text-muted);">
                <span>5,2 kg / 7 kg</span>
                <span style="font-weight:600; color:var(--navy);">74%</span>
            </div>
        </div>

        <div style="height:16px;"></div>
    </div>

    {{-- ── FAB : ajouter un article ── --}}
    @if(! $showAddForm)
        <div style="position:absolute; right:20px; bottom:80px; z-index:10;">
            <button wire:click="$set('showAddForm', true)"
                    style="width:52px; height:52px; border-radius:50%; background:var(--gradient-gold); border:none; cursor:pointer; display:grid; place-items:center; box-shadow:0 4px 20px rgba(201,168,76,0.45); color:var(--navy);">
                {!! $ico($icons['plus'], 22) !!}
            </button>
        </div>
    @endif

    {{-- ── NAV BAR ── --}}
    <div style="flex-shrink:0; background:rgba(254,254,254,0.96); backdrop-filter:blur(12px); border-top:1px solid var(--border); padding:8px 24px 20px;">
        <div style="display:flex; align-items:center; justify-content:space-between;">

            {{-- Home --}}
            <a href="{{ route('dashboard') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <span style="color:var(--text-muted);">{!! $ico($icons['home'], 20) !!}</span>
                <span style="font-size:10px; color:var(--text-muted);">Home</span>
            </a>

            {{-- Valise (actif) --}}
            <a href="{{ route('valise') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <span style="color:var(--gold);">{!! $ico($icons['luggage'], 20) !!}</span>
                <span style="font-size:10px; font-weight:600; color:var(--navy);">Valise</span>
            </a>

            {{-- Assistant --}}
            <a href="{{ route('assistant') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <span style="color:var(--text-muted);">{!! $ico($icons['bot'], 20) !!}</span>
                <span style="font-size:10px; color:var(--text-muted);">Assistant</span>
            </a>

            {{-- Profil --}}
            <a href="{{ route('profil') }}" style="display:flex; flex-direction:column; align-items:center; gap:4px; text-decoration:none;">
                <span style="color:var(--text-muted);">{!! $ico($icons['user'], 20) !!}</span>
                <span style="font-size:10px; color:var(--text-muted);">Profil</span>
            </a>

        </div>
    </div>

</div>
