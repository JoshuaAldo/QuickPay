<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
    ];

    public function items()
    {
        return $this->hasMany(DraftOrderItem::class);
    }
    public $timestamps = true;
}
