<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'item_name',
        'quantity',
        'transaction_date',
        'payment_method',
        'item_category',
        'price',
        'total_price'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
