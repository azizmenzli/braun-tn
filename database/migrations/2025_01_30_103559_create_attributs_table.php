<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributsTable extends Migration
{
    public function up()
    {
        Schema::create('attributs', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom de l'attribut
            $table->text('value'); // Stocke les valeurs séparées par des virgules (change 'string' en 'text')
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attributs');
    }
}
