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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->after('airline_id')->constrained();
            $table->foreignId('client_id')->nullable()->after('client_name')->constrained();
            $table->foreignId('supplier_id')->nullable()->after('client_id')->constrained();
            
            // Base currency equivalents
            $table->decimal('supplier_price_base', 15, 2)->nullable()->after('supplier_price');
            $table->decimal('total_amount_base', 15, 2)->nullable()->after('total_amount');
            
            // Payment tracking
            $table->decimal('amount_paid', 15, 2)->default(0)->after('total_amount_base');
            $table->decimal('amount_due', 15, 2)->default(0)->after('amount_paid');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid')->after('status');
            
            // Supplier payment tracking
            $table->decimal('supplier_paid', 15, 2)->default(0)->after('amount_due');
            $table->decimal('supplier_due', 15, 2)->default(0)->after('supplier_paid');
            $table->enum('supplier_payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid')->after('supplier_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['client_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropColumn([
                'currency_id', 'client_id', 'supplier_id',
                'supplier_price_base', 'total_amount_base',
                'amount_paid', 'amount_due', 'payment_status',
                'supplier_paid', 'supplier_due', 'supplier_payment_status'
            ]);
        });
    }
};
