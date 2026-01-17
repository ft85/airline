<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
        'notes',
        'credit_limit',
        'is_active'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ClientPayment::class);
    }

    public function getTotalOwedAttribute()
    {
        return $this->invoices()->sum('amount_due');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount_base');
    }
}
