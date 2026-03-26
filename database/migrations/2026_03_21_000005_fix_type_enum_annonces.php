<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier la colonne type pour accepter toutes les valeurs
        DB::statement("ALTER TABLE annonces MODIFY COLUMN type ENUM('location','vente_maison','vente_terrain','commerce') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE annonces MODIFY COLUMN type ENUM('location','vente_maison','vente_terrain') NOT NULL");
    }
};