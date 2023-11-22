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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('roles')->nullable();
            $table->bigInteger("owner_id")->nullable();
            $table->bigInteger("spa_id")->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->text('picture')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('booking_status')->nullable();
            $table->string('status')->nullable();
            $table->string("contract_type")->nullable();
            $table->date("contract_end")->nullable();
            $table->smallInteger('ftl')->nullable(); //first time login
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
        Schema::dropIfExists('users');
    }
};
