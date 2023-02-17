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
            <div class="col-sm-6 col-md-6 col-xs-6 col-lg-6" style="background-image: url({{ url("/assets/images/blog-banner/large-size/3.jpg") }}); background-size: cover; background-position: right">
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Register</h4>
                        <div class="row">
                            <div class="col-md-12 mb-20">
                                <label for="name">{{ __('Name') }}</label>
                                <input minlength="3" id="name" type="text" class="mb-0 form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-20">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input minlength="5" maxlength="100" id="email" type="email" class="mb-0 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-20">
                                <label for="password">{{ __('Password') }}</label>
                                <input minlength="8" id="password" type="password" class="mb-0 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-20">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input minlength="8" id="password-confirm" type="password" class="mb-0 form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="col-12" style="display: flex; align-items: center; gap: 1em">
                                <button type="submit" class="register-button mt-0">Register</button>
                                <a href="{{ url('/login') }}" style="color: rgb(51, 102, 187)">Really have an account? Log in</a>
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