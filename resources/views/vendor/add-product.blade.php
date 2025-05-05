@extends('vendor.includes.main')
@push('title')
<title>Add Product</title>
@endpush

@section('content')

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card p-4 mt-4">
                <div class="row">

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-8 col-md-8">
                                <h4>Add Product</h4>
                                <div class="row mt-3">
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Product name" required>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price" class="form-control" placeholder="₹ 1499.00" required>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-select" required>
                                            <option selected disabled>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock" class="form-control" placeholder="25 pcs" required>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Product Description</label>
                                        <textarea class="form-control" name="description" placeholder="Fill product description here"
                                            id="floatingTextarea" required></textarea>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="isTop" id="isTop">
                                            <label class="form-check-label" for="isTop">
                                                Top Product
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- IMAGE UPLOAD SECTION -->
                            <div class="col-xl-4 col-md-4 mt-5">
                                <div class="text-center">
                                    <img id="previewImage" src="{{ asset('dashboard/assets/img/products/2.jpg') }}" style="width:155px;"
                                        class="rounded-circle">
                                    <div class="mt-3">
                                        <label for="image" class="form-label btn btn-dark">Choose Image</label>
                                        <input type="file" name="image" class="form-control d-none" id="image" accept="image/*" onchange="previewFile()">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-lg-12 mt-4">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

    <script>
        function previewFile() {
            var preview = document.getElementById('previewImage');
            var file = document.getElementById('image').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset('dashboard/assets/img/products/2.jpg') }}";
            }
        }
    </script>


    @endsection
