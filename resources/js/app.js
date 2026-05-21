import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Enregistre le plugin intersect (utile pour les animations au scroll)
Alpine.plugin(intersect);

// Rend Alpine disponible globalement (nécessaire pour Livewire + Alpine)
window.Alpine = Alpine;

Alpine.start();
