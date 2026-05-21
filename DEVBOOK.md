# DEVBOOK — Méthode de développement Trivy

> Document vivant. Mis à jour à chaque fonctionnalité.
> Objectif : comprendre **pourquoi** chaque décision, pas juste **quoi**.

---

## 1. La philosophie

### Ce qu'on évite
- Coder sans comprendre la structure
- Copier-coller sans savoir ce que ça fait
- Ajouter des features avant que la base soit solide

### Ce qu'on fait
- **Database first** : on conçoit la BDD avant de coder quoi que ce soit
- **Thin controllers** : un controller ne fait qu'orchestrer, jamais la logique métier
- **Un fichier = une responsabilité** : chaque classe a un seul rôle clair
- **Commits fréquents** : chaque étape terminée = un commit

---

## 2. La stack et pourquoi

| Technologie | Rôle | Pourquoi ce choix |
|---|---|---|
| **Laravel 13** | Framework PHP backend | Convention over configuration. Ecosystème riche. Idéal pour apprendre MVC proprement. |
| **Livewire 3** | Interactivité frontend | On reste en PHP. Pas de React/Vue à apprendre séparément. Composants réactifs écrits en PHP. |
| **Alpine.js** | Micro-JS | Pour les animations, toggles, dropdowns. Très léger. Complément naturel de Livewire. |
| **Tailwind CSS v4** | Styles | Utility-first. Aucune CSS custom à maintenir. Cohérent avec le prototype visuel. |
| **Filament 5** | Panel admin | CRUD généré automatiquement. Parfait pour gérer les données sans coder un admin from scratch. |
| **SQLite (dev)** | Base de données locale | Zéro configuration. Un seul fichier. Parfait pour développer en local. |

---

## 3. Le workflow de développement

### Pour chaque nouvelle feature, toujours dans cet ordre :

```
1. MIGRATION    → définir la structure de la table
2. MODEL        → les relations, les casts, les règles
3. SEEDER       → des données de test réalistes
4. ACTION/SERVICE → la logique métier
5. CONTROLLER   → reçoit la requête, appelle l'action, retourne la vue
6. LIVEWIRE     → si la page est interactive
7. BLADE VIEW   → le HTML, fidèle au design
8. TEST         → vérifier que ça marche
9. COMMIT       → message clair, conventionnel
```

