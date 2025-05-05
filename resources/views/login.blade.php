@extends('layouts.main')

@push('title')
<title>Login</title>
@endpush

@section('content')
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary"><i class="fa-solid fa-user"></i> User Login</h1>
</div>

<section>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                        <img src="{{asset('assets/images/register.jpg')}}" class="rounded-3 img-fluid">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            {{-- <form action="{{ route('send.otp') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                <div  class="form-text mb-2">Please enter your mobile number</div>
                                    <input type="tel" name="mobile" class="form-control form-control-lg" placeholder="+91">
                                </div>

                                <button class="btn theme-orange-btn text-light form-control form-control-lg" type="submit">Send OTP</button>
                                 <a href="{{url('login1')}}" type="btn" class="btn theme-orange-btn text-light form-control form-control-lg">Request OTP</a>
                                <div class="text-center p-5 my-5">Don't have an account? <a href="{{url('register')}}" class="text-decoration-none">Signup</a></div>
                            </form> --}}
                            <form action="{{ route('send.otp') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-text mb-2">Please enter your email address</div>
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="you@example.com" required>
                                </div>

                                <button class="btn theme-orange-btn text-light form-control form-control-lg" type="submit">Send OTP</button>

                                <div class="text-center p-5 my-5">
                                    Don't have an account?
                                    <a href="{{ url('register') }}" class="text-decoration-none">Signup</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
