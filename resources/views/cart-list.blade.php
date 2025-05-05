@extends('layouts.main')

@push('title')
    <title>Cart List</title>
@endpush

@section('content')
    <div class="container-fluid bg-light p-5">
        <h1 class="text-center text-secondary"><i class="fa-solid fa-cart-shopping"></i> Cart List</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Cart List -->
    <section>
        <div class="container">
            <div class="row my-5">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <h4>Product</h4>
                                </th>
                                <th scope="col">
                                    <h4>Price</h4>
                                </th>
                                <th scope="col">
                                    <h4>Quantity</h4>
                                </th>
                                <th scope="col">
                                    <h4>Subtotal</h4>
                                </th>
                                <th scope="col">
                                    <h4>Remove</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <th>
                                        <div class="d-flex">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('assets/images/register.jpg') }}"
                                                style="width:70px;" class="rounded-3">
                                            <div class="p-3">
                                                <h5>{{ $item->product->name }}</h5>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        <h5 id="priceDisplay-{{ $item->id }}">₹ {{ number_format($item->price, 2) }}
                                        </h5>
                                        <input type="hidden" id="unitPrice-{{ $item->id }}"
                                            value="{{ $item->price }}">
                                    </td>
                                    <td>
                                        <div class="p-1 d-flex align-items-center">
                                            <button type="button"
                                                class="btn btn-secondary btn-sm rounded-start-pill qty-btn"
                                                data-id="{{ $item->id }}" data-action="decrease">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <input type="text" id="quantity-{{ $item->id }}" name="quantity"
                                                value="{{ $item->quantity }}" class="mx-2 form-control text-center"
                                                style="width: 60px;" readonly>
                                            <button type="button" class="btn btn-secondary btn-sm rounded-end-pill qty-btn"
                                                data-id="{{ $item->id }}" data-action="increase">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 id="subtotal-{{ $item->id }}">₹
                                            {{ number_format($item->price * $item->quantity, 2) }}</h5>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Remove this item from cart?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-close" aria-label="Close"></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-lg-5 ms-auto my-5">
                    <div>
                        <h3>Price Details</h3>
                        <hr>
                    </div>
                    <div class="d-flex">
                        <div>
                            <h5>Subtotal</h5>
                        </div>
                        <div class="ms-auto">
                            <h5 id="cart-subtotal">₹
                                {{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}
                            </h5>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div>
                            <h5>Delivery Charges</h5>
                        </div>
                        <div class="ms-auto">
                            <h5 id="delivery-charge">Free</h5>
                        </div>
                    </div>
                    <hr>

                    <div class="d-flex">
                        <div>
                            <h4>Total</h4>
                        </div>
                        <div class="ms-auto">
                            <h5 id="cart-total">₹
                                {{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{-- <a href="{{ url('checkout/product') }}"
                        class="btn theme-orange-btn text-light rounded-pill w-100 px-3 py-2">
                        Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                    </a> --}}
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn theme-orange-btn text-light rounded-pill w-100 px-3 py-2">
                                Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

       <script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyButtons = document.querySelectorAll('.qty-btn');

        function updateCartTotals() {
            let subtotal = 0;

            document.querySelectorAll('input[id^="quantity-"]').forEach(input => {
                const id = input.id.split('-')[1];
                const quantity = parseInt(input.value);
                const unitPrice = parseFloat(document.getElementById('unitPrice-' + id).value);
                subtotal += quantity * unitPrice;
            });

            document.getElementById('cart-subtotal').textContent = '₹ ' + subtotal.toFixed(2);
            document.getElementById('cart-total').textContent = '₹ ' + subtotal.toFixed(2); // Add delivery charge here if needed
        }

        qtyButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const action = this.dataset.action;

                const qtyInput = document.getElementById('quantity-' + id);
                const unitPrice = parseFloat(document.getElementById('unitPrice-' + id).value);
                const priceDisplay = document.getElementById('priceDisplay-' + id);
                const subtotalDisplay = document.getElementById('subtotal-' + id);

                let quantity = parseInt(qtyInput.value);
                if (action === 'increase') {
                    quantity++;
                } else if (action === 'decrease' && quantity > 1) {
                    quantity--;
                }

                qtyInput.value = quantity;
                const total = (unitPrice * quantity).toFixed(2);

                priceDisplay.textContent = '₹ ' + total;
                subtotalDisplay.textContent = '₹ ' + total;

                updateCartTotals();

                // 🔁 Send quantity update to backend
                fetch(`/cart/update-quantity/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ quantity: quantity }),
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Quantity updated:', data);
                });
            });
        });
    });
</script>


    </section>
@endsection
