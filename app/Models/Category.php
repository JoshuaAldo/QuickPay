<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $fillable = ['category_name', 'capital', 'total_stock'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
