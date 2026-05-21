<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers l'utilisateur propriétaire du voyage
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('destination');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // 'avion', 'voiture', 'train', 'bateau', 'vélo', 'autre'
            $table->string('transport_type')->nullable();

            // 'hotel', 'famille', 'camping', 'location', 'gite'
            $table->string('accommodation')->nullable();

            // JSON : ['loisirs', 'aventure', 'culturel'…]
            $table->json('trip_types')->nullable();

            // JSON : ['plage', 'rando', 'ski'…]
            $table->json('activities')->nullable();

            // JSON : ['lave-linge', 'piscine', 'berceau'…]
            $table->json('amenities')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
