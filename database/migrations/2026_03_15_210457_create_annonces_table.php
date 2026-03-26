<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->enum('type', ['location', 'vente_maison', 'vente_terrain']);
            $table->unsignedBigInteger('prix');
            $table->unsignedInteger('superficie')->nullable();
            $table->string('ville');
            $table->string('quartier');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('statut', ['en_attente', 'active', 'rejetee', 'expiree'])->default('en_attente');
            $table->boolean('is_premium')->default(false);
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};