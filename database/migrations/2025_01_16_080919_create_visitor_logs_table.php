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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('os')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('referer')->nullable();
            $table->string('visited_page')->nullable();
            $table->timestamp('visit_time')->useCurrent();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
