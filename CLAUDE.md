# Trivy — Contexte projet pour Claude

## L'application
Trivy est une app mobile-first de gestion de voyages intelligente.
Backend : Laravel 13 + Filament 5 (admin). Frontend : Blade + Livewire 3 + Alpine.js.
Design system : référence visuelle dans `~/Downloads/journey-weaver-main` (React, ne pas modifier).

## Stack retenue
- PHP 8.3 / Laravel 13
- Livewire 3 (interactivité côté serveur)
- Alpine.js (micro-interactions JS)
- Tailwind CSS v4
- Filament 5 (panel admin `/admin`)
- SQLite (dev) → MySQL (prod)

## Palette de couleurs (depuis journey-weaver)
- Background : `oklch(0.975 0.012 80)` → `#F5F0E8` crème chaud
- Primary/Navy : `oklch(0.22 0.05 255)` → `#1C2B4A`
- Gold : `oklch(0.78 0.11 80)` → `#C9A84C`
- Card : `oklch(0.995 0.005 80)` → `#FEFEFE`
- Border : `oklch(0.88 0.02 80)` → `#E2DDD4`

## Typographie
- Display/Titres : Outfit (300–800)
- Corps : Inter (300–600)
- Serif italique : Instrument Serif

## Architecture des écrans (ordre de dev)
0. Splash / Welcome
1. Onboarding (10 étapes Livewire multi-step)
2. Génération IA (loading screen)
3. Dashboard home
4. Valise intelligente
5. Assistant IA (chat)
6. Profil / Paramètres

## Schéma BDD (source : schema-bdd.sql)
users, trips, travellers, categories, checklist_items, weather_cache, user_habits

## Règles de dev
- Suivre le DEVBOOK.md pour la méthode
- Controllers fins — logique dans les Services/Actions
- Un Livewire component = un écran ou une fonctionnalité
- Blade layouts : `layouts/app.blade.php` (app mobile) et `layouts/admin.blade.php`
- Commits conventionnels : `feat:`, `fix:`, `refactor:`, `style:`

