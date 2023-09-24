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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('spa_id');
            $table->bigInteger('services_id');
            $table->bigInteger('therapist_id');
            $table->string('booking_type')->nullable();// home or onsite
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('status')->nullable();
            //payment
            $table->decimal('amount_paid', 8, 2)->nullable();
            $table->string('payment_method')->nullable();
            //receipt
            $table->string('receipt_number')->nullable(); //00001
            $table->decimal('total_amount', 8, 2)->nullable();
            $table->decimal('tax_amount', 8, 2)->nullable();
            //
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
        Schema::dropIfExists('bookings');
    }
};
