@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<!-- Begin Login Content Area -->
<div class="page-section mt-50 mb-50">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6" style="background-image: url({{ url("/assets/images/blog-banner/large-size/1.jpg") }}); background-position: right">
            </div>
            <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6">
                <!-- Login Form s-->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Login</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input minlength="5" maxlength="100" id="email" type="email" class="mb-0 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12 mb-20">
                                <label for="password">{{ __('Password') }}</label>
                                <input minlength="8" id="password" type="password" class="mb-0 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-12" style="display: flex; align-items: center; gap: 1em">
                                <button class="register-button mt-0">Login</button>
                                <a href="{{ url('/register') }}" style="color: rgb(51, 102, 187)">Don't you have an account yet? Register</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
            
@endsection