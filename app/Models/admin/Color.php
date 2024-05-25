<?php
// app/Models/Color.php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'color_id';
    protected $fillable = [
        'color_name',
        'color_code',
    ];
}