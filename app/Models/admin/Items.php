<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ItemImage;

class Items extends Model
{
    use HasFactory;
    public $primaryKey = "item_id";
    // public function item_images(): HasMany
    // {
    //     return $this->hasMany(ItemImage::class);
    // }
}
