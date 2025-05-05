@extends('layouts.main')

@push('title')
<title>Sub-Category</title>
@endpush

@section('content')
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary"><i class="fa-solid fa-list"></i> Sub-Category</h1>
</div>

<!-- Products -->

<section class="my-5">
    <div class="container">

        <div class="row theme-product">
            @forelse($products as $product)
                <div class="col-lg-3 mb-4">
                    <div class="card h-100">
                        <a href="{{ url('product/' . $product->id ) }}">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/register.jpg') }}"
                                 class="card-img-top"
                                 style="height: 180px; width: 100%; object-fit: cover;"
                                 alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title text-center">
                                <a href="{{url('product/' . $product->id)  }}"
                                   class="text-dark text-decoration-none">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <h5 class="card-title text-center">₹ {{ number_format($product->price, 2) }}</h5>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No products found.</p>
            @endforelse
        </div>

    </div>
</section>
@endsection
