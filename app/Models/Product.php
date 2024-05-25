<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'fk_category_id',
        'product_code',
        'product_name',
        'p_description',
    ];

    // Optional: Define relationship to Category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'fk_category_id');
    }
}
