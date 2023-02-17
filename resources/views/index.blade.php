@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}" class="active">Home</a></li>
<li><a href="{{ url('/shop') }}">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<!-- Header Area End Here -->
<!-- Begin Slider With Banner Area -->
<div class="slider-with-banner pt-20">
    <div class="container">
        <div class="row">
            <!-- Begin Slider Area -->
            <div class="col-lg-12 col-md-12">
                <div class="slider-area">
                    <div class="slider-active owl-carousel">
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left animation-style-01 bg-image bg-1" style="background-image: url({{ url('/assets/images/slider/1.jpg') }})">
                            <div class="slider-progress"></div>
                            <div class="slider-content">
                                <h2>Chamcham Galaxy S9 | S9+</h2>
                                <h3>Starting at <span>$1209.00</span></h3>
                                <div class="default-btn slide-btn">
                                    <a class="links">Shopping Now</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Slide Area End Here -->
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left animation-style-02 bg-image bg-2" style="background-image: url({{ url('/assets/images/slider/2.jpg') }})">
                            <div class="slider-progress"></div>
                            <div class="slider-content">
                                <h2>Work Desk Surface Studio 2018</h2>
                                <h3>Starting at <span>$824.00</span></h3>
                                <div class="default-btn slide-btn">
                                    <a class="links">Shopping Now</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Slide Area End Here -->
                        <!-- Begin Single Slide Area -->
                        <div class="single-slide align-center-left animation-style-01 bg-image bg-3" style="background-image: url({{ url('/assets/images/slider/3.jpg') }})">
                            <div class="slider-progress"></div>
                            <div class="slider-content">
                                <h2>Phantom 4 Pro+ Obsidian</h2>
                                <h3>Starting at <span>$1849.00</span></h3>
                                <div class="default-btn slide-btn">
                                    <a class="links">Shopping Now</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Slide Area End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Begin Li's Laptop Product Area -->
<section class="product-area li-laptop-product pt-60 pb-0">
    <div class="container" style="height: 30em">
        <div class="row">
            <!-- Begin Li's Section Area -->
            <div class="col-lg-12">
                <div class="li-section-title mb-20">
                    <h2>
                        <span>Latest Products</span>
                    </h2>
                </div>
                <div class="row">
                    <div class="mostPopular">
                        @foreach($latestProducts as $product)
                            <div>
                                <!-- single-product-wrap start -->
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ url('/shop/products/' . $product['id']) }}">
                                            <div class="product-image" style="background-image: url(data:image/jpeg;base64,{{ $product['thumbnail'] }}); width: 15em; height: 10em;"></div>
                                        </a>
                                    </div>
                                    <div class="product_desc" style="height: 5em">
                                        <div class="product_desc_info">
                                            <div class="product-review" style="display: flex; justify-content: space-between;">
                                                <h5 class="manufacturer">
                                                    <a href="shop-left-sidebar.html">
                                                        @if($product->idCat != null)
                                                            {{ DB::table('categories')->select('name')->where('id', $product->idCat)->value('name') }}
                                                        @else
                                                            Uncategorized 
                                                        @endif
                                                    </a>
                                                </h5>
                                                <div class="rating-box">
                                                    <!-- foreach -->
                                                    <ul class="rating">
                                                        @php
                                                            $starsRand = rand(1, 5);
                                                            $cont = 1;
                                                        @endphp
                                                        @while($cont <= $starsRand)
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            @php $cont++; @endphp
                                                        @endwhile
                                                        @if($cont <= 5)
                                                            @while($cont <= 5)
                                                                <li class="no-star"><i class="fa-solid fa-star"></i></li>
                                                                @php $cont++; @endphp
                                                            @endwhile
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <h4 style="display: flex; justify-content: space-between; align-items: center"><a class="product_name" href="{{ url('/shop/products/' . $product['id']) }}">{{ $product['name'] }}</a><p style="color: black; margin: 0; font-size: 0.55em"><span @if($product->stock < 30) style="color: #e80f0f" @endif>{{ $product->stock }}</span></p></h4>
                                            <div class="price-box mt-1">
                                                <span class="new-price">{{ $product['price'] }}€</span>
                                            </div>
                                        </div>
                                        @if(Auth::user())
                                            <div class="add-actions">
                                                <ul class="add-actions-link" style="display: flex; margin-top: 0; padding-top: 0">
                                                    <li class="add-cart active" style="flex: 1"><a href="{{ url('/shop/products/' . $product->id) }}">Add to cart</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- single-product-wrap end -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Li's Section Area End Here -->
        </div>
    </div>
</section>

@endsection