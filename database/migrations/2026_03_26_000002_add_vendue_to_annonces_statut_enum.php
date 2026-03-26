<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter 'vendue' à l'enum statut de la table annonces
        DB::statement("ALTER TABLE annonces MODIFY COLUMN statut ENUM(
            'en_attente',
            'active',
            'rejetee',
            'expiree',
            'vendue'
        ) NOT NULL DEFAULT 'en_attente'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE annonces MODIFY COLUMN statut ENUM(
            'en_attente',
            'active',
            'rejetee',
            'expiree'
        ) NOT NULL DEFAULT 'en_attente'");
    }
};