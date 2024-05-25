<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'size_id';
    protected $fillable = [
        'size_name',
        'size_code',
    ];
}