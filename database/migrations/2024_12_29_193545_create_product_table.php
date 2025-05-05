<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description');
            $table->decimal('regular_price');
            $table->decimal('sale_price')->nullable();
            $table->string('SKU');
            $table->enum('stock_status', ['instock', 'outofstock']);
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('quantity')->default(10);
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();            
            $table->bigInteger('sous_categorie_id')->unsigned()->nullable(); // Sous-catégorie
            $table->unsignedBigInteger('attribut_id')->nullable();
            $table->string('value_attribut')->nullable()->default('');  // Ajout de value_attribut avec valeur par défaut
            $table->integer('Publié')->default(1); // Statut de publication (0 pour non publié, 1 pour publié)
            $table->text('Type')->nullable(); // Type du produit
             
            $table->timestamps();
    
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');    
            $table->foreign('attribut_id')->references('id')->on('attributs')->onDelete('cascade');    
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
