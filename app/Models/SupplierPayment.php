<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierPayment extends Model
{
    protected $fillable = [
        'supplier_id',
        'ticket_id',
        'user_id',
        'currency_id',
        'payment_date',
        'amount',
        'amount_base',
        'payment_method',
        'reference',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'amount_base' => 'decimal:2'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($payment) {
            if ($payment->currency_id && $payment->amount) {
                $currency = Currency::find($payment->currency_id);
                if ($currency) {
                    $payment->amount_base = $currency->convertToBase($payment->amount);
                }
            }
        });

        static::saved(function ($payment) {
            if ($payment->ticket_id) {
                $ticket = $payment->ticket;
                $totalPaid = SupplierPayment::where('ticket_id', $payment->ticket_id)->sum('amount_base');
                $ticket->supplier_paid = $totalPaid;
                $ticket->supplier_due = $ticket->supplier_price_base - $totalPaid;
                $ticket->supplier_payment_status = $ticket->supplier_due <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');
                $ticket->saveQuietly();
            }
        });
    }
}
