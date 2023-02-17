@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}" class="active">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<!-- content-wraper start -->
<div class="content-wraper mt-15">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
               <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images slider-navigation-1">
                        <div class="product-image" style="background-image: url(data:image/jpeg;base64,{{ $product['thumbnail'] }}); width: auto; aspect-ratio: 1/1"></div>
                        <!-- foreach -->
                        @foreach($images as $image)
                            <div class="product-image" style="background-image: url({{ asset('../storage/app/imagesProduct-' . $product->id . '/' . $image['path']) }}); width: auto; aspect-ratio: 1/1"></div>
                        @endforeach
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        <div class="product-image" style="background-image: url(data:image/jpeg;base64,{{ $product['thumbnail'] }}); width: auto; aspect-ratio: 1/1"></div>
                        <!-- foreach -->
                        @foreach($images as $image)
                            <div class="product-image" style="background-image: url({{ asset('../storage/app/imagesProduct-' . $product->id . '/' . $image['path']) }}); width: auto; aspect-ratio: 1/1"></div>
                        @endforeach
                    </div>
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content sp-normal-content pt-60">
                    <div class="product-info">
                        <div style="display: flex; justify-content: space-between">
                            <div>
                                <p style="color: black; margin: 0 0 .6em 0">| Stock&nbsp;&nbsp;<span style="font-weight: bold; color: #e80f0f">{{ $product->stock }}</span></p>
                                <h2 style="color: black">{{ $product->name }}</h2>
                            </div>
                            @if(Auth::user())
                                @if(Auth::user()->role_as == 1)
                                    <div style="display: flex; align-items: center; gap: 0.3em">
                                        <a href="{{ url('/shop/products/' . $product->id . '/edit') }}" title="Edit" data-toggle="tooltip" data-original-title='Edit'>
                                            <i class="fas fa-edit" style="font-size: 1.5em; color: green; margin: 0; transform: translateY(1px)"></i>
                                        </a>
                                        <a href="" style="transform: translateY(2.8px)" class="deleteLinkElement" data-bs-toggle="modal" 
                                        data-bs-target="#deleteElement" data-type="product"
                                        data-name="'{{ $product->name }}' <span style='font-weight: 400'>product</span>" data-url="{{ url('/shop/products/' . $product->id) }}">
                                            <button class="material-icons delete-button" style="font-size: 1.7em;">&#xE5C9;</button>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <span class="product-details-ref">@if($product->category) {{ DB::table('categories')->where('id', $product->idCat)->value('name') }} @else Uncategorized @endif</span>
                        <div class="rating-box pt-20">
                            <ul class="rating rating-with-review-item">
                                <!-- foreach -->
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li class="no-star"><i class="fa-solid fa-star"></i></li>
                                <li class="no-star"><i class="fa-solid fa-star"></i></li>
                            </ul>
                        </div>
                        <div class="price-box pt-20">
                            <span class="new-price new-price-2">{{ $product->price }}€</span>
                        </div>
                        <div class="product-desc">
                            <p style="white-space: normal; word-break: break-all;">
                                {{ $product->description }}
                            </p>
                        </div>
                        @if(Auth::user())
                            <form action="" method="POST" id="addCartForm">
                                @csrf
                            </form>
                            <div class="single-add-to-cart cart-quantity">
                                <div class="quantity">
                                    <label class="mb-2">Quantity</label>
                                    <div style="display: flex; gap: 0.5em">
                                        <input style="flex: .1" class="cart-plus-minus-box prod-qty" min="1" value="1" type="number">
                                        <button style="flex: .9" id="addToCart" class="add-to-cart" type="submit" data-exists="{{ DB::table('carts')->where([['idUser', '=', Auth::id()], ['idProduct', '=', $product->id]])->exists() }}" data-name="{{ $product->name }}" data-url="{{ url('/addCart/' . $product->id) }}" data-id="{{ $product->id }}">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="single-add-to-cart cart-quantity">
                                <div class="quantity">
                                    <div style="display: flex; gap: 0.5em">
                                        <a href="{{ url('/home') }}" style="flex: .17" id="loginToBuy" type="submit">Login To Buy</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="product-additional-info">
                            <div class="product-social-sharing">
                                <ul>
                                    <li class="facebook"><a href="https://www.linkedin.com/in/pvalgarn/" target="_blank"><i class="fa-brands fa-linkedin-in"></i>Linkedin</a></li>
                                    <li class="twitter"><a href="https://pablovalderas.com" target="_blank"><i class="fa-solid fa-globe"></i>Website</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
@if(count($relatedProducts) > 0)
    <div class="product-area pt-40">
@else
    <div class="product-area pt-40 pb-30">
