<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){
        // Fetch categories with subcategories
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        $top_product = Product::where('is_top', true)->take(10)->get();
        return view('home', compact('categories','top_product'));
    }
}
