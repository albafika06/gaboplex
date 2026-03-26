<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Expéditeur connecté (nullable pour garder compatibilité avec anciens messages)
            $table->foreignId('sender_id')->nullable()->after('annonce_id')
                  ->constrained('users')->nullOnDelete();

            // Destinataire (le propriétaire de l'annonce en général)
            $table->foreignId('receiver_id')->nullable()->after('sender_id')
                  ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
            $table->dropColumn(['sender_id', 'receiver_id']);
        });
    }
};