<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'expense_category_id',
        'user_id',
        'currency_id',
        'expense_date',
        'description',
        'amount',
        'amount_base',
        'payment_method',
        'reference',
        'vendor',
        'notes'
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'amount_base' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
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

        static::saving(function ($expense) {
            if ($expense->currency_id && $expense->amount) {
                $currency = Currency::find($expense->currency_id);
                if ($currency) {
                    $expense->amount_base = $currency->convertToBase($expense->amount);
                }
            }
        });
    }
}
