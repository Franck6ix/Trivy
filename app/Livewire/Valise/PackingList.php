<?php

namespace App\Livewire\Valise;

use App\Models\ChecklistItem;
use App\Models\Trip;
use Livewire\Component;

/*
 * DEVBOOK — Valise intelligente
 *
 * Ce composant gère la checklist de voyage par catégorie.
 * Au premier accès, on ensemence des items par défaut adaptés au voyage.
 *
 * Principe :
 * - $activeCategory : la catégorie sélectionnée (tab actif)
 * - toggleItem()    : coche / décoche un item (round-trip serveur minimal)
 * - addItem()       : ajoute un item dans la catégorie active
 * - Les computed properties (get*Property) sont calculées à chaque rendu
 */
class PackingList extends Component
{
    public ?Trip $trip = null;
    public string $activeCategory = 'Vêtements';
    public string $newItemLabel = '';
    public bool $showAddForm = false;

    // Catégories disponibles (ordre fixe)
    public array $categoryDefs = [
        ['key' => 'Vêtements',    'icon' => 'shirt'],
        ['key' => 'Toilettes',    'icon' => 'sparkles'],
        ['key' => 'Électronique', 'icon' => 'plug'],
        ['key' => 'Documents',    'icon' => 'file-text'],
    ];

    public function mount(): void
    {
        $this->trip = auth()->user()->trips()->latest()->first();

        if ($this->trip && $this->trip->checklistItems()->count() === 0) {
            $this->seedDefaultItems();
        }
    }

    // Items visibles pour la catégorie active
    public function getItemsProperty()
    {
        if (! $this->trip) {
            return collect();
        }

        return $this->trip->checklistItems()
            ->where('category', $this->activeCategory)
            ->orderBy('sort_order')
            ->get();
    }

    // Résumé par catégorie (total / cochés) pour les badges
    public function getCategorySummaryProperty(): array
    {
        if (! $this->trip) {
            return [];
        }

        return $this->trip->checklistItems()
            ->selectRaw('category, count(*) as total, sum(is_checked) as done')
            ->groupBy('category')
            ->get()
            ->keyBy('category')
            ->toArray();
    }

    // Progression globale
    public function getProgressProperty(): array
    {
        if (! $this->trip) {
            return ['total' => 0, 'done' => 0, 'pct' => 0];
        }

        $total = $this->trip->checklistItems()->count();
        $done  = $this->trip->checklistItems()->where('is_checked', true)->count();

        return [
            'total' => $total,
            'done'  => $done,
            'pct'   => $total > 0 ? (int) round($done / $total * 100) : 0,
        ];
    }

    // Changer de catégorie
    public function switchCategory(string $cat): void
    {
        $this->activeCategory = $cat;
        $this->showAddForm    = false;
        $this->newItemLabel   = '';
    }

    // Cocher / décocher un item
    public function toggleItem(int $id): void
    {
        $item = ChecklistItem::findOrFail($id);

        if ((int) $item->trip_id !== $this->trip?->id) {
            abort(403);
        }

        $item->update(['is_checked' => ! $item->is_checked]);
    }

    // Ajouter un item dans la catégorie active
    public function addItem(): void
    {
        $label = trim($this->newItemLabel);

        if ($label === '' || ! $this->trip) {
            return;
        }

        $max = $this->trip->checklistItems()
            ->where('category', $this->activeCategory)
            ->max('sort_order') ?? 0;

        $this->trip->checklistItems()->create([
            'category'   => $this->activeCategory,
            'label'      => $label,
            'is_checked' => false,
            'sort_order' => $max + 1,
        ]);

        $this->newItemLabel = '';
        $this->showAddForm  = false;
    }

    // Items par défaut — appelés uniquement si la checklist est vide
    private function seedDefaultItems(): void
    {
        $defaults = [
            'Vêtements' => [
                'Tee-shirts × 5', 'Pantalons × 2', 'Veste imperméable',
                'Chaussures de sport', 'Sous-vêtements × 5', 'Pyjama',
            ],
            'Toilettes' => [
                'Brosse à dents', 'Dentifrice', 'Crème solaire SPF50',
                'Déodorant', 'Shampoing', 'Médicaments essentiels',
            ],
            'Électronique' => [
                'Chargeur USB-C', 'Adaptateur EU', 'Écouteurs',
                'Batterie externe',
            ],
            'Documents' => [
                'Passeport', 'Billets d\'avion', 'Assurance voyage',
                'Réservation hôtel',
            ],
        ];

        foreach ($defaults as $category => $items) {
            foreach ($items as $i => $label) {
                $this->trip->checklistItems()->create([
                    'category'   => $category,
                    'label'      => $label,
                    'is_checked' => false,
                    'sort_order' => $i,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.valise.packing-list', [
            'items'           => $this->items,
            'categorySummary' => $this->categorySummary,
            'progress'        => $this->progress,
        ])->layout('components.layouts.app', ['title' => 'Trivy — Valise']);
    }
}
