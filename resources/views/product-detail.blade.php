@extends('layouts.main')

@push('title')
<title>Product Detail</title>
@endpush

@section('content')
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary"><i class="fa-solid fa-layer-group"></i> Product Detail</h1>
</div>

<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <img src="{{ asset('storage/' . $product->image) }}" class="rounded img-fluid">
            </div>

            <div class="col-lg-8">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div>
                        <h2>{{ $product->name }}</h2>
                        <h5  id="priceDisplay">₹ {{ number_format($product->price, 2) }}</h5>
                        <input type="hidden" id="unitPrice" value="{{ $product->price }}">

                        {{-- Ratings --}}
                        <div class="d-flex flex-row mb-3">
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="p-1 mx-2">
                                <h6>(2 Customer Reviews)</h6>
                            </div>
                        </div>

                        {{-- Quantity Selector --}}
                        <div class="d-flex flex-row align-items-center mb-3">
                            <div class="p-1"><h6>Quantity</h6></div>
                            <div class="p-1 d-flex align-items-center">
                                <button type="button" class="btn btn-secondary btn-sm rounded-start-pill" id="decreaseQty">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="text" id="quantity" name="quantity" value="1" class="mx-2 form-control text-center" style="width: 60px;" readonly>
                                <button type="button" class="btn btn-secondary btn-sm rounded-end-pill" id="increaseQty">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Description --}}
                        <p>{{ Str::limit($product->description, 200, '...') }}</p>

                        {{-- Buttons --}}
                        <div>
                            <button type="submit" class="btn theme-green-btn text-light rounded-pill me-1 px-3 py-2">Add to Cart</button>
                            {{-- <a href="{{ route('buy.now', $product->id) }}" class="btn theme-orange-btn text-light rounded-pill px-3 py-2">Buy Now</a> --}}
                        </div>
                        {{-- <div>
                            <a href="#" class="btn theme-green-btn text-light rounded-pill me-1 px-3 py-2">Add to cart</a>
                            <a href="#" class="btn theme-orange-btn text-light rounded-pill px-3 py-2">Buy Now</a>
                        </div> --}}
                    </div>
                </form>
            </div>


            <div class="my-4">
                <h2>Product Description</h2>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Related Products -->
            <div class="mb-5">
            <section>
                <div class="container">

                    <div class="d-flex">
                        <div class="flex-grow-1"><h2>Related Products</h2></div>
                        <div><a href="#" class="btn btn-sm theme-orange-btn text-light rounded-pill px-3 py-2">View All</a></div>

                        </div>
                    <div class="row theme-product">
                        @foreach($relatedProducts as $product)
                        <div class="col-lg-3">
                            <div class="card">
                                <a href="#">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title text-center">
                                        <a href="#" class="text-dark text-decoration-none">{{ $product->name }}</a>
                                    </h6>
                                    <h5 class="card-title text-center">₹ {{ number_format($product->price, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach



                    </div>
                </div>
            </section>

            </div><hr>
            <!-- Review -->
            <section>
                <h2>02 Reviews</h2>
                <div class="row mt-4">
                    <div class="col-lg-1">
                        <img src="{{asset('assets/images/review/user.png')}}" class="rounded-circle img-fluid">
                    </div>
                    <div class="col-lg-11">
                        <div>
                            <h4>John Doe</h4>
                            <div>
                                <div class="d-flex">
                                <div class="flex-grow-1"><h6>19 Dec, 2024</h6></div>
                                <div>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>

                                </div>
                            </div>
                            <p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p>
                            <div>
                            <a class="btn theme-orange-btn btn-sm text-light rounded-pill px-3 py-2">Reply</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-1 mt-4">
                        <img src="{{asset('assets/images/review/user.png')}}" class="rounded-circle img-fluid">
                    </div>
                    <div class="col-lg-11 mt-4">
                        <div>
                            <h4>Alen Musk</h4>
                            <div>
                                <div class="d-flex">
                                <div class="flex-grow-1"><h6>14 Nov, 2024</h6></div>
                                <div>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>

                                </div>
                            </div>
                            <p>Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.</p>
                            <div>
                            <a class="btn theme-orange-btn btn-sm text-light rounded-pill px-3 py-2">Reply</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Add a Review -->

            <section>
                <div class="container my-5 bg-light p-5">
                    <h2>Add a Review</h2>
                    <div class="row">
                        <div class="col-lg-12">
                            <form>
                            <div class="form-text">Rate this Product? *

                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star "></span>
                                    <span class="fa fa-star "></span>
                            </div>
                                <div class="row my-3">
                                    <div class="col-lg-6 mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="Your Name">
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                    <input type="email" class="form-control form-control-lg"  placeholder="Your Email">
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                    <textarea class="form-control form-control-lg" placeholder="Your Message" rows="4"></textarea>
                                    </div>

                                    <div>
                                    <a class="btn theme-orange-btn text-light rounded-pill px-3 py-2">Post a Comment <i class="fa-solid fa-arrow-right"></i></a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qtyInput = document.getElementById('quantity');
            const increaseBtn = document.getElementById('increaseQty');
            const decreaseBtn = document.getElementById('decreaseQty');
            const priceDisplay = document.getElementById('priceDisplay');
            const unitPrice = parseFloat(document.getElementById('unitPrice').value);

            function updatePrice() {
                const qty = parseInt(qtyInput.value);
                const total = (unitPrice * qty).toFixed(2);
                priceDisplay.textContent = '₹ ' + total;
            }

            increaseBtn.addEventListener('click', function () {
                let current = parseInt(qtyInput.value);
                qtyInput.value = current + 1;
                updatePrice();
            });

            decreaseBtn.addEventListener('click', function () {
                let current = parseInt(qtyInput.value);
                if (current > 1) {
                    qtyInput.value = current - 1;
                    updatePrice();
                }
            });

            // In case someone manually types a value (optional)
            qtyInput.addEventListener('change', updatePrice);
        });
    </script>

</section>

@endsection
