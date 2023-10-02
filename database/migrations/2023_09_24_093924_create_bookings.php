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
            $table->bigInteger('client_id');
            $table->bigInteger('spa_id');
            $table->bigInteger('service_id');
            $table->bigInteger('therapist_id');
            $table->string('booking_type')->nullable();// home or onsite
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->string('status')->nullable();
            //payment
            $table->decimal('amount_paid', 20, 2)->nullable();
            $table->string('payment_picture')->nullable();
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