### Pourquoi cet ordre ?
- On part des données (la vérité de l'app) vers l'interface (ce que voit l'user)
- Si la BDD change, tout le reste change. Autant bien la définir d'abord.
- Un test écrit après le code reste utile — il documente le comportement attendu.

---

## 4. Architecture des dossiers

```
app/
├── Actions/           ← Logique métier (CreateTrip, GenerateChecklist...)
├── Models/            ← Eloquent models
├── Http/
│   ├── Controllers/   ← Fins. Orchestrent seulement.
│   └── Middleware/
├── Livewire/          ← Composants interactifs (OnboardingWizard, ChatAssistant...)
├── Services/          ← Services externes (WeatherService, AIService...)
└── Providers/

resources/
├── views/
│   ├── layouts/       ← app.blade.php (shell mobile)
│   ├── pages/         ← pages complètes
│   └── components/    ← composants Blade réutilisables
├── css/
│   └── app.css        ← Design system Trivy (couleurs, fonts, tokens)
└── js/
    └── app.js         ← Alpine.js + Livewire bootstrap

database/
├── migrations/        ← Toujours avec timestamps, jamais modifier une migration existante
├── seeders/           ← Données de test
└── factories/         ← Génération de fausses données
```

---

## 5. Conventions de nommage

| Élément | Convention | Exemple |
|---|---|---|
| Model | PascalCase singulier | `Trip`, `ChecklistItem` |
| Migration | snake_case descriptif | `create_trips_table` |
| Controller | PascalCase + Controller | `TripController` |
| Action | Verbe + Nom | `CreateTripAction`, `GenerateChecklistAction` |
| Livewire | PascalCase | `OnboardingWizard`, `SmartChecklist` |
| Blade view | kebab-case | `trip-dashboard.blade.php` |
| Route | kebab-case | `/trips/create`, `/onboarding/step-1` |
| Variable | camelCase | `$tripDuration`, `$currentStep` |

---

## 6. Conventions de commits

Format : `type(scope): description courte`

| Type | Usage |
|---|---|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `style` | Changement visuel, CSS |
| `refactor` | Restructuration sans changer le comportement |
| `db` | Migration, seeder, model |
| `test` | Ajout ou modification de tests |
| `docs` | Documentation |

**Exemples :**
```
feat(auth): add Apple/Google/Email login
db(trips): create trips migration with JSON fields
style(splash): implement full-bleed background with gradient overlay
feat(onboarding): add multi-step wizard Livewire component
```

---

## 7. Le Design System Trivy

### Couleurs (à coller dans `resources/css/app.css`)

```css
:root {
  /* Fonds */
  --bg-cream:    #F5F0E8;   /* fond principal */
  --bg-card:     #FEFEFE;   /* cartes */
  --bg-sand:     #F0EBE0;   /* sections alternées */

  /* Brand */
  --navy:        #1C2B4A;   /* couleur primaire, textes forts */
  --gold:        #C9A84C;   /* accent, CTA, badges */
  --gold-light:  #E8D08A;   /* gold dilué */
  --gold-deep:   #A07830;   /* gold sombre */

  /* Textes */
  --text-main:   #1C2B4A;
  --text-muted:  #7A7A8A;
  --text-light:  #A0A0B0;

  /* Bordures */
  --border:      #E2DDD4;

  /* Gradients */
  --gradient-gold: linear-gradient(135deg, #E8D08A, #A07830);
  --gradient-navy: linear-gradient(160deg, #2A3F6A, #101828);
  --gradient-sand: linear-gradient(180deg, #F5F0E8, #EDE5D8);
}
```

### Typographie

```css
/* Dans <head> de layouts/app.blade.php */
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

/* Utilisation */
.font-display  { font-family: 'Outfit', sans-serif; }
.font-body     { font-family: 'Inter', sans-serif; }
.font-serif    { font-family: 'Instrument Serif', serif; }
```

### Composants de base

```
Bouton primaire   → bg-gradient-gold, rounded-full, py-3.5, font-semibold
Bouton social     → bg-white ou bg-black, rounded-full, border, text-sm
Card              → bg-card, rounded-2xl, border border-border, shadow-card
Badge gold        → bg-gradient-gold, rounded-full, px-3 py-1, text-[10px]
Input             → bg-secondary, rounded-2xl, border-none, px-4 py-3
```

---

## 8. Pattern Livewire — Comment structurer un composant

```php
// app/Livewire/OnboardingWizard.php
class OnboardingWizard extends Component
{
    // 1. Les données (état du composant)
    public int $step = 1;
    public array $data = [];

    // 2. Les règles de validation par étape
    protected function rules(): array { ... }

    // 3. Les actions (ce qui se passe quand l'user clique)
    public function nextStep(): void { ... }
    public function previousStep(): void { ... }

    // 4. Le rendu
    public function render(): View
    {
        return view('livewire.onboarding-wizard');
    }
}
```

**Règle d'or Livewire :** tout ce qui change à l'écran sans reload = propriété `public`.

---

## 9. Pattern Controller fin

```php
// ✅ Bon — controller qui orchestre
class TripController extends Controller
{
    public function store(StoreTripRequest $request, CreateTripAction $action): RedirectResponse
    {
        $trip = $action->execute($request->validated(), auth()->user());
        return redirect()->route('dashboard')->with('success', 'Voyage créé !');
    }
}

// ❌ Mauvais — controller qui fait tout
class TripController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // 50 lignes de logique ici...
    }
}
```

---

## 10. Journal de développement

### Phase 0 — Setup & Splash (en cours)

**Objectif :** Mettre en place la base technique et coder l'écran de bienvenue.

**Étapes :**
- [x] Créer CLAUDE.md et DEVBOOK.md
- [ ] Configurer Tailwind v4 avec le design system Trivy
- [ ] Créer le layout mobile (`layouts/app.blade.php`)
- [ ] Coder la page Splash/Welcome (Blade, fidèle au prototype)
- [ ] Configurer l'auth Laravel (Breeze ou custom)
- [ ] Boutons Apple / Google / Email

**Décisions prises :**
- Blade + Livewire plutôt qu'Inertia+React → on reste dans l'écosystème PHP, plus simple à apprendre
- Layout mobile-first avec `max-width: 390px` centré → simule l'expérience mobile sur desktop
- Alpine.js pour les animations du splash → plus léger que Livewire pour des effets purement visuels
- `<x-layouts.app>` = composant Blade anonyme → fichier dans `views/components/layouts/`, PAS dans `views/layouts/`
- Assets images dans `public/images/` → accessibles directement via `asset('images/xxx.jpg')`
- `.env` non commité, `.env.example` commité → bonne pratique sécurité (jamais de secrets en git)

---

> **Comment lire ce fichier :**
> À chaque fois qu'on code une nouvelle feature, on ajoute une entrée dans le Journal (section 10).
> On y note : l'objectif, les étapes, et surtout les **décisions prises avec leur justification**.
> Dans 6 mois, si quelqu'un reprend le projet, il comprend tout sans avoir à demander.
