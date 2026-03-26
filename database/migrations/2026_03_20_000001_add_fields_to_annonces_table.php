<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->string('sous_type')->nullable()->after('type');
            $table->unsignedTinyInteger('nb_chambres')->nullable()->after('superficie');
            $table->unsignedTinyInteger('nb_sdb')->nullable()->after('nb_chambres');
            $table->boolean('meuble')->default(false)->after('nb_sdb');
            $table->boolean('parking')->default(false)->after('meuble');
            $table->unsignedInteger('caution')->nullable()->after('parking');
            $table->boolean('charges_incluses')->default(false)->after('caution');
            $table->date('disponible_le')->nullable()->after('charges_incluses');
            $table->string('etat_bien')->nullable()->after('disponible_le');
            $table->boolean('titre_foncier')->default(false)->after('etat_bien');
            $table->boolean('prix_negotiable')->default(false)->after('titre_foncier');
            $table->boolean('verifie')->default(false)->after('prix_negotiable');
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn([
                'sous_type','nb_chambres','nb_sdb','meuble','parking',
                'caution','charges_incluses','disponible_le',
                'etat_bien','titre_foncier','prix_negotiable','verifie',
            ]);
        });
    }
};