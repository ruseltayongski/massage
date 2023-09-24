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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('complainant_id')->nullable();
            $table->bigInteget('client_id')->nullable();
            $table->bigInteger('therapist_id')->nullable();
            $table->bigInteger('spa_id')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('complaints');
    }
};
