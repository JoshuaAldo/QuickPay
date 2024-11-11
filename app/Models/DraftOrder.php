<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(DraftOrderItem::class,);
    }
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
