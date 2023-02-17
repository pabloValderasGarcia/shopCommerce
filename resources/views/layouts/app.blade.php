<!doctype html>
<html class="no-js" lang="zxx" style="overflow-y: hidden">
    
<!-- index28:48-->
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Home - Shop 2023 | Pablo N. Valderas</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ url("/assets/images/favicon.png") }}">
        <!-- Material Design Iconic Font-V2.2.0 -->
        <link rel="stylesheet" href="{{ url("/assets/css/material-design-iconic-font.min.css") }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/meanmenu.css") }}">
        <!-- owl carousel CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/owl.carousel.min.css") }}">
        <!-- Slick Carousel CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/slick.css") }}">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/animate.css") }}">
        <!-- Jquery-ui CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/jquery-ui.min.css") }}">
        <!-- Venobox CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/venobox.css") }}">
        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/nice-select.css") }}">
        <!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/magnific-popup.css") }}">
        <!-- Bootstrap V4.1.3 Fremwork CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <!-- Helper CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/helper.css") }}">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/style.css") }}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ url("/assets/css/responsive.css") }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <!-- LOADER -->
        <div class="loader-container">
            <div class="loader"></div>
        </div>
        
        <!-- DELETE MODAL -->
        <div class="modal fade" id="deleteElement" role="dialog" style="padding-right: 0">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action method="post" id="deleteFormElement">
                        @csrf
                        @method('delete')
                        <div class="modal-header d-flex align-items-center">
                            <h6 class="modal-title mb-0" id="threadModalLabel" style="font-weight: 400">Delete <b id="deleteElementType"></b></h6>
                            <button type="button" class="close" style="background-color: transparent; border: none; font-size: 1.5em" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="name">Are you sure to delete <b id="deleteElementName"></b>?</label>
                            <div class="modal-footer" style="padding: 0; padding-top: 1em; display: flex; gap: 0.5em">
                                <a type="button" class="btn btn-danger bg-danger text-white" data-bs-dismiss="modal" aria-label="Close" style="flex: .2; margin: 0; border: 0; border-radius: 0">Cancel</a>
                                <button id="deleteElementTypeInput" type="submit" class="btn btn-primary bg-success" style="flex: .8; margin: 0; border: 0; border-radius: 0">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="body-wrapper">
            <header>
                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="header-top-left">
                                    <ul class="phone-wrap">
                                        <li><span>Telephone Enquiry:</span><a href="#">&nbsp;&nbsp;(+34) 727 733 353</a></li>
                                    </ul>
                                </div>
                            </div>
                            @if(Auth::user())
                                <div class="col-lg-9 col-md-8">
                                    <div class="header-top-right">
                                        <ul class="ht-menu">
                                            <li>
                                                <div class="ht-setting-trigger"><span>{{ Auth::user()->name }} </span></div>
                                                <div class="setting ht-setting">
                                                    <ul class="ht-setting-list">
                                                        @if(Auth::user()->role_as == '1')
                                                            <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                                                        @endif
                                                        <li>
                                                            <a href="{{ url('/home') }}">
                                                                <form action="{{ url('/logout') }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" style="all: unset">Log out&nbsp;&nbsp;&nbsp;<i class="fa fa-sign-out"></i></button>
                                                                </form>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-9 col-md-8">
                                    <div class="header-top-right">
                                        <ul class="ht-menu">
                                            <li>
                                                <a href="{{ url('/login') }}" style="color: black">Log in&nbsp;&nbsp;<i class="fa fa-sign-in"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="logo pb-sm-30 pb-xs-30">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ url("/assets/images/menu/logo/1.jpg") }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-10 pl-0 ml-sm-15 ml-xs-15">
                                @if(Auth::user())
                                <form action="{{ url('/shop') }}" class="hm-searchbox">
                                @else
                                <form action="{{ url('/shop') }}" class="hm-searchbox" style="width: 100%">
                                @endif
                                    <select class="nice-select select-search-category" onchange="location = this.value;">
                                        <option disabled selected>Choose...</option> 
                                        @php
                                            use App\Models\Category;
                                            use App\Models\Cart;
                                            $categories = Category::all();
                                        @endphp
                                        @foreach($categories as $category)
                                            <option value="{{ url('/shop?category-' . $category->id . '=on') }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="search" name="q" placeholder="Enter your search key ..." value="{{ $q ?? '' }}" aria-label="Search" aria-describedby="search-addon"/>
                                    <input type="hidden" name="orderby" value="{{ $orderby ?? '' }}"/>
                                    <input type="hidden" name="ordertype" value="{{ $ordertype ?? '' }}"/>
                                    <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                                <!-- Header Middle Searchbox Area End Here -->
                                @if(Auth::user())
                                    <!-- Begin Header Middle Right Area -->
                                    <div class="header-middle-right">
                                        <ul class="hm-menu">
                                            <!-- Begin Header Mini Cart Area -->
                                            <li class="hm-minicart" style="width: auto">
                                                @php
                                                    $carts = Cart::where('idUser', Auth::id())->get();
                                                    $total = 0;
                                                @endphp
                                                <div class="hm-minicart-trigger">
                                                    <span class="item-icon"></span>
                                                    <span class="item-text">TOTAL
                                                        <span class="cart-item-count">{{ count($carts) }}</span>
                                                    </span>
                                                </div>
                                                <span></span>
                                                <div class="minicart">
                                                    <ul class="minicart-product-list">
                                                        @foreach($carts as $cart)
                                                            <li>
                                                                <a href="{{ url('/shop/products/' . $cart->product->id) }}" class="minicart-product-image" style="border: none">
                                                                    <img src="data:image/jpeg;base64,{{ $cart->product->thumbnail }}">
                                                                </a>
                                                                <div class="minicart-product-details">
                                                                    <h6><a href="{{ url('/shop/products/' . $cart->product->id) }}">{{ $cart->product->name }}</a></h6>
                                                                    <span>{{ $cart->product->price }}€ x {{ $cart->quantity }}</span>
                                                                </div>
                                                                <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                                data-bs-target="#deleteElement" data-type="product <span style='font-weight: 400'>from cart</span>"
                                                data-name="{{ $cart->product->name }} <span style='font-weight: 400'>from your cart</span>" data-url="{{ url('/cart/' . $cart->id) }}">
                                                    <button class="material-icons delete-button">&#xE5C9;</button>
                                                </a>
                                                            </li>
                                                            @php $total += ($cart->product->price * $cart->quantity); @endphp
                                                        @endforeach
                                                    </ul>
                                                    @if(count($carts) > 0)
                                                        <p class="minicart-total">SUBTOTAL: <span>{{ $total }}€</span></p>
                                                        <div class="minicart-button">
                                                            <a href="{{ url('/cart') }}" class="li-button li-button-fullwidth li-button-dark">
                                                                <span>View Full Cart</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                            <!-- Header Mini Cart Area End Here -->
                                        </ul>
                                    </div>
                                @endif
                                <!-- Header Middle Right Area End Here -->
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                    </div>
                </div>
                <!-- Header Middle Area End Here -->
                <!-- Begin Header Bottom Area -->
                <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Begin Header Bottom Menu Area -->
                                <div class="hb-menu">
                                    <nav>
                                        <ul>
                                            @yield('navItems')
                                        </ul>
                                    </nav>
                                </div>
                                <!-- Header Bottom Menu Area End Here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Header Bottom Area End Here -->
                <!-- Begin Mobile Menu Area -->
                <div class="mobile-menu-area d-lg-none d-xl-none col-12">
                    <div class="container"> 
                        <div class="row">
                            <div class="mobile-menu">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Area End Here -->
            </header>
            
            @error('message')
                <div class="alert alert-danger message-alert"><p class="container">{{ $message }}</p></div>
            @enderror
        
            @if(session('message'))
                <div class="alert alert-success message-alert"><p class="container">{{ session('message') }}</p></div>
            @endif
            
            @yield('content')
            
            <!-- Li's Trendding Products Area End Here -->
            <!-- Begin Footer Area -->
            <div class="footer">
                <!-- Begin Footer Static Top Area -->
                <div class="footer-static-top">
                    <div class="container">
                        <!-- Begin Footer Shipping Area -->
                        <div class="footer-shipping pt-60 pb-55 pb-xs-25">
                            <div class="row">
                                <!-- Begin Li's Shipping Inner Box Area -->
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                                    <div class="li-shipping-inner-box">
                                        <div class="shipping-icon">
                                            <img src="{{ url("/assets/images/shipping-icon/1.png") }}" alt="Shipping Icon">
                                        </div>
                                        <div class="shipping-text">
                                            <h2>Free Delivery</h2>
                                            <p>And free returns. See checkout for delivery dates.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Li's Shipping Inner Box Area End Here -->
                                <!-- Begin Li's Shipping Inner Box Area -->
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                                    <div class="li-shipping-inner-box">
                                        <div class="shipping-icon">
                                            <img src="{{ url("/assets/images/shipping-icon/2.png") }}" alt="Shipping Icon">
                                        </div>
                                        <div class="shipping-text">
                                            <h2>Safe Payment</h2>
                                            <p>Pay with the world's most popular and secure payment methods.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Li's Shipping Inner Box Area End Here -->
                                <!-- Begin Li's Shipping Inner Box Area -->
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                                    <div class="li-shipping-inner-box">
                                        <div class="shipping-icon">
                                            <img src="{{ url("/assets/images/shipping-icon/3.png") }}" alt="Shipping Icon">
                                        </div>
                                        <div class="shipping-text">
                                            <h2>Shop with Confidence</h2>
                                            <p>Our Buyer Protection covers your purchasefrom click to delivery.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Li's Shipping Inner Box Area End Here -->
                                <!-- Begin Li's Shipping Inner Box Area -->
                                <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                                    <div class="li-shipping-inner-box">
                                        <div class="shipping-icon">
                                            <img src="{{ url("/assets/images/shipping-icon/4.png") }}" alt="Shipping Icon">
                                        </div>
                                        <div class="shipping-text">
                                            <h2>24/7 Help Center</h2>
                                            <p>Have a question? Call a Specialist or chat online.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Li's Shipping Inner Box Area End Here -->
                            </div>
                        </div>
                        <!-- Footer Shipping Area End Here -->
                    </div>
                </div>
                <!-- Footer Static Top Area End Here -->
                <!-- Begin Footer Static Middle Area -->
                <div class="footer-static-middle">
                    <div class="container">
                        <div class="footer-logo-wrap pt-50 pb-35">
                            <div class="row">
                                <!-- Begin Footer Logo Area -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="footer-logo">
                                        <img src="{{ url("/assets/images/menu/logo/1.jpg") }}" alt="Footer Logo">
                                        <p class="info">
                                            We are a team that provides products to all our customers since 2001. We are proud of our work done.
                                        </p>
                                    </div>
                                    <ul class="des">
                                        <li>
                                            <span>Address: </span>
                                            Noones care Road, Spain, Granada 18053
                                        </li>
                                        <li>
                                            <span>Phone: </span>
                                            <a href="#">(+34) 727 733 353</a>
                                        </li>
                                        <li>
                                            <span>Email: </span>
                                            <a href="mailto://pvalgarn@gmail.com">pvalgarn@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Footer Block Area End Here -->
                                <!-- Begin Footer Block Area -->
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="footer-block">
                                        <h3 class="footer-block-title">Our company</h3>
                                        <ul>
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            <li><a href="shop">Shop</a></li>
                                            <li><a href="about">About us</a></li>
                                            <li><a href="contact">Contact us</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Footer Logo Area End Here -->
                                <!-- Begin Footer Block Area -->
                                <div class="col-lg-2 col-md-3 col-sm-6">
                                    <div class="footer-block">
                                        <h3 class="footer-block-title">Product</h3>
                                        <ul>
                                            <li><a href="#">Prices drop</a></li>
                                            <li><a href="#">New products</a></li>
                                            <li><a href="#">Best sales</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Footer Block Area End Here -->
                                <!-- Begin Footer Block Area -->
                                <div class="col-lg-4">
                                    <!-- Begin Footer Newsletter Area -->
                                    <div class="footer-newsletter">
                                        <h4>Sign up to newsletter</h4>
                                        <form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="footer-subscribe-form validate" target="_blank" novalidate>
                                           <div id="mc_embed_signup_scroll">
                                              <div id="mc-form" class="mc-form subscribe-form form-group" >
                                                <input id="mc-email" type="email" autocomplete="off" placeholder="Enter your email" />
                                                <button  class="btn" id="mc-submit">Subscribe</button>
                                              </div>
                                           </div>
                                        </form>
                                    </div>
                                    <!-- Footer Newsletter Area End Here -->
                                </div>
                                <!-- Footer Block Area End Here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Static Middle Area End Here -->
                <!-- Begin Footer Static Bottom Area -->
                <div class="footer-static-bottom pt-55 pb-55">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Footer Links Area End Here -->
                                <!-- Begin Footer Payment Area -->
                                <div class="copyright text-center">
                                    <a href="#">
                                        <img src="{{ url("/assets/images/payment/1.png") }}" alt="">
                                    </a>
                                </div>
                                <!-- Footer Payment Area End Here -->
                                <!-- Begin Copyright Area -->
                                <div class="copyright text-center pt-25">
                                    <span><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></span>
                                </div>
                                <!-- Copyright Area End Here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Static Bottom Area End Here -->
            </div>
            <!-- Footer Area End Here -->
        </div>
        
        @if(Auth::user())
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/63ee7be4c2f1ac1e2033b6f7/1gpdp7t86';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
        @endif
        
        <!-- Body Wrapper End Here -->
        <!-- jQuery-V1.12.4 -->
        <script src="{{ url("/assets/js/vendor/jquery-1.12.4.min.js") }}"></script>
        <!-- Popper js -->
        <script src="{{ url("/assets/js/vendor/popper.min.js") }}"></script>
        <!-- Bootstrap V4.1.3 Fremwork js -->
        <script src="{{ url("/assets/js/bootstrap.min.js") }}"></script>
        <!-- Ajax Mail js -->
        <script src="{{ url("/assets/js/ajax-mail.js") }}"></script>
        <!-- Meanmenu js -->
        <script src="{{ url("/assets/js/jquery.meanmenu.min.js") }}"></script>
        <!-- Wow.min js -->
        <script src="{{ url("/assets/js/wow.min.js") }}"></script>
        <!-- Slick Carousel js -->
        <script src="{{ url("/assets/js/slick.min.js") }}"></script>
        <!-- Owl Carousel-2 js -->
        <script src="{{ url("/assets/js/owl.carousel.min.js") }}"></script>
        <!-- Magnific popup js -->
        <script src="{{ url("/assets/js/jquery.magnific-popup.min.js") }}"></script>
        <!-- Isotope js -->
        <script src="{{ url("/assets/js/isotope.pkgd.min.js") }}"></script>
        <!-- Imagesloaded js -->
        <script src="{{ url("/assets/js/imagesloaded.pkgd.min.js") }}"></script>
        <!-- Mixitup js -->
        <script src="{{ url("/assets/js/jquery.mixitup.min.js") }}"></script>
        <!-- Countdown -->
        <script src="{{ url("/assets/js/jquery.countdown.min.js") }}"></script>
        <!-- Counterup -->
        <script src="{{ url("/assets/js/jquery.counterup.min.js") }}"></script>
        <!-- Waypoints -->
        <script src="{{ url("/assets/js/waypoints.min.js") }}"></script>
        <!-- Barrating -->
        <script src="{{ url("/assets/js/jquery.barrating.min.js") }}"></script>
        <!-- Jquery-ui -->
        <script src="{{ url("/assets/js/jquery-ui.min.js") }}"></script>
        <!-- Venobox -->
        <script src="{{ url("/assets/js/venobox.min.js") }}"></script>
        <!-- ScrollUp js -->
        <script src="{{ url("/assets/js/scrollUp.min.js") }}"></script>
        <!-- Main/Activator js -->
        <script src="{{ url("/assets/js/main.js") }}"></script>
        <!-- Admin JS -->
        <script src="{{ url("/assets/js/core/popper.min.js") }}"></script>
        <script src="{{ url("/assets/js/core/bootstrap.min.js") }}"></script>
        <script src="{{ url("/assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
        <script src="{{ url("/assets/js/plugins/smooth-scrollbar.min.js") }}"></script>
        <script src="{{ url("/assets/js/plugins/chartjs.min.js") }}"></script>
        <script src="{{ url("/assets/js/mine.js") }}"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
              var options = {
                damping: '0.5'
              }
              Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <script>
            $(document).ready(function(){
            	// Delete row on delete button click
            	$(document).on("click", ".delete", function(){
            	    setTimeout(() => {
            	        $(this).parents("tr").remove();
            		    $(".add-new").removeAttr("disabled");
            	    }, 10);
                });
            });
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ url("/assets/js/soft-ui-dashboard.min.js") }}"></script>
        <script src="{{ url('/assets/js/ajax.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        @yield('scripts')
    </body>
</html>