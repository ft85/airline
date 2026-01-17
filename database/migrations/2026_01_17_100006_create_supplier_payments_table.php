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
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->foreignId('ticket_id')->nullable()->constrained(); // Link to ticket if applicable
            $table->foreignId('user_id')->constrained(); // Who recorded it
            $table->foreignId('currency_id')->constrained();
            $table->date('payment_date');
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_base', 15, 2); // Amount in base currency
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money', 'credit_card', 'check'])->default('bank_transfer');
            $table->string('reference')->nullable(); // Transaction reference
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
