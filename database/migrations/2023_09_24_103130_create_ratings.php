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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('spa_id')->nullable();
            $table->bigInteger('therapist_id')->nullable();
            $table->bigInteger('feedback_by')->nullable();
            $table->text('feedback')->nullable();
            $table->text('therapist_feedback')->nullable();
            $table->bigInteger('rate');
            $table->boolean("is_deleted")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
