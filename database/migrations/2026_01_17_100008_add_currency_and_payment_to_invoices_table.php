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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->after('ticket_id')->constrained();
            $table->foreignId('client_id')->nullable()->after('client_name')->constrained();
            
            // Base currency equivalent
            $table->decimal('total_amount_base', 15, 2)->nullable()->after('total_amount');
            
            // Payment tracking
            $table->decimal('amount_paid', 15, 2)->default(0)->after('total_amount_base');
            $table->decimal('amount_due', 15, 2)->default(0)->after('amount_paid');
            $table->date('due_date')->nullable()->after('invoice_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['client_id']);
            $table->dropColumn([
                'currency_id', 'client_id',
                'total_amount_base', 'amount_paid', 'amount_due', 'due_date'
            ]);
        });
    }
};
