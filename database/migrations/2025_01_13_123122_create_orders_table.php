<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('red_order')->index(); // Added index for faster lookup
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('telephone');
            $table->text('adress');
            $table->string('gouvernorat');
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->date('date_naissance')->nullable();
            $table->dateTime('date_order');
            $table->enum('status', ['encours', 'traité', 'annulé'])->default('encours');
            $table->unsignedBigInteger('id_produit');
            $table->decimal('prix_produit', 10, 2);
            $table->integer('quantite_produit');
            $table->enum('mode_paiement', ['espace', 'carte']);
            $table->dateTime('date_shipping')->nullable();
            $table->string('code_compagnie')->nullable();
            $table->string('source_commande');
            $table->string('ip_client');
            $table->string('device_client');
            $table->timestamps();

            $table->foreign('id_produit')
                ->references('id')
                ->on('products')
                ->onDelete('restrict'); // Changed from 'cascade' to prevent accidental deletions
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}