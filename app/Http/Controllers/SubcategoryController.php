<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function detail($categorySlug, $subcategorySlug)
    {
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        // Fetch category
        $category = Category::where('name', $categorySlug)->firstOrFail();

        // Fetch subcategory under that category
        $subcategory = Category::where('name', $subcategorySlug)
            ->where('parent_id', $category->id)
            ->firstOrFail();

        // Fetch products under this subcategory
        $products = Product::where('category_id', $subcategory->id)->with('category.parent')->get();
        return view('subcategory', compact('categories', 'products'));
    }

}
