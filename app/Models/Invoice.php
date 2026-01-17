<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'ticket_id',
        'currency_id',
        'client_id',
        'user_id',
        'client_name',
        'total_amount',
        'total_amount_base',
        'amount_paid',
        'amount_due',
        'invoice_date',
        'due_date',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'total_amount_base' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_due' => 'decimal:2',
        'invoice_date' => 'date',
        'due_date' => 'date'
    ];

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

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ClientPayment::class);
    }

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_number, 3)) + 1 : 1;
        return 'INV' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
