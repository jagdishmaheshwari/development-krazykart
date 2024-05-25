<?php
// app/Models/Category.php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'category_name',
        'c_description',
        'c_keywords'
    ];
}