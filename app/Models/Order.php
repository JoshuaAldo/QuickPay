<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'order_date',
        'payment_method',
        'payment_amount',
        'cash_amount',
        'qr_amount',
        'settlement_status',
        'payment_reference',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
