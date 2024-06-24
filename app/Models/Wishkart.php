<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Items;


class Wishkart extends Model
{
    protected $table="wishkart";
    use HasFactory;

    // public function item()
    // {
    //     return $this->belongsTo(Items::class, 'fk_item_id');
    // }
}
