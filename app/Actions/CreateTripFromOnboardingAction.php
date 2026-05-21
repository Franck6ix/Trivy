<?php

namespace App\Actions;

use App\Models\Trip;
use App\Models\User;

/*
 * DEVBOOK — Pattern Action
 *
 * Une Action = une seule responsabilité métier.
 * Ici : créer un voyage + les voyageurs depuis les données d'onboarding.
 *
 * Pourquoi une Action et pas dans le Controller ou le Livewire ?
 * → Réutilisable : on peut appeler cette Action depuis un Controller,
 *   un job, un test, ou une commande Artisan.
 * → Testable : on teste l'Action isolément, sans HTTP.
 * → Lisible : le Livewire ne fait qu'appeler execute(), le reste est ici.
 */
class CreateTripFromOnboardingAction
{
    public function execute(User $user, array $data): Trip
    {
        // 1. Mettre à jour le profil user
        $user->update([
            'name'                 => $data['name'] ?: $user->name,
            'travel_type'          => $data['travel_type'],
            'preferences'          => $data['activities'],
            'onboarding_completed' => true,
        ]);

        // 2. Créer le voyage principal
        $trip = Trip::create([
            'user_id'        => $user->id,
            'destination'    => $data['destination'],
            'start_date'     => $data['start_date'] ?: null,
            'end_date'       => $data['end_date'] ?: null,
            'transport_type' => $data['transport_type'],
            'accommodation'  => $data['accommodation'],
            'trip_types'     => $data['trip_types'],
            'activities'     => $data['activities'],
            'amenities'      => $data['amenities'],
        ]);

        // 3. Créer les voyageurs adultes
        for ($i = 0; $i < (int) $data['adults']; $i++) {
            $trip->travellers()->create([
                'age_group' => 'adult',
                'is_baby'   => false,
                'is_child'  => false,
            ]);
        }

        // 4. Créer les voyageurs enfants
        for ($i = 0; $i < (int) $data['children']; $i++) {
            $trip->travellers()->create([
                'age_group'      => 'child',
                'is_child'       => true,
                'specific_needs' => $data['specific_needs'] ?: null,
            ]);
        }

        // 5. Créer les bébés
        for ($i = 0; $i < (int) $data['babies']; $i++) {
            $trip->travellers()->create([
                'age_group'      => 'baby',
                'is_baby'        => true,
                'specific_needs' => $data['specific_needs'] ?: null,
            ]);
        }

        return $trip;
    }
}
