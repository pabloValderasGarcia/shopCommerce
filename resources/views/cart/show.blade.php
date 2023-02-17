@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}" class="active">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<!--Shopping Cart Area Strat-->
<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(count($carts) > 0)
                    <form action="{{ url('/cart/' . $carts[0]->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="table-content table-responsive" style="margin-top: 0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name" style="width: 2em">Product</th>
                                        <th class="cart-product-name" style="width: 6em">Name</th>
                                        <th class="li-product-price" style="width: 2.5em">Unit Price</th>
                                        <th class="li-product-price" style="width: 2.5em">Stock</th>
                                        <th class="li-product-quantity" style="width: 2.5em">Quantity</th>
                                        <th class="li-product-subtotal" style="width: 2.5em">Total</th>
                                        <th class="li-product-remove" style="width: 1.5em">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach($carts as $cart)
                                        <tr>
                                            <td class="li-product-name"><a href="{{ url('/shop/products/' . $cart->product->id) }}"><img class="avatar" style="object-fit: contain; width: 3.5em" src="data:image/jpeg;base64,{{ $cart->product->thumbnail }}"></a></td>
                                            <td class="li-product-name"><a href="{{ url('/shop/products/' . $cart->product->id) }}">{{ $cart->product->name }}</a></td>
                                            <td class="li-product-price"><span class="amount">{{ $cart->product->price }}€</span></td>
                                            <td class="li-product-price"><span class="amount" @if($cart->product->stock < 30) style="color: #e80f0f" @endif>{{ $cart->product->stock }}</span></td>
                                            <td class="quantity">
                                                <input id="cart-{{ $cart->id }}" max="{{ $cart->product->stock }}" name="quantity_{{$cart->id}}" value="{{ $cart->quantity }}" type="number" style="width: 70%"/>
                                            </td>
                                            <td class="product-subtotal"><span class="amount">{{ $cart->product->price * $cart->quantity }}€</span></td>
                                            <td class="li-product-remove">
                                                <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                                data-bs-target="#deleteElement" data-type="product <span style='font-weight: 400'>from cart</span>"
                                                data-name="{{ $cart->product->name }} <span style='font-weight: 400'>from your cart</span>" data-url="{{ url('/cart/' . $cart->id) }}">
                                                    <button class="material-icons delete-button">&#xE5C9;</button>
                                                </a>
                                            </td>
                                        </tr>
                                        @php $subtotal += ($cart->product->price * $cart->quantity); @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="cart-page-total pt-0">
                                                <h2>Cart totals</h2>
                                                <ul>
                                                    <li style="font-weight: 400">Vat <span>21%</span></li>
                                                    <li style="font-weight: 400">Subtotal <span>{{ $subtotal }}€</span></li>
                                                    <li>Total <span>{{ $total = ($subtotal + ($subtotal * 0.21)) }}€</span></li>
                                                </ul>
                                                <div id="paypal-button-container"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="coupon2">
                                                <input class="button" name="update_cart" value="Update cart" type="submit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    NO TIENES
                @endif
            </div>
        </div>
    </div>
</div>
<!--Shopping Cart Area End-->

@endsection

@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id=AcoDg8Lzq6Ca_og-4KfyA5ghZqVi7QIxJomSxlr--V5KRAUcErDqJp379_vJ44eNrlUSXBitaXtLXk21&disable-funding=card,sofort"></script>
    
    <script>
      paypal.Buttons({
        // Order is created on the server and the order id is returned
        createOrder: function(data, actions) {
          return actions.order.create({
              purchase_units: [{
                  amount: {
                      value: '{{ $total }}'
                  }
              }]
          })
        },
        // Finalize the transaction on the server after payer approval
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
              alert('transaction completed');
          })
        }
      }).render('#paypal-button-container');
    </script>
@endsection