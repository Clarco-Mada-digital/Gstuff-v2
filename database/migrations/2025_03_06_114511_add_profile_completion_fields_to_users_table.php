<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileCompletionFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('intitule')->nullable();
            // $table->string('nom_proprietaire')->nullable();
            // $table->string('pseudo')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('npa')->nullable();
            $table->string('canton')->nullable();
            $table->string('ville')->nullable();
            $table->string('categorie')->nullable();
            $table->string('recrutement')->nullable();
            $table->integer('nombre_filles')->nullable();
            $table->string('pratique_sexuelles')->nullable();
            $table->string('tailles')->nullable();
            $table->string('origine')->nullable();
            $table->string('couleur_yeux')->nullable();
            $table->string('couleur_cheveux')->nullable();
            $table->string('mensuration')->nullable();
            $table->string('poitrine')->nullable();
            $table->string('taille_poitrine')->nullable();
            $table->string('pubis')->nullable();
            $table->string('tatouages')->nullable();
            $table->string('mobilite')->nullable();
            $table->string('tarif')->nullable();
            $table->string('paiement')->nullable();
            $table->text('apropos')->nullable();
            $table->string('autre_contact')->nullable();
            $table->string('complement_adresse')->nullable();
            $table->string('lien_site_web')->nullable();
            $table->string('localisation')->nullable();
            // Ajoutez d'autres champs si nécessaire, en fonction des selects et inputs du modal
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'intitule',
                'nom_proprietaire',
                'pseudo',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                'categorie',
                'recrutement',
                'nombre_filles',
                'pratique_sexuelles',
                'tailles',
                'origine',
                'couleur_yeux',
                'couleur_cheveux',
                'mensuration',
                'poitrine',
                'taille_poitrine',
                'pubis',
                'tatouages',
                'mobilite',
                'tarif',
                'paiement',
                'apropos',
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
                // Supprimez les autres champs ajoutés dans la méthode up
            ]);
        });
    }
}
