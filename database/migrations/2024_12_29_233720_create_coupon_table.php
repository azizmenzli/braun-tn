<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() 
{
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->enum('type', ['fixed', 'percent']); // Type de coupon : fixe ou pourcentage
        $table->decimal('value', 10, 2); // Valeur du coupon
        $table->decimal('cart_value', 10, 2); // Valeur minimum du panier
        $table->decimal('ceiling', 10, 2)->nullable(); // Plafond du coupon
        $table->decimal('min_spend', 10, 2); // Dépense minimum
        $table->integer('usage_limit_per_order')->nullable(); // Limite d'utilisation par commande
        $table->integer('usage_limit_per_user')->nullable(); // Limite par utilisateur
        $table->date('start_date'); // Date de début
        $table->date('end_date'); // Date de fin
        $table->enum('status', ['active', 'inactive'])->default('active'); // Statut du coupon
        $table->timestamps(); // Création et mise à jour
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon');
    }
};
