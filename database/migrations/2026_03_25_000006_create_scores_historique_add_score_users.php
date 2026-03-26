<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter colonne score sur users si elle n'existe pas
        if (!Schema::hasColumn('users', 'score')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('score')->default(30)->after('email');
            });
        }

        // Créer scores_historique si elle n'existe pas
        if (Schema::hasTable('scores_historique')) return;

        // Historique de chaque variation de score
        Schema::create('scores_historique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contrat_id')->nullable()->constrained()->nullOnDelete();

            // Action qui a déclenché la variation
            $table->enum('action', [
                'inscription',
                'profil_complet',
                'paiement_complet_airtel',
                'paiement_complet_moov',
                'paiement_complet_cash',
                'paiement_partiel',
                'paiement_avance',
                'retard_paiement',
                'non_paiement',
                'litige_ouvert',
                'litige_resolu_faveur',
                'litige_perdu',
                'avis_positif',
                'avis_negatif',
                'contrat_ferme_solde',
                'photo_signalee',
                'annonce_verifiee',
            ]);

            $table->tinyInteger('points');     // positif ou négatif
            $table->unsignedTinyInteger('score_avant');
            $table->unsignedTinyInteger('score_apres');
            $table->text('detail')->nullable(); // description lisible

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores_historique');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};