<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    use HasFactory;
       // Specify the name of the "created at" column
    const CREATED_AT = 'created_at';

    // Disable the automatic management of the "updated at" column
    const UPDATED_AT = null;

    protected $fillable = ['item_id', 'file_path'];

    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }
}
