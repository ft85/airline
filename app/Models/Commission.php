<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $fillable = [
        'ticket_id',
        'airline_id',
        'user_id',
        'commission_percentage',
        'commission_amount',
        'supplier_amount',
        'company_amount',
        'commission_date'
    ];

    protected $casts = [
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'supplier_amount' => 'decimal:2',
        'company_amount' => 'decimal:2',
        'commission_date' => 'date'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
