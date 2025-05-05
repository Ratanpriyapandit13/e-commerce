<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function signup(){
        return view('vendor/signup');
    }


    public function login(){
        return view('vendor/login');
    }

    public function forget(){
        return view('vendor/forget');
    }

    public function index(){
        return view('vendor/index');
    }

    public function addproduct(){
        $categories = Category::all();
        return view('vendor/add-product', compact('categories'));
    }

    public function viewproduct(){
        $products = Product::all();
        return view('vendor/view-product', compact('products'));
    }

    public function editproduct($id){
        $product = Product::findOrFail($id);
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        return view('vendor/edit-product', compact('product','categories'));
    }

    public function orders(){
        return view('vendor/orders');
    }

    public function orderdetail(){
        return view('vendor/order-detail');
    }

    public function users(){
        return view('vendor/users');
    }

    public function profile(){
        return view('vendor/profile');
    }

    public function addcategory(){
        $categories = Category::whereNull('parent_id')->get();
        return view('vendor/add-category', compact('categories'));
    }

    public function viewCategory(){
        $categories = Category::all();
        return view('vendor/category', compact('categories'));
    }

    public function storeCategory(Request $request){

        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('vendor/view-category')->with('success', 'Category added successfully.');
    }
}
