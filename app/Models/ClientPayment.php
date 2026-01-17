<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPayment extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_id',
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

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
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
            if ($payment->invoice_id) {
                $invoice = $payment->invoice;
                $totalPaid = ClientPayment::where('invoice_id', $payment->invoice_id)->sum('amount_base');
                $invoice->amount_paid = $totalPaid;
                $invoice->amount_due = $invoice->total_amount_base - $totalPaid;
                $invoice->status = $invoice->amount_due <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'draft');
                $invoice->saveQuietly();
            }
        });
    }
}
