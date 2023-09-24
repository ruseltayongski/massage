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
        Schema::create('spa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('picture')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spa');
    }
};
