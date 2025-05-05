@extends('vendor.includes.main')
@push('title')
<title>Edit Product</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card p-4 mt-4">
                <div class="row">
                    <div class="col-xl-8 col-md-8">
                        <h4>Edit Product</h4>

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control" value="{{ $product->price }}"
                                    required>
                            </div>

                            {{-- <div class="mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @foreach($category->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $product->category_id == $subcategory->id ? 'selected' : '' }}>
                                                --- {{ $subcategory->name }} ---
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label>Stock</label>
                                <input type="text" name="stock" class="form-control" value="{{ $product->stock }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="isTop">Top Product</label>
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="is_top"
                                       id="isTop"
                                       {{  isset($product) && $product->is_top ? 'checked' : '' }}>
                            </div>


                            <div class="mb-3">
                                <label>Current Image</label><br>
                                <img src="{{ asset('storage/' . $product->image) }}" width="100"
                                    alt="Product Image">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </form>
                    </div>

                    <!-- Image Preview Section -->
                    <div class="col-xl-4 col-md-4 mt-5">
                        <div class="text-center">
                            <img id="previewImage" src="{{ asset('storage/' . $product->image) }}"
                                style="width:155px;" class="rounded-circle">
                            <div class="mt-3">
                                <label for="image" class="form-label btn btn-dark">Choose Image</label>
                                <input type="file" name="image" class="form-control d-none" id="image" accept="image/*"
                                    onchange="previewFile()">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </main>
    @push('scripts')
    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
</div>
@endsection

