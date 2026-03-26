<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('paiements_contrat')) return;

        Schema::create('paiements_contrat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contrat_id')->constrained()->cascadeOnDelete();

            // Période concernée
            // Pour location : "2026-05" (année-mois)
            // Pour vente    : "tranche_1", "tranche_2", etc.
            $table->string('periode', 20);

            // Montants
            $table->unsignedBigInteger('montant_du');      // ce qui était dû
            $table->unsignedBigInteger('montant_paye');    // ce qui a été payé
            $table->unsignedBigInteger('montant_restant'); // solde restant sur cette période

            // Mode de paiement
            $table->enum('mode', ['cash', 'airtel_money', 'moov_money'])->default('cash');

            // Statut
            $table->enum('statut', [
                'en_attente',   // loyer dû, rien payé encore
                'partiel',      // paiement partiel effectué
                'complet',      // soldé
                'retard',       // dépassé la date sans paiement
                'avance',       // payé en avance (crédit)
            ])->default('en_attente');

            // Double confirmation
            $table->boolean('confirme_locataire')->default(false);
            $table->boolean('confirme_proprietaire')->default(false);

            // Dates
            $table->date('date_echeance');          // date limite de paiement
            $table->timestamp('date_paiement')->nullable(); // quand il a effectivement payé

            // Litige sur ce paiement spécifique
            $table->boolean('litige')->default(false);
            $table->text('motif_litige')->nullable();

            // Photo preuve (reçu, capture mobile money)
            $table->string('preuve_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements_contrat');
    }
};