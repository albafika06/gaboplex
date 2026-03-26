<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contrats')) return;

        Schema::create('contrats', function (Blueprint $table) {
            $table->id();

            // Annonce concernée
            $table->foreignId('annonce_id')->constrained()->cascadeOnDelete();

            // Parties
            $table->foreignId('locataire_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('proprietaire_id')->constrained('users')->cascadeOnDelete();

            // Type de contrat
            $table->enum('type', ['location', 'vente'])->default('location');

            // Montants
            $table->unsignedBigInteger('montant_mensuel')->nullable();  // location
            $table->unsignedBigInteger('montant_total')->nullable();     // vente
            $table->unsignedBigInteger('caution')->nullable();

            // Dates
            $table->date('date_debut');
            $table->date('date_fin')->nullable();

            // Statut
            $table->enum('statut', [
                'en_attente',   // proposé, pas encore confirmé par les deux
                'actif',        // les deux ont confirmé
                'termine',      // contrat fermé proprement, tout soldé
                'litige',       // litige ouvert
                'annule',       // annulé avant début
            ])->default('en_attente');

            // Suivi financier
            $table->unsignedBigInteger('solde_restant')->default(0);   // dette accumulée
            $table->unsignedBigInteger('credit_avance')->default(0);   // mois payés en avance

            // Confirmation d'accord (les deux doivent confirmer)
            $table->boolean('confirme_locataire')->default(false);
            $table->boolean('confirme_proprietaire')->default(false);

            // Avis de fin de contrat
            $table->tinyInteger('note_locataire')->nullable();       // note donnée par propriétaire
            $table->text('avis_locataire')->nullable();
            $table->tinyInteger('note_proprietaire')->nullable();    // note donnée par locataire
            $table->text('avis_proprietaire')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};