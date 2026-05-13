<?php

namespace App\Models;
use App\Models\Category;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category_id',
        'price',
        'description',
        'status',
        'created_by',
    ];

    // Product belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}