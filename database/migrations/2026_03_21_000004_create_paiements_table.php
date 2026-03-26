<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('annonce_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('offre', ['boost_14j', 'premium_30j', 'pass_annuel']);
            $table->integer('montant'); // en FCFA
            $table->string('mode_paiement', 30)->nullable(); // airtel_money, moov_money, carte
            $table->enum('statut', ['en_attente', 'complete', 'echoue'])->default('en_attente');
            $table->string('transaction_id', 100)->nullable()->unique(); // ID CinetPay
            $table->string('cinetpay_token', 255)->nullable();
            $table->json('cinetpay_data')->nullable(); // réponse brute CinetPay
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};