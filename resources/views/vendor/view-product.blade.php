@extends('vendor.includes.main')
@push('title')
<title>View Product</title>
@endpush

@section('content')

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <div class="card p-4 mt-4">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="d-flex">
                            <h4>View Products</h4>

                        </div>
                        <div class="mt-3">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <h5>Product</h5>
                                        </th>
                                        <th scope="col">
                                            <h5>Price</h5>
                                        </th>
                                        <th scope="col">
                                            <h5>Category</h5>
                                        </th>
                                        <th scope="col">
                                            <h5>Stock</h5>
                                        </th>
                                        <th scope="col">
                                            <h5>Description</h5>
                                        </th>
                                        <th scope="col">
                                            <h5>Action</h5>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <th>
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $product->image) }}" style="width:70px;" class="rounded-3">
                                                    </div>
                                                    <div class="p-3">
                                                        <h5>{{ $product->name }}</h5>
                                                    </div>
                                                </div>
                                            </th>
                                            <td>₹ {{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ Str::limit($product->description, 50) }}</td>
                                            <td>
                                                <a href="{{ route('vendor.edit-product', ['id' => $product->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('products.delete-product', $product->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>




    @endsection
