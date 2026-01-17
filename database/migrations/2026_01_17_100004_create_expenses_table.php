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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_category_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Who recorded it
            $table->foreignId('currency_id')->constrained();
            $table->date('expense_date');
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->decimal('amount_base', 15, 2); // Amount in base currency
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money', 'credit_card', 'check'])->default('cash');
            $table->string('reference')->nullable(); // Receipt/reference number
            $table->string('vendor')->nullable(); // Who was paid
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
