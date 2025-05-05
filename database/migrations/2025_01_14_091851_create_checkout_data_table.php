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
        Schema::create('checkout_data', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->date('birth_date');
            $table->decimal('total_price', 10, 2);  // prix total de la commande
            $table->json('products');  // informations des produits
            $table->enum('payment_method', ['card', 'cash_on_delivery']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_data');
    }
};
