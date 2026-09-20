<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtPayment extends Model
{
    protected $fillable = [
        'sale_id',
        'user_id',
        'payment_amount',
        'payment_date',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'payment_amount' => 'decimal:2',
            'payment_date' => 'date',
        ];
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
