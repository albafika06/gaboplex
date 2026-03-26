<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('alertes')) return;

        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30)->nullable();       // location, vente_maison, etc.
            $table->string('ville', 100)->nullable();
            $table->unsignedInteger('prix_max')->nullable();
            $table->unsignedTinyInteger('nb_chambres')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};