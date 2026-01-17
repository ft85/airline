<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'airline_id',
        'user_id',
        'currency_id',
        'client_id',
        'supplier_id',
        'travel_date',
        'pnr_number',
        'ticket_number',
        'passenger_name',
        'routing',
        'trip_type',
        'departure_airport',
        'arrival_airport',
        'return_airport',
        'supplier_price',
        'supplier_price_base',
        'service_fee',
        'total_amount',
        'total_amount_base',
        'commission_amount',
        'company_amount',
        'client_name',
        'status',
        'payment_status',
        'amount_paid',
        'amount_due',
        'supplier_paid',
        'supplier_due',
        'supplier_payment_status'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'supplier_price' => 'decimal:2',
        'supplier_price_base' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'total_amount_base' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'company_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_due' => 'decimal:2',
        'supplier_paid' => 'decimal:2',
        'supplier_due' => 'decimal:2'
    ];

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
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

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function supplierPayments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function calculateTotals()
    {
        $this->total_amount = $this->supplier_price + $this->service_fee;
        $this->commission_amount = ($this->supplier_price * $this->airline->commission_percentage) / 100;
        $this->company_amount = $this->service_fee + $this->commission_amount;
    }
}