@endif
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                       <li><a class="active" id="show_product" data-toggle="tab" href="#description">Description</span></a></li>
                       <li><a data-toggle="tab" id="show_product" href="#product-details"><span>Product Details</span></a></li>
                    </ul>               
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div class="tab-content">
            <div id="description" class="tab-pane active show" role="tabpanel">
                <div class="product-description">
                    <span style="color: black">{{ $product->excerpt }}</span>
                </div>
            </div>
            <div id="product-details" class="tab-pane" role="tabpanel" style="display: flex; gap: 5em">
                <div class="product-details-manufacturer">
                    <h3 style="color: black; font-weight: bold">Characteristics</h3>
                    <p><span>Brand</span>&nbsp;&nbsp;{{ ucfirst(DB::table('brands')->where('id', $product->idBrand)->value('name')) }}</p>
                    <p><span>Price</span>&nbsp;&nbsp;{{ $product->price }}</p>
                    <p><div style="display: flex; align-items: center; gap: 0.3em"><span style="color: black; font-weight: bold">Color&nbsp;&nbsp;</span><div style="background-color: {{ DB::table('colors')->where('id', $product->idColor)->value('hex') }}; width: 1em; height: 1em"></div><p style="margin: 0; color: black; transform: translateY(1.4px)">{{ ucfirst(DB::table('colors')->where('id', $product->idColor)->value('name')) }}</p></p></div>
                    <p><span>Stock</span>&nbsp;&nbsp;{{ $product->stock }}</p>
                    <p><span>Year</span>&nbsp;&nbsp;{{ $product->year }}</p>
                </div>
                <div class="product-details-manufacturer">
                    <h3 style="color: black; font-weight: bold">Others</h3>
                    <p><span>Video</span>&nbsp;&nbsp;<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley" target="_blank">https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley</a></p>
                    <p><span>Links</span>&nbsp;&nbsp;<span class="youtube"><a href="https://www.linkedin.com/in/pvalgarn/" target="_blank" style="color: white; padding: 0 0.8em"><i class="fa-brands fa-youtube"></i>&nbsp;&nbsp;Youtube</a></span>&nbsp;&nbsp;<span class="twitter"><a href="https://pablovalderas.com" target="_blank" style="color: white; padding: 0 0.8em"><i class="fa-solid fa-globe"></i>&nbsp;&nbsp;Website</a></span></p>
                    <p><a href="#">Load More Content</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->

<div class="container mt-70 mb-70">
    <div>
        <div id="disqus_thread"></div>
        <script type="application/javascript">
            var disqus_config = function () {};
            (function () {
                if (["localhost", "127.0.0.1"].indexOf(window.location.hostname) != -1) {
                    document.getElementById('disqus_thread').innerHTML = 'Disqus comments not available by default when the website is previewed locally.';
                    return;
                }
                var d = document, s = d.createElement('script'); s.async = true;
                s.src = '//' + "themefisher-template" + '.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a
                href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
        </noscript>
        <a href="https://disqus.com" class="dsq-brlink">comments powered by <span
                class="logo-disqus">Disqus</span></a>
    </div>
</div>

<!-- Begin Li's Laptop Product Area -->
@if(count($relatedProducts) > 0)
    <section class="product-area li-laptop-product pt-60 pb-0">
        <div class="container" style="height: 30em">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Related Products</span>
                        </h2>
                    </div>
                    <div class="row">
                        <div class="mostPopular">
                            @foreach($relatedProducts as $products)
                                @if($products->id != $product->id)
                                    <div>
                                        <!-- single-product-wrap start -->
                                        <div class="single-product-wrap">
                                            <div class="product-image">
                                                <a href="{{ url('/shop/products/' . $products->id) }}">
                                                    <div class="product-image" style="background-image: url(data:image/jpeg;base64,{{ $products->thumbnail }}); width: 15em; height: 10em;"></div>
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
                                                    <h4 style="display: flex; justify-content: space-between; align-items: center"><a class="product_name" href="{{ url('/shop/products/' . $products->id) }}">{{ $products->name }}</a><p style="color: black; margin: 0; font-size: 0.55em"><span @if($products->stock < 30) style="color: #e80f0f" @endif>{{ $products->stock }}</span></p></h4>
                                                    <div class="price-box mt-1">
                                                        <span class="new-price">{{ $products->price }}€</span>
                                                    </div>
                                                </div>
                                                @if(Auth::user())
                                                    <div class="add-actions">
                                                        <ul class="add-actions-link" style="display: flex; margin-top: 0; padding-top: 0">
                                                            <li class="add-cart active" style="flex: 1"><a href="{{ url('/shop/products/' . $products->id) }}">Add to cart</a></li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- single-product-wrap end -->
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>
@endif
            
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection