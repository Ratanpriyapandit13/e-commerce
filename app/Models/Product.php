<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'image','is_top'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // public function subcategory()
    // {
    //     return $this->belongsTo(Category::class, 'category_id')->whereNotNull('parent_id');
    // }
}
