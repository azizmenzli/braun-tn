<?php
 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;
 
 class CreateSlidesTable extends Migration
 {
     public function up()
     {
         Schema::create('slides', function (Blueprint $table) {
             $table->id();
             $table->string('title');
             $table->string('line1');
             $table->string('line2')->nullable();
             $table->string('image_path');
             $table->string('type')->nullable();
             $table->timestamps();
         });
     }
 
     public function down()
     {
         Schema::dropIfExists('slides');
     }
 }
 