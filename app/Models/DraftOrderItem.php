<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'draft_order_id',
        'product_name',
        'product_price',
        'quantity',
        'product_image',
        'description',
        'status'
    ];

    public function draftOrder()
    {
        return $this->belongsTo(DraftOrder::class);
    }
}
