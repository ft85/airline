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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('travel_date');
            $table->string('pnr_number');
            $table->string('ticket_number');
            $table->string('passenger_name');
            $table->string('routing');
            $table->enum('trip_type', ['one_way', 'return']);
            $table->string('departure_airport', 3);
            $table->string('arrival_airport', 3);
            $table->string('return_airport', 3)->nullable();
            $table->decimal('supplier_price', 10, 2);
            $table->decimal('service_fee', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('company_amount', 10, 2);
            $table->string('client_name');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
