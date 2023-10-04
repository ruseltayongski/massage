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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("owner_id");
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->string("type")->nullable(); //monthly yearly
            $table->decimal("amount_paid", 20, 2)->nullable();
            $table->text('payment_proof')->nullable();
            $table->text('owner_signature')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('active_date')->nullable();
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
        Schema::dropIfExists('contracts');
    }
};
