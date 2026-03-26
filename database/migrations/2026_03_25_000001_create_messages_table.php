<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Si la table existe déjà on ne fait rien
        if (Schema::hasTable('messages')) {
            return;
        }

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->cascadeOnDelete();
            $table->string('expediteur_nom', 100);
            $table->string('expediteur_email', 150);
            $table->text('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};