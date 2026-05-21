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
        Schema::create('travellers', function (Blueprint $table) {
            $table->id();

            // Clé étrangère : un voyageur appartient à un voyage
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();

            $table->string('name')->nullable();

            // 'adult', 'child', 'baby'
            $table->string('age_group')->default('adult');

            $table->boolean('is_baby')->default(false);
            $table->boolean('is_child')->default(false);

            // Besoins spécifiques : 'siège auto', 'chaise haute'…
            $table->string('specific_needs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travellers');
    }
};
