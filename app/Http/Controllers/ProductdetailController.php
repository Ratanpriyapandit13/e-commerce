<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductdetailController extends Controller
{
    public function detail($slug)
    {
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        $product = Product::where('id', $slug)->firstOrFail();

        // Get the category of the product
        $category = $product->category;

        // If it's a parent category, get all products from subcategories
        if ($category->parent_id === null) {
            $subcategoryIds = $category->subcategories->pluck('id');
            $relatedProducts = Product::whereIn('category_id', $subcategoryIds)->get();
        } else {
            // If it's a subcategory, get all products under this subcategory
            $relatedProducts = Product::where('category_id', $category->id)->get();
        }

        return view('product-detail', compact('categories', 'product','relatedProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_top'       => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Create the uploads directory if it doesn't exist
        // $uploadPath = public_path('uploads/products');
        // if (!file_exists($uploadPath)) {
        //     mkdir($uploadPath, 0755, true);
        // }
        // // Store the image
        // if ($request->file('image')) {
        //     $imageName = time() . '.' . $request->image->extension();
        //     $request->image->move($uploadPath, $imageName);

        //     $data['image'] = $imageName;
        // }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Handle checkbox for top product
        $data['is_top'] = $request->boolean('isTop');

        Product::create($data);

        return redirect()->route('vendor.index')->with('success', 'Product created successfully');
    }

    public function storeCategory(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->is_top = $request->has('is_top');


        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
            }

            // Store new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('vendor.index')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete product image if exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('vendor.index')->with('success', 'Product deleted successfully!');
    }
}
