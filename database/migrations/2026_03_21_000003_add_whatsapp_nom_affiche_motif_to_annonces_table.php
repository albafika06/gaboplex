<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('whatsapp', 30)->nullable()->after('quartier');
            $table->string('nom_affiche', 100)->nullable()->after('whatsapp');
            $table->text('motif_rejet')->nullable()->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn(['whatsapp', 'nom_affiche', 'motif_rejet']);
        });
    }
};