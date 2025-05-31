<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('red_order'); // Référence de la commande
            $table->string('order_id'); // ID de commande Konnect
            $table->decimal('amount', 10, 2); // Montant total
            $table->string('currency')->default('TND');
            $table->string('status')->default('pending'); // pending, success, failed
            $table->string('payment_method')->default('card');
            $table->string('transaction_id')->nullable(); // ID de transaction Konnect
            $table->string('payment_url')->nullable(); // URL de paiement Konnect
            $table->json('payment_details')->nullable(); // Détails complets de la réponse API
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Index pour les recherches rapides
            $table->index('red_order');
            $table->index('order_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
};