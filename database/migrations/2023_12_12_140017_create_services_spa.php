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
        Schema::create('services_spa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spa_id');
            $table->unsignedBigInteger('services_id');
            $table->timestamps();

            $table->foreign('spa_id')->references('id')->on('spa')->onDelete('cascade');
            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_services');
    }
};
