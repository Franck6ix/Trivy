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
        Schema::table('users', function (Blueprint $table) {
            // Type de voyageur : 'solo', 'couple', 'famille', 'amis', 'affaires'
            $table->string('travel_type')->nullable()->after('email');

            // Préférences JSON : ['plage', 'montagne', 'gastronomie'…]
            $table->json('preferences')->nullable()->after('travel_type');

            $table->boolean('notifications_enabled')->default(true)->after('preferences');

            // Permet de rediriger vers /onboarding si pas encore fait
            $table->boolean('onboarding_completed')->default(false)->after('notifications_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['travel_type', 'preferences', 'notifications_enabled', 'onboarding_completed']);
        });
    }
};
