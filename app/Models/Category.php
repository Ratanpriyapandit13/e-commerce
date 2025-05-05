<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description'];

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship for Parent Category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
